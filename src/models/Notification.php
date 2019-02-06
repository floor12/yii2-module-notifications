<?php

namespace floor12\notifications\models;

use floor12\notifications\interfaces\NotificationInterface;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property int $owner_id Owned identity id
 * @property int $type Type of notification
 * @property string $body Notification body
 * @property string $url URL to watch additinal information
 * @property string $image Optional image
 * @property string $created Creation timestamp
 * @property int $readed Timestamp of reading
 * @property int $mailed Timestamp of mailing
 * @property string $email Address of mailing
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
            'created' => Yii::t('app.f12.notifications', 'Creation timestamp'),
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
}
