<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 2019-02-06
 * Time: 13:20
 */

namespace floor12\notifications\logic;


use floor12\notifications\interfaces\NotificationInterface;
use floor12\notifications\interfaces\NotificationOwnerInterface;
use Yii;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;

class NotificationEmailSender
{

    /**
     * @var NotificationInterface
     */
    protected $model;

    /**
     * @var NotificationOwnerInterface
     */
    protected $owner;


    /**
     * NotificationEmailSender constructor.
     * @param NotificationInterface $model
     * @throws ErrorException
     */
    public function __construct(NotificationInterface $model)
    {

        if (empty(Yii::$app->params['no-replyEmail']))
            throw new InvalidConfigException('Param `no-replyEmail` not found in current app.');

        if (empty(Yii::$app->params['no-replyEmail']))
            throw new InvalidConfigException('Param `no-replyEmail` not found in current app.');

        Yii::$app->getModule('notifications');

        $this->model = $model;

        if (!$model->isUnreaded())
            throw new ErrorException('This notifications is already readed.');

        if ($model->isEmailed())
            throw new ErrorException('This notifications is already mailed.');

        $this->owner = $this->model->getOwner();

        if (!$this->owner)
            throw new ErrorException("Notification owner {$this->model->getAttribute('owner_id')} is not found.");
    }

    /**
     * @return bool
     * @throws ErrorException
     */
    public function execute()
    {
        $this->sendEmail();

        $this->model->setAttribute('mailed', time());
        $this->model->setAttribute('email', $this->owner->getEmail());

        return $this->model->save(true, ['email', 'mailed']);
    }

    /**
     * @throws ErrorException
     */
    protected function sendEmail()
    {
        $email = Yii::$app
            ->mailer
            ->compose(
                ['html' => "@vendor/floor12/yii2-module-notifications/src/mail/new-notification-html.php"],
                ['notification' => $this->model, 'owner' => $this->owner]
            )
            ->setFrom([Yii::$app->params['no-replyEmail'] => Yii::$app->params['no-replyEmail']])
            ->setSubject(Yii::t('app.f12.notifications', 'You have new notification'))
            ->setTo($this->owner->getEmail());

        if (!$email->send())
            throw new ErrorException("Error while sending email to {$this->owner->getEmail()}");

    }


}