<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m211028_081406_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'username' => $this->string(50)->notNull(),
            'homepage' => $this->string(255),
            'email' => $this->string(100)->notNull(),
            'email_confirm_token' => $this->string(255),
            'password' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255),
            'auth_key' => $this->string(255),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
