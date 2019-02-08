<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 2019-02-06
 * Time: 12:03
 */

namespace floor12\notifications\interfaces;

use yii\db\ActiveQueryInterface;

interface NotificationQueryInterface extends ActiveQueryInterface
{
    /**
     * @return NotificationQuery
     */
    public function byOwner(int $owner_id);

    /**
     * @return NotificationQuery
     */
    public function unreaded();

    /**
     * @return NotificationQuery
     */
    public function unmailed();
}