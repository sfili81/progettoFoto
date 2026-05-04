<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "block".
 *
 * @property int $id
 * @property int $enabled
 * @property int|null $block_type
 * @property string|null $block_tag
 * @property string|null $class
 * @property string $block_name
 * @property string|null $title
 * @property int|null $is_h1
 * @property string|null $text_preview
 * @property string|null $text
 * @property int|null $id_image
 * @property int|null $id_image_mobs
 * @property int|null $img_side
 * @property string|null $images
 * @property int|null $is_slider
 * @property string|null $pdf
 * @property string|null $cta
 * @property int|null $ord
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Images $image
 * @property Pages $page
 */
class Block extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enabled', 'block_type', 'is_h1', 'id_image', 'id_image_mob', 'img_side', 'is_slider', 'ord', 'created_at', 'updated_at'], 'integer'],
            [['block_name'], 'required'],
            [['text_preview', 'text', 'images'], 'string'],
            [['block_tag', 'class', 'block_name', 'title', 'pdf', 'cta'], 'string', 'max' => 255],
            [['id_image'], 'exist', 'skipOnError' => true, 'targetClass' => Images::class, 'targetAttribute' => ['id_image' => 'id']],
            [['id_image_mob'], 'exist', 'skipOnError' => true, 'targetClass' => Images::class, 'targetAttribute' => ['id_image_mob' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'enabled' => Yii::t('backend', 'Enabled'),
            'block_type' => Yii::t('backend', 'Block Type'),
            'block_tag' => Yii::t('backend', 'Block Tag'),
            'class' => Yii::t('backend', 'Class'),
            'block_name' => Yii::t('backend', 'Block Name'),
            'title' => Yii::t('backend', 'Title'),
            'is_h1' => Yii::t('backend', 'Is H1'),
            'text_preview' => Yii::t('backend', 'Text Preview'),
            'text' => Yii::t('backend', 'Text'),
            'id_image' => Yii::t('backend', 'Id Image'),
            'id_image_mob' => Yii::t('app', 'Id Image Mob'),
            'img_side' => Yii::t('backend', 'Img Side'),
            'images' => Yii::t('backend', 'Images'),
            'is_slider' => Yii::t('backend', 'Is Slider'),
            'pdf' => Yii::t('backend', 'Pdf'),
            'cta' => Yii::t('backend', 'Cta'),
            'ord' => Yii::t('backend', 'Ord'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Images::class, ['id' => 'id_image']);
    }

    /**
     * Gets query for [[ImageMob]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImageMob()
    {
        return $this->hasOne(Images::class, ['id' => 'id_image_mob']);
    }

    
}
