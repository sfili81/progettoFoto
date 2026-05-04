<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "content_translation".
 *
 * @property int $id
 * @property string $model
 * @property int $model_id
 * @property string $language
 * @property string $attribute
 * @property string $value
 */
class ContentTranslation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'model_id', 'language', 'attribute', ], 'required'],
            [['value'], 'safe'],
            [['model_id'], 'integer'],
            [['value'], 'string'],
            [['model', 'attribute'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 3],
        ];
    }
}
    