<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "companydetails".
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $phone_mobile
 * @property string|null $whatsapp
 * @property string|null $pec
 * @property string|null $p_iva
 * @property string|null $social_capital
 * @property string|null $rea
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $youtube
 * @property string|null $og_title
 * @property string|null $og_url
 * @property string|null $og_description
 * @property string|null $og_image
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Company extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'companydetails';
    }

     /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
            [['address', 'cap', 'city', 'email', 'phone', 'phone_mobile', 'whatsapp', 'pec', 'p_iva', 'social_capital', 'rea', 'facebook', 'instagram', 'youtube', 'og_title', 'og_url', 'og_description', 'og_image', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['name'], 'required'],
            [['address'], 'string'],
            [['cap', 'created_at', 'updated_at'], 'integer'],
            [['name', 'city', 'email', 'pec', 'rea', 'facebook', 'instagram', 'youtube', 'og_title', 'og_url', 'og_description', 'og_image'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['phone_mobile', 'whatsapp'], 'string', 'max' => 55],
            [['p_iva'], 'string', 'max' => 128],
            [['social_capital'], 'string', 'max' => 158],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'name' => Yii::t('backend', 'Name'),
            'address' => Yii::t('backend', 'Address'),
            'cap' => Yii::t('backend', 'Cap'),
            'city' => Yii::t('backend', 'City'),
            'email' => Yii::t('backend', 'Email'),
            'phone' => Yii::t('backend', 'Phone'),
            'phone_mobile' => Yii::t('backend', 'Phone Mobile'),
            'whatsapp' => Yii::t('backend', 'Whatsapp'),
            'pec' => Yii::t('backend', 'Pec'),
            'p_iva' => Yii::t('backend', 'P Iva'),
            'social_capital' => Yii::t('backend', 'Social Capital'),
            'rea' => Yii::t('backend', 'Rea'),
            'facebook' => Yii::t('backend', 'Facebook'),
            'instagram' => Yii::t('backend', 'Instagram'),
            'youtube' => Yii::t('backend', 'Youtube'),
            'og_title' => Yii::t('backend', 'Og Title'),
            'og_url' => Yii::t('backend', 'Og Url'),
            'og_description' => Yii::t('backend', 'Og Description'),
            'og_image' => Yii::t('backend', 'Og Image'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }
}
