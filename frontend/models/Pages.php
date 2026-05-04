<?php

namespace frontend\models;

use common\models\Block;

/**
 *
 * @property Block[] $blocks
 */
class Pages extends \common\models\Pages
{
    
    public function getBlocks()
    {
        return $this->hasMany(Block::class, ['id_page' => 'id'])                    
                    ->where(['enabled' => 1])
                    ->orderBy(['ord' => SORT_ASC]);;
    }
}
