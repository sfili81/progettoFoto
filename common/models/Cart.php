<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int $state
 * @property string $email
 * @property string $code
 * @property string $list_images
 * @property string|null $note
 * @property string|null $internal_details
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Cart extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['note', 'internal_details', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['state', 'email', 'code', 'list_images'], 'required'],
            [['state', 'created_at', 'updated_at'], 'integer'],
            [['list_images'], 'safe'],
            [['note', 'internal_details'], 'string'],
            [['email', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'state' => 'State',
            'email' => 'Email',
            'code' => 'Code',
            'list_images' => 'List Images',
            'note' => 'Note',
            'internal_details' => 'Internal Details',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
