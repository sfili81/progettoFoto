<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $img_name
 * @property string|null $img_show_name
 * @property string|null $img_description
 * @property string $img_extension
 * @property int|null $img_width
 * @property int|null $img_height
 * @property string|null $img_content_type
 * @property int|null $img_content_size
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Block[] $blocks
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['img_name', 'img_extension'], 'required'],
            [['img_description'], 'string'],
            [['img_width', 'img_height', 'img_content_size', 'created_at', 'updated_at'], 'integer'],
            [['img_name', 'img_show_name', 'img_content_type'], 'string', 'max' => 255],
            [['img_extension'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'img_name' => Yii::t('backend', 'Img Name'),
            'img_show_name' => Yii::t('backend', 'Img Show Name'),
            'img_description' => Yii::t('backend', 'Img Description'),
            'img_extension' => Yii::t('backend', 'Img Extension'),
            'img_width' => Yii::t('backend', 'Img Width'),
            'img_height' => Yii::t('backend', 'Img Height'),
            'img_content_type' => Yii::t('backend', 'Img Content Type'),
            'img_content_size' => Yii::t('backend', 'Img Content Size'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Blocks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks()
    {
        return $this->hasMany(Block::class, ['id_image' => 'id']);
    }
}
