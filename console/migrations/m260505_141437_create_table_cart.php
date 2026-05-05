<?php

use yii\db\Migration;

class m260505_141437_create_table_cart extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%cart}}',
            [
                'id' => $this->primaryKey(),
                'state' => $this->integer()->notNull(),
                'email' => $this->string()->notNull(),
                'code' => $this->string()->notNull(),
                'list_images' => $this->json()->notNull(),
                'note' => $this->text(),
                'internal_details' => $this->text(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%cart}}');
    }
}
