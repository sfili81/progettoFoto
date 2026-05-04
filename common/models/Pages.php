<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $pages_name Indica il nome della pagina
 * @property string $pages_tag Indica il tipo di pagina ovvero il modello di riferimento
 
 * @property int $pages_visibility Indica se la pagina è visibile oppure no
 * @property string|null $pages_meta_description
 * @property string|null $pages_meta_keywords
 * @property string|null $pages_meta_title
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Pages extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }

    public function behaviors( ) {
	    return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],    
            //Sortable --> da installare
	        /*[
	            'class' => 'sjaakp\sortable\Sortable',
                'orderAttribute' => 'pages_ord',
	        ],*/
	    ];
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pages_name', 'pages_tag'], 'required'],
            [['pages_visibility', 'created_at', 'updated_at'], 'integer'],
            [['pages_meta_description', 'pages_meta_keywords'], 'string'],
            [['pages_name', 'pages_tag','pages_meta_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'pages_name' => Yii::t('backend', 'Pages Name'),
            'pages_tag' => Yii::t('backend', 'Pages Tag'),
            'pages_visibility' => Yii::t('backend', 'Pages Visibility'),
            'pages_meta_description' => Yii::t('backend', 'Pages Meta Description'),
            'pages_meta_keywords' => Yii::t('backend', 'Pages Meta Keywords'),
            'pages_meta_title' => Yii::t('backend', 'Pages Meta Title'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }
    
    /**
     *  Relation with junction table pagesxblock many to many with Block table
     */
    public function getBlocks() {
        return $this->hasMany(Block::class, ['id' => 'id_block'])
        ->viaTable('pagesxblock', ['id_pages' => 'id']);
    }
}
