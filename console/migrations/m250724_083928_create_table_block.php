<?php

use yii\db\Migration;

class m250724_083928_create_table_block extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%block}}',
            [
                'id' => $this->primaryKey(),
                'enabled' => $this->boolean()->notNull()->defaultValue('1'),
                'block_type' => $this->integer(),
                'block_tag' => $this->string(),
                'class' => $this->string(),
                'block_name' => $this->string()->notNull(),
                'title' => $this->string(),
                'is_h1' => $this->boolean(),
                'text_preview' => $this->text(),
                'text' => $this->text(),
                'id_image' => $this->integer(),
                'id_image_mob' => $this->integer(),
                'img_side' => $this->boolean(),
                'images' => $this->text(),
                'is_slider' => $this->boolean(),
                'pdf' => $this->string(),
                'cta' => $this->string(),
                'ord' => $this->integer(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ],
            $tableOptions
        );

        $this->createIndex('id_image', '{{%block}}', ['id_image']);
        $this->createIndex('id_image_mob', '{{%block}}', ['id_image_mob']);

        $this->addForeignKey(
            'block_ibfk_2',
            '{{%block}}',
            ['id_image'],
            '{{%image}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'block_ibfk_3',
            '{{%block}}',
            ['id_image_mob'],
            '{{%image}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%block}}');
    }
}
