<?php

use backend\models\Image;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use backend\helpers\Helpers;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ImageSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('backend', 'Images');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-index">
    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1><?= Html::encode($this->title) ?></h1>                     
                </div>
                <div class="col-md-2 mt-md-0 mt-3 col-12 d-flex justify-content-start justify-content-md-end">
                    <p>
                        <?= Html::a(Yii::t('backend', 'Create Image'), ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body news-view">
            <div class="row">
                <div class="col mt-0 tab-content">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pager' => ['class' => \yii\bootstrap5\LinkPager::class],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                             'attribute' => 'id',
                             'label' => 'Immagine',
                             'format' => 'raw',
                             'value'  => function (Image $model) {
                                            return  Html::img('@frontendUploads/'.$model->img_name . $model->img_extension , ['alt' => '', 'width' => '150']);
                                            },
                             ],
                            [
                             'attribute' => 'img_name',
                             'label' => 'Nome Immagine',
                             'format' => 'raw',
                             'value'  => function (Image $model) {
                                            return preg_replace("/^\d+\_{1}/", "", $model->img_name); 
                                            },
                             ],
                            'img_show_name',
                            'img_description:ntext',
                            'img_extension',
                            //'img_width',
                            //'img_height',
                            //'img_content_type',
                            //'img_content_size',
                            //'created_at',
                            //'updated_at',
                            [
                                'class' => ActionColumn::className(),
                                'header' => 'Azioni',
                                'buttons'=>[
                                    'view'=>function ($url, Image $model) {return Helpers::actionButton( $model, 'view');},
                                    'update' => function ($url, Image $model) {return Helpers::actionButton( $model, 'update');},
                                    'delete' => function ($url, Image $model) {return Helpers::actionButton( $model, 'delete');},
                                ],
                                'urlCreator' => function ($action, Image $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>
                
                </div>
            </div>
        </div>
    </div>

</div>
