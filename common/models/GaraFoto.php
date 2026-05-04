<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Tabella pivot tra nodi foglia dell'albero gara e le foto (tabella image).
 *
 * @property int    $id
 * @property int    $gara_id     FK → gara.id (deve essere una foglia)
 * @property int    $image_id    FK → image.id
 * @property int    $created_at
 *
 * @property Gara   $gara
 * @property Images $image
 */
class GaraFoto extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'gara_foto';
    }

    public function behaviors(): array
    {
        return [
            [
                'class'              => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['gara_id', 'image_id'], 'required'],
            [['gara_id', 'image_id', 'created_at'], 'integer'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id'         => Yii::t('backend', 'ID'),
            'gara_id'    => Yii::t('backend', 'Categoria'),
            'image_id'   => Yii::t('backend', 'Foto'),
            'created_at' => Yii::t('backend', 'Caricata il'),
        ];
    }

    public function getGara(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Gara::class, ['id' => 'gara_id']);
    }

    public function getImage(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Images::class, ['id' => 'image_id']);
    }

    /**
     * Tutte le foto di una foglia, dalla più recente.
     * Usato dal frontend per recuperare le immagini di una categoria.
     */
    public static function findByGara(int $gara_id): \yii\db\ActiveQuery
    {
        return static::find()
            ->with('image')
            ->where(['gara_id' => $gara_id])
            ->orderBy(['created_at' => SORT_DESC]);
    }
}
