<?php

namespace floor12\notifications;

use Yii;

class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'floor12\notifications\controllers';
    /**
     * @var string Default controller layout
     */
    public $layout = '@app/views/layouts/main';
    /**
     * @var string User role to read own notifications
     */
    public $userRole = '@';
    /**
     * @var string User role to read notifications of all users
     */
    public $adminRole = 'admin';
    /**
     * @var string Default notification model classname
     */
    public $notificationClass = 'floor12\notifications\models\Notification';
    /**
     * @var string Default notification owner classname
     */
    public $notificationOwnerClass = '\app\models\User';

    /**
     * @var int Timeout to not repeat identical notifications
     */
    public $timeoutRepeat = 60 * 10; // 10 min
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->registerTranslations();
    }
    /**
     *  Register i18n language files
     */
    public function registerTranslations()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['app.f12.notifications'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/floor12/yii2-module-notifications/src/messages',
            'fileMap' => [
                'app.f12.notifications' => 'notifications.php',
            ],
        ];
    }
}
