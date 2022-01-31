<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 */
class m211028_085742_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id_message' => $this->primaryKey(),
            'user_id' => $this->integer()->defaultValue(0),
            'user_name' => $this->string(50)->notNull(),
            'user_email' => $this->string(100)->notNull(),
            'homepage' => $this->string(255),
            'text' => $this->string(4000)->notNull(),
            'file_path' => $this->string(150),
            'user_ip' => $this->integer(),
            'user_agent' => $this->string(254),
            'created_at' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%message}}');
    }
}
