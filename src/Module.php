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
     * @var string Default notification model
     */
    public $notificationModel = 'floor12\notifications\models\Notification';

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
        $i18n->translations['notifications'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/floor12/yii2-module-notifications/src/messages',
        ];
    }
}
