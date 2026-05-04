<?php

use yii\db\Migration;

class m250724_083920_create_table_admin extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%admin}}',
            [
                'id' => $this->primaryKey(),
                'username' => $this->string()->notNull(),
                'auth_key' => $this->string(32)->notNull(),
                'password_hash' => $this->string()->notNull(),
                'password_reset_token' => $this->string(),
                'email' => $this->string()->notNull(),
                'status' => $this->smallInteger()->notNull()->defaultValue('10'),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
                'verification_token' => $this->string(),
            ],
            $tableOptions
        );

        $this->createIndex('email', '{{%admin}}', ['email'], true);
        $this->createIndex('password_reset_token', '{{%admin}}', ['password_reset_token'], true);
        $this->createIndex('username', '{{%admin}}', ['username'], true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%admin}}');
    }
}
