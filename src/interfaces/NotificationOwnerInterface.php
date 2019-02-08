<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 2019-02-06
 * Time: 12:03
 */

namespace floor12\notifications\interfaces;

use yii\db\ActiveRecordInterface;

interface NotificationOwnerInterface extends ActiveRecordInterface
{
    /**
     * @return string Owner email address
     */
    public function getEmail();

    /**
     * @return string Owner name to use in email notifications
     */
    public function getName();


}