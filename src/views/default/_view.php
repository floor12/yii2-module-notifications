<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 2019-02-06
 * Time: 22:09
 *
 * @var $this \yii\web\View
 * @var $model \floor12\notifications\models\Notification
 */

use floor12\editmodal\ModalWindow;
use yii\helpers\Html;

$this->registerJs('$.pjax.reload({container:"#items"});');

?>

<div class="modal-header">
    <div class="pull-right">
        <?= ModalWindow::btnFullscreen() ?>
        <?= ModalWindow::btnClose(null, true) ?>
    </div>
    <h2><?= Yii::t('app.f12.notifications', 'Notification view') ?></h2>
</div>
<div class="modal-body">
    <?= $model->body ?>
</div>

<div class="modal-footer">
    <div class="pull-left"><?= Yii::$app->formatter->asDatetime($model->created) ?></div>
    <?= Html::a(Yii::t('app.f12.notifications', 'Close'), '', ['class' => 'btn btn-default modaledit-disable-silent']) ?>
</div>
