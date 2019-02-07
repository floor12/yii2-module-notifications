<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 2019-02-06
 * Time: 19:27
 *
 * @var $this \yii\web\View
 * @var $model \floor12\notifications\models\NotificationFilter
 */

use floor12\editmodal\EditModalHelper;
use floor12\notifications\interfaces\NotificationInterface;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = Yii::t('app.f12.notifications', 'Notifications');
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin([
    'method' => 'GET',
    'options' => ['class' => 'autosubmit', 'data-container' => '#items'],
    'enableClientValidation' => false,
]); ?>
    <h1><?= $this->title ?></h1>
    <div class="filter-block">
        <div class="row">
            <div class="col-md-9">
                <?= $form->field($model, 'filter')->label(false)->textInput([
                    'placeholder' => Yii::t('app.f12.notifications', 'Search in notifications'),
                    'autofocus' => true
                ]) ?>
            </div>
            <div class="col-md-3" style="padding-top: 5px;">
                <?= $form->field($model, 'unreaded')->checkbox() ?>
            </div>
        </div>
    </div>

<?php
ActiveForm::end();


Pjax::begin(['id' => 'items']); ?>

<?= GridView::widget([
    'dataProvider' => $model->dataProvider(),
    'layout' => '{items}{pager}{summary}',
    'rowOptions' => function (NotificationInterface $model) {
        if ($model->isUnreaded())
            return ['style' => 'font-weight:bold;'];
    },
    'tableOptions' => ['class' => 'table'],
    'columns' => [
        ['class' => SerialColumn::class],
        'created:datetime',
        [
            'attribute' => 'body',
            'content' => function (NotificationInterface $model) {
                return Html::a($model->getBodyTrancated(14), null, [
                    'onclick' => EditModalHelper::showForm(['/notifications/default/view'], $model->getPrimaryKey())
                ]);
            }
        ],
    ],
]); ?>
<?php Pjax::end(); ?>