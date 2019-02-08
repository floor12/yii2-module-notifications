<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 2019-02-06
 * Time: 13:20
 */

namespace floor12\notifications\logic;


use floor12\notifications\interfaces\NotificationInterface;
use Yii;

class NotificationQueueProcessor
{

    /**
     * @var NotificationInterface[]
     */
    protected $models;
    /**
     * @var array Catchet errors description
     */
    protected $errors = [];


    public function __construct()
    {
        $classname = Yii::$app->getModule('notifications')->notificationClass;

        $reflection = new \ReflectionClass($classname);
        if (!$reflection->implementsInterface(NotificationInterface::class))
            throw new InvalidParamException("{$classname} must implements NotificationInterface");

        $this->models = $classname::find()->unreaded()->unmailed()->all();

    }


    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function execute()
    {
        if (!$this->models)
            return true;

        foreach ($this->models as $model)
            try {
                Yii::createObject(NotificationEmailSender::class, [$model])->execute();
            } catch (\ErrorException $exception) {
                $this->errors[] = $exception->getMessage();
            }

        return $this->errors ? false : true;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

}