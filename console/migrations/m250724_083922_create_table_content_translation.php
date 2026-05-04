<?php

use yii\db\Migration;

class m250724_083922_create_table_content_translation extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%content_translation}}',
            [
                'id' => $this->primaryKey(),
                'model' => $this->string()->notNull(),
                'model_id' => $this->integer()->notNull(),
                'language' => $this->string(10)->notNull(),
                'attribute' => $this->string()->notNull(),
                'value' => $this->text(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%content_translation}}');
    }
}
