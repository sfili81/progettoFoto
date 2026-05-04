<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use common\behaviors\TranslatableBehavior;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title Titolo della news
 * @property string $slug
 * @property string|null $subtitle
 * @property string|null $date
 * @property string|null $preview
 * @property string $text
 * @property int|null $id_image_preview ID Immagine anteprima preview
         
 * @property string|null $images
 * @property int $is_published Indica se la news è pubblicata
 * @property int $is_visible_homepage Indica se la news è visibile in home page. Deafult è false
         
 * @property string|null $meta_description
 * @property string|null $meta_title
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Images $imagePreview
 */
class News extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                //'slugAttribute' => 'news_slug', //slug è il nome del campo in tabella di default             
                'immutable' => true,
                'ensureUnique' => true,
            ],
            'translatable' => [
                'class' => TranslatableBehavior::class,
                'attributes' => [
                    'title',
                    'subtitle',
                    'text',
                    'meta_description',
                    'meta_title',
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subtitle', 'date', 'preview', 'id_image_preview', 'images', 'meta_description', 'meta_title', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['title', 'slug', 'text', 'is_published'], 'required'],
            [['date'], 'safe'],
            [['preview', 'text', 'images', 'meta_description', 'meta_title'], 'string'],
            [['id_image_preview', 'is_published', 'is_visible_homepage', 'created_at', 'updated_at'], 'integer'],
            [['title', 'slug', 'subtitle'], 'string', 'max' => 255],
            [['id_image_preview'], 'exist', 'skipOnError' => true, 'targetClass' => Images::class, 'targetAttribute' => ['id_image_preview' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'title' => Yii::t('backend', 'Title'),
            'slug' => Yii::t('backend', 'Slug'),
            'subtitle' => Yii::t('backend', 'Subtitle'),
            'date' => Yii::t('backend', 'Date'),
            'preview' => Yii::t('backend', 'News Preview'),
            'text' => Yii::t('backend', 'Text'),
            'id_image_preview' => Yii::t('backend', 'Id Image Preview'),
            'images' => Yii::t('backend', 'Images'),
            'is_published' => Yii::t('backend', 'Is Published'),
            'is_visible_homepage' => Yii::t('backend', 'Is Visible Homepage'),
            'meta_description' => Yii::t('backend', 'Meta Description'),
            'meta_keywords' => Yii::t('backend', 'Meta Keywords'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[ImagePreview]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagePreview()
    {
        return $this->hasOne(Images::class, ['id' => 'id_image_preview']);
    }
}
