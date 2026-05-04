<?php

use yii\db\Migration;

class m250724_083921_create_table_companydetails extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%companydetails}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'address' => $this->text(),
                'cap' => $this->integer(),
                'city' => $this->string(),
                'email' => $this->string(),
                'phone' => $this->string(50),
                'phone_mobile' => $this->string(55),
                'whatsapp' => $this->string(55),
                'pec' => $this->string(),
                'p_iva' => $this->string(128),
                'social_capital' => $this->string(158),
                'rea' => $this->string(),
                'facebook' => $this->string(),
                'instagram' => $this->string(),
                'youtube' => $this->string(),
                'og_title' => $this->string(),
                'og_url' => $this->string(),
                'og_description' => $this->string(),
                'og_image' => $this->string(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%companydetails}}');
    }
}
