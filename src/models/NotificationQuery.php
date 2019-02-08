<?php

namespace floor12\notifications\models;

use floor12\notifications\interfaces\NotificationQueryInterface;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for Notification.
 *
 * @see Notification
 */
class NotificationQuery extends ActiveQuery implements NotificationQueryInterface
{
    /**
     * @return NotificationQuery
     */
    public function byOwner(int $owner_id)
    {
        return $this->andWhere(['owner_id' => $owner_id]);
    }

    /**
     * @return NotificationQuery
     */
    public function unreaded()
    {
        return $this->andWhere('ISNULL(readed)');
    }

    /**
     * @return NotificationQuery
     */
    public function unmailed()
    {
        return $this->andWhere('ISNULL(mailed)');
    }

    /**
     * {@inheritdoc}
     * @return Notification[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Notification|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
