<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 2019-02-06
 * Time: 12:03
 */

namespace floor12\notifications\interfaces;

use yii\db\ActiveRecordInterface;

interface NotificationInterface extends ActiveRecordInterface
{
    /**
     * @return NotificationQueryInterface
     */
    public static function find();

    /**
     * @param int $count Number of words to truncate notification body
     * @return string Trancated body of notification
     */

    public function getBodyTrancated(int $count);

    /**
     * @return bool
     */
    public function isUnreaded();
}