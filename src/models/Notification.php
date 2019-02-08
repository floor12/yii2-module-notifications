<?php

namespace floor12\notifications\models;

use floor12\notifications\interfaces\NotificationInterface;
use floor12\notifications\interfaces\NotificationOwnerInterface;
use Yii;
use yii\base\InvalidParamException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property int $owner_id Owned identity id
 * @property int $type Type of notification
 * @property string $body Notification body
 * @property string $url URL to watch additinal information
 * @property string $image Optional image
 * @property string $created Date and time
 * @property int $readed Timestamp of reading
 * @property int $mailed Timestamp of mailing
 * @property string $email Address of mailing
 *
 * @property NotificationOwnerInterface $owner Owner object
 *
 */
class Notification extends ActiveRecord implements NotificationInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner_id', 'body', 'created'], 'required'],
            [['owner_id', 'type', 'readed', 'mailed'], 'integer'],
            [['body'], 'string'],
            [['created'], 'safe'],
            [['url', 'image', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app.f12.notifications', 'ID'),
            'owner_id' => Yii::t('app.f12.notifications', 'Owned identity id'),
            'type' => Yii::t('app.f12.notifications', 'Type of notification'),
            'body' => Yii::t('app.f12.notifications', 'Notification body'),
            'url' => Yii::t('app.f12.notifications', 'URL to watch additinal information'),
            'image' => Yii::t('app.f12.notifications', 'Optional image'),
            'created' => Yii::t('app.f12.notifications', 'Date and time'),
            'readed' => Yii::t('app.f12.notifications', 'Timestamp of reading'),
            'mailed' => Yii::t('app.f12.notifications', 'Timestamp of mailing'),
            'email' => Yii::t('app.f12.notifications', 'Address of mailing'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return NotificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationQuery(get_called_class());
    }

    /**
     * @param int $count Number of words to truncate notification body
     * @return string Trancated body of notification
     */
    public function getBodyTrancated(int $count)
    {
        return StringHelper::truncateWords($this->body, $count);
    }

    /**
     * @return bool
     */
    public function isUnreaded()
    {
        return boolval(!$this->readed);
    }

    /**
     * @return bool Is current notification was send to owner email
     */
    public function isEmailed()
    {
        return boolval($this->mailed);
    }

    /**
     * @return ActiveQuery
     */
    public function getOwner()
    {
        $owner_class = Yii::$app->getModule('notifications')->notificationOwnerClass;

        $reflection = new \ReflectionClass($owner_class);
        if (!$reflection->implementsInterface(NotificationOwnerInterface::class))
            throw new InvalidParamException("{$owner_class} must implements NotificationOwnerInterface");

        return $owner_class::findOne($this->owner_id);
    }
}
