<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 2019-02-06
 * Time: 18:51
 */

namespace floor12\notifications\controllers;

use floor12\editmodal\IndexAction;
use floor12\notifications\logic\NotificationReader;
use floor12\notifications\models\Notification;
use floor12\notifications\models\NotificationAdminFilter;
use floor12\notifications\models\NotificationFilter;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class DefaultController extends \yii\web\Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => [Yii::$app->getModule('notifications')->userRole],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['admin', 'view'],
                        'roles' => [Yii::$app->getModule('notifications')->adminRole],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layout = Yii::$app->getModule('notifications')->layout;
    }

    /**
     * Viewing notification in modal window
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Notification::findOne($id);

        if (!$model || $model->owner_id != Yii::$app->user->id)
            throw new NotFoundHttpException(Yii::t('app.f12.notifications', 'Notification is not found.'));

        if ($model->isUnreaded())
            Yii::createObject(NotificationReader::class, [$model])->execute();

        return $this->renderAjax('_view', ['model' => $model]);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'model' => NotificationFilter::class,
            ],
            'admin' => [
                'class' => IndexAction::class,
                'model' => NotificationAdminFilter::class,
                'view' => 'index_admin'
            ],
        ];
    }
}