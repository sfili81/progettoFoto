<?php

use yii\db\Migration;

class m250724_083925_create_table_pages extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%pages}}',
            [
                'id' => $this->primaryKey(),
                'pages_name' => $this->string()->notNull()->comment('Indica il nome della pagina'),
                'pages_tag' => $this->string()->notNull()->comment('Indica il tipo di pagina ovvero il modello di riferimento
                                        '),
                'pages_ord' => $this->integer(),
                'pages_visibility' => $this->boolean()->notNull()->defaultValue('1')->comment('Indica se la pagina è visibile oppure no'),
                'pages_meta_description' => $this->text(),
                'pages_meta_keywords' => $this->text(),
                'pages_meta_title' => $this->string(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%pages}}');
    }
}
