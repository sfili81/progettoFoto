<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Image;

/**
 * ImageSearch represents the model behind the search form of `common\models\Image`.
 */
class ImageSearch extends Image
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'img_width', 'img_height', 'img_content_size', 'created_at', 'updated_at'], 'integer'],
            [['img_name', 'img_show_name', 'img_description', 'img_extension', 'img_content_type'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
         return [
            'img_name' => Yii::t('backend', 'Img Name'),
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Image::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'img_width' => $this->img_width,
            'img_height' => $this->img_height,
            'img_content_size' => $this->img_content_size,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'img_name', $this->img_name])
            ->andFilterWhere(['like', 'img_show_name', $this->img_show_name])
            ->andFilterWhere(['like', 'img_description', $this->img_description])
            ->andFilterWhere(['like', 'img_extension', $this->img_extension])
            ->andFilterWhere(['like', 'img_content_type', $this->img_content_type]);

        return $dataProvider;
    }
}
