<?php

use yii\db\Migration;

class m250724_083923_create_table_image extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%image}}',
            [
                'id' => $this->primaryKey(),
                'img_name' => $this->string()->notNull(),
                'img_show_name' => $this->string(),
                'img_description' => $this->text(),
                'img_extension' => $this->string(11)->notNull(),
                'img_width' => $this->integer(),
                'img_height' => $this->integer(),
                'img_content_type' => $this->string(),
                'img_content_size' => $this->integer(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%image}}');
    }
}
