<?php

use yii\db\Migration;

class m250724_083926_create_table_pagesxblock extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%pagesxblock}}',
            [
                'id' => $this->primaryKey(),
                'id_pages' => $this->integer()->notNull(),
                'id_block' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%pagesxblock}}');
    }
}
