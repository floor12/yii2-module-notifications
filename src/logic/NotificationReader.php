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
use yii\base\ErrorException;
use yii\web\BadRequestHttpException;

class NotificationReader
{

    protected $model;

    public function __construct(NotificationInterface $model)
    {
        $this->model = $model;
        if (!$model->isUnreaded())
            throw new BadRequestHttpException(Yii::t('app.f12.notifications', 'This notifications is already readed.'));
    }

    /**
     * @return bool
     * @throws ErrorException
     */
    public function execute()
    {
        $this->model->setAttribute('readed', time());
        return $this->model->save(true, ['readed']);
    }


}