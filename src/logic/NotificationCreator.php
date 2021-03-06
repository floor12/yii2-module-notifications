<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 2019-02-06
 * Time: 13:20
 */

namespace floor12\notifications\logic;


use floor12\notifications\interfaces\NotificationInterface;
use floor12\notifications\models\NotificationType;
use Yii;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;

class NotificationCreator
{
    /**
     * @var array
     */
    protected $recipient_ids;
    /**
     * @var string
     */
    protected $body;
    /**
     * @var string Classname with NotificationInterface inplementation
     */
    protected $classname;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var int
     */
    protected $type;
    /**
     * @var string
     */
    protected $image;
    /**
     * @var integer
     */
    protected $created;
    /**
     * @var integer
     */
    protected $sender_id;

    /**
     * NotificationCreator constructor.
     * @param array $recipient_ids Array of reciviers indificators.
     * @param string $body Body of notification, allows html.
     * @param array $params Additinal parameters for notification, allowed:
     *  - url - URL of full notification info
     *  - type - Notification type
     *  - created - created timestamp
     *  - image - Notification image URL
     *  - sender_id - Sender id of notification to pass sending to it
     */
    public function __construct(array $recipient_ids, string $body, array $params = [])
    {
        if (!Yii::$app->getModule('notifications'))
            throw new InvalidConfigException('Notification module is not registred in this application.');

        $this->classname = Yii::$app->getModule('notifications')->notificationClass;

        $reflection = new \ReflectionClass($this->classname);
        if (!$reflection->implementsInterface(NotificationInterface::class))
            throw new InvalidParamException('Notification object must implements NotificationInterface');

        $this->loadParams($params);
        $this->recipient_ids = $recipient_ids;
        $this->body = $body;
    }

    /**
     * @return bool
     * @throws ErrorException
     */
    public function execute()
    {
        if (!$this->recipient_ids)
            return true;

        foreach ($this->recipient_ids as $recipient_id) {

            // Skip author of current notification
            if ($recipient_id == $this->sender_id)
                continue;

            // Skip if previous identical unreaded notification exists
            if ($this->findPrevious($recipient_id))
                continue;
            /**
             * @var NotificationInterface
             */
            $model = new $this->classname([
                'owner_id' => $recipient_id,
                'type' => $this->type,
                'body' => $this->body,
                'url' => $this->url,
                'image' => $this->image,
                'created' => $this->created
            ]);

            if (!$model->save())
                throw new ErrorException("Unexpected error while saving notification.");
        }
        return true;
    }

    /**
     * @param $recipient_id
     * @return NotificationInterface|null
     */
    protected function findPrevious($recipient_id)
    {
        return $this->classname::find()
            ->andWhere([
                'owner_id' => $recipient_id,
                'type' => $this->type,
                'body' => $this->body,
            ])
            ->andWhere('ISNULL(readed)')
            ->andWhere(['>=', 'created', time() - Yii::$app->getModule('notifications')->timeoutRepeat])->one();
    }

    /**
     * @param array $params
     */
    protected function loadParams(array $params)
    {
        $this->url = array_key_exists('url', $params) ? $params['url'] : NULL;

        $this->image = array_key_exists('image', $params) ? $params['image'] : NULL;

        $this->created = array_key_exists('created', $params) ? $params['created'] : time();

        $this->type = array_key_exists('type', $params) ? $params['type'] : NotificationType::INFO;

        $this->sender_id = array_key_exists('sender_id', $params) ? $params['sender_id'] : NULL;
    }

}