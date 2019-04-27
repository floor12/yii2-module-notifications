<?php


namespace floor12\notifications\logic;


use floor12\notifications\interfaces\NotificationInterface;
use floor12\notifications\interfaces\NotificationOwnerInterface;
use floor12\notifications\models\Notification;
use Yii;
use yii\base\InvalidParamException;

class NotificationReadAll
{

    protected $identity;

    protected $classname;

    /**
     * NotificationReadAll constructor.
     * @param NotificationOwnerInterface $model
     */
    public function __construct(NotificationOwnerInterface $identity)
    {
        $this->classname = Yii::$app->getModule('notifications')->notificationClass;

        $reflection = new \ReflectionClass($this->classname);
        if (!$reflection->implementsInterface(NotificationInterface::class))
            throw new InvalidParamException('Notification object must implements NotificationInterface');

        $this->identity = $identity;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return $this->classname::updateAll(['readed' => time()], ['owner_id' => $this->identity->getId()]);
    }

}