<?php

use yii\db\Migration;

class m260309_131431_create_table_news extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%news}}',
            [
                'id' => $this->primaryKey(),
                'title' => $this->string()->notNull()->comment('Titolo della news'),
                'slug' => $this->string()->notNull(),
                'subtitle' => $this->string(),
                'date' => $this->date(),
                'preview' => $this->text(),
                'text' => $this->text()->notNull(),
                'id_image_preview' => $this->integer()->comment('ID Immagine anteprima preview'),
                'images' => $this->text(),
                'is_published' => $this->boolean()->notNull()->comment('Indica se la news è pubblicata'),
                'is_visible_homepage' => $this->boolean()->notNull()->defaultValue('0')->comment('Indica se la news è visibile in home page. Deafult è false'),
                'meta_description' => $this->text(),
                'meta_title' => $this->text(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
