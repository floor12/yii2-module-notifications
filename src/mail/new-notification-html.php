<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 08.08.2018
 * Time: 22:21
 *
 * @var $this View
 * @var $notification \floor12\notifications\interfaces\NotificationInterface
 * @var $owner \floor12\notifications\interfaces\NotificationOwnerInterface
 */

use yii\helpers\Html;
use yii\web\View;

?>


<h1><?= Yii::t('app.f12.notifications', 'You have new notification') ?></h1>

<div style="padding: 20px; background-color: #f6f6f6; border: 1px #eee solid;">

    <?= $notification->getAttribute('body') ?>

</div>
<br>
<br>
<?php

if ($notification->getAttribute('url'))
    echo Html::a(Yii::t('app.f12.notifications', 'Click this link to see more.'), $notification->getAttribute('url'));

?>
