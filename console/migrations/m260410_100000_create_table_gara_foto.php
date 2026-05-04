<?php

use yii\db\Migration;

/**
 * Tabella pivot tra i nodi foglia dell'albero gara e le foto caricate (tabella image).
 */
class m260410_100000_create_table_gara_foto extends Migration
{
    public function safeUp()
    {
        $this->createTable('gara_foto', [
            'id'         => $this->primaryKey(),
            'gara_id'    => $this->integer()->notNull()->comment('FK → gara.id (nodo foglia)'),
            'image_id'   => $this->integer()->notNull()->comment('FK → image.id'),
            'created_at' => $this->integer()->null(),
        ]);

        $this->createIndex('idx_gara_foto_gara_id',  'gara_foto', 'gara_id');
        $this->createIndex('idx_gara_foto_image_id', 'gara_foto', 'image_id');
    }

    public function safeDown()
    {
        $this->dropTable('gara_foto');
    }
}
