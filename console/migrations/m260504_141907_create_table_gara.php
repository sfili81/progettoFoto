<?php

use yii\db\Migration;

class m260504_141907_create_table_gara extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%gara}}',
            [
                'id' => $this->primaryKey(),
                'root' => $this->integer(),
                'lft' => $this->integer()->notNull(),
                'rgt' => $this->integer()->notNull(),
                'lvl' => $this->smallInteger()->notNull(),
                'name' => $this->string(60)->notNull(),
                'icon' => $this->string(),
                'icon_type' => $this->boolean()->notNull()->defaultValue('1'),
                'active' => $this->boolean()->notNull()->defaultValue('1'),
                'selected' => $this->boolean()->notNull()->defaultValue('0'),
                'disabled' => $this->boolean()->notNull()->defaultValue('0'),
                'readonly' => $this->boolean()->notNull()->defaultValue('0'),
                'visible' => $this->boolean()->notNull()->defaultValue('1'),
                'collapsed' => $this->boolean()->notNull()->defaultValue('0'),
                'movable_u' => $this->boolean()->notNull()->defaultValue('1'),
                'movable_d' => $this->boolean()->notNull()->defaultValue('1'),
                'movable_l' => $this->boolean()->notNull()->defaultValue('1'),
                'movable_r' => $this->boolean()->notNull()->defaultValue('1'),
                'removable' => $this->boolean()->notNull()->defaultValue('1'),
                'removable_all' => $this->boolean()->notNull()->defaultValue('0'),
                'child_allowed' => $this->boolean()->notNull()->defaultValue('0'),
            ],
            $tableOptions
        );

        $this->createIndex('tbl_product_NK1', '{{%gara}}', ['root']);
        $this->createIndex('tbl_product_NK2', '{{%gara}}', ['lft']);
        $this->createIndex('tbl_product_NK3', '{{%gara}}', ['rgt']);
        $this->createIndex('tbl_product_NK4', '{{%gara}}', ['lvl']);
        $this->createIndex('tbl_product_NK5', '{{%gara}}', ['active']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%gara}}');
    }
}
