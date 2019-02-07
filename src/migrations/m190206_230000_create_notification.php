<?php

use floor12\notifications\models\NotificationType;
use yii\db\Migration;

/**
 * Class m190206_230000_create_notification
 */
class m190206_230000_create_notification extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%notification}}', [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer()->notNull()->comment('Owned identity id'),
            'type' => $this->integer()->notNull()->defaultValue(NotificationType::INFO)->comment('Type of notification'),
            'body' => $this->text()->notNull()->comment('Notification body'),
            'url' => $this->string(255)->null()->comment('URL to watch additinal information'),
            'image' => $this->string(255)->null()->comment('Optional image'),
            'created' => $this->integer()->notNull()->comment('Date adn time'),
            'readed' => $this->integer()->null()->comment('Timestamp of reading'),
            'mailed' => $this->integer()->null()->comment('Timestamp of mailing'),
            'email' => $this->string(255)->null()->comment('Address of mailing'),
        ], $tableOptions);

        $this->createIndex('idx-notification-owner_id', '{{%notification}}', 'owner_id');
        $this->createIndex('idx-notification-created', '{{%notification}}', 'created');
        $this->createIndex('idx-notification-readed', '{{%notification}}', 'readed');
        $this->createIndex('idx-notification-mailed', '{{%notification}}', 'mailed');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%notification}}');
    }


}
