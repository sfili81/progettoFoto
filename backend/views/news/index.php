<?php

use common\models\News;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\helpers\Helpers;
use kartik\date\DatePicker;

/** @var yii\web\View $this */
/** @var common\models\NewsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

    $this->title = Yii::t('backend', 'News');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1 class="h3"><?= Html::encode($this->title) ?></h1>                      
                </div>
                <div class="col-md-2 mt-md-0 mt-3 col-12 d-flex justify-content-start justify-content-md-end">
                    <p>
                        <?= Html::a(Yii::t('backend', 'Crea News'), ['create'], ['class' => 'btn btn-primary']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
		<div class="col d-flex">
			<div class="w-100">
                <div class="card">
                    <div class="card-body news-view">
                        <div class="row">
                            <div class="col mt-0 tab-content">
                                
                                <?php Pjax::begin(); ?>
                                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'pager' => ['class' => \yii\bootstrap5\LinkPager::class],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        //'id',
                                        [
                                        'attribute' => 'is_published',
                                        'label' => 'Abilitazione',
                                        'filter'=>array(0 => "No",1 =>"Si"),
                                        'filterInputOptions' => ['prompt' => 'Tutti', 'class' => 'form-control'],
                                        'format' => 'raw',
                                        'value'  => function (News $model) {
                                                        return Helpers::showVisibility($model->is_published);
                                                    },
                                        ],
                                        'title',
                                        [
                                        'attribute' => 'id',
                                        'label' => 'Immagine',
                                        'format' => 'raw',
                                        'value'  => function (News $model) {
                                                        if(!is_null($model->imagePreview)){
                                                            return  Html::img('@frontendUploads/'.$model->imagePreview->img_name. $model->imagePreview->img_extension , ['alt' => '', 'width' => '150']);
                                                         }
                                                    },
                                        ],
                                        [
                                         'attribute' => 'date',
                                         'filter' => DatePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'date',
                                            'options' => ['placeholder' => 'Seleziona data'],
                                                        'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'format' => 'yyyy-mm-dd'
                                                        ]
                                        ]),
                                        'filterInputOptions' => ['prompt' => 'Tutti', 'class' => 'form-control'],
                                        'format' => 'raw',
                                        'value' => function (News $model) {
                                                        return  Yii::$app->formatter->asDate($model->date, 'php:d F Y'); 
                                                    },
                                        ],
                                        [
                                        'attribute' => 'is_visible_homepage',
                                        'label' => 'In evidenza',
                                        'format' => 'raw',
                                        'value'  => function (News $model) {
                                                        return Helpers::showVisibility($model->is_visible_homepage);
                                                    },
                                        ],
                                        //'preview:ntext',
                                        //'text:ntext',
                                        //'images',
                                        //'meta_description:ntext',
                                        //'meta_keywords:ntext',
                                        [
                                            'class' => ActionColumn::className(),
                                            'header' => 'Azioni',
                                            'buttons'=>[
                                                'view'=>function ($url, News $model) {return Helpers::actionButton( $model, 'view', is_slug:true);},
                                                    
                                                'update' => function ($url, News $model) {return Helpers::actionButton( $model, 'update');},

                                                'delete' => function ($url, News $model) {return Helpers::actionButton( $model, 'delete');},
                                            ],
                                            'urlCreator' => function ($action, News $model, $key, $index, $column) {
                                                return Url::toRoute([$action, 'id' => $model->id]);
                                            }
                                        ],
                                    ],
                                ]); ?>

                                <?php Pjax::end(); ?>
                                             
                            </div>
                        </div>
                    </div><!-- end::card-body -->
                </div><!-- end::card -->
            </div><!-- end w-100-->                
        </div>
    </div><!-- end::row -->

</div><!-- end::page -->
