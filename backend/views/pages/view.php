<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Pages;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;    
use yii\widgets\Pjax;
use backend\helpers\Helpers;
use common\models\Block;
use yii\bootstrap5\Modal;
use yii\helpers\ArrayHelper;
use sjaakp\sortable\SortableGridView;

/** @var yii\web\View $this */
/** @var common\models\Pages $model */

$this->title = $model->pages_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

//redirect for block update view
$redirect = Url::toRoute(['view', 'id' => $model->id]); 

?>
<div class="pages-view">

    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1 class="h3"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="col-md-2 mt-md-0 mt-3 col-12 d-flex justify-content-start justify-content-md-end">
                    <p>
                        <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
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
                                
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        'pages_name',
                                        'pages_tag',
                                        ['attribute' => 'pages_visibility',
                                        'label'     => 'Pubblicata',
                                        'format'   => 'raw',
                                        'value'    => function ( $model) { return Helpers::showVisibility($model->pages_visibility);},
                                        ],
                                        'pages_meta_description:ntext',
                                        'pages_meta_keywords:ntext',
                                        
                                    ],
                                ]) ?>
                                             
                            </div>
                        </div>
                    </div><!-- end::card-body -->
                </div><!-- end::card -->
            </div><!-- end w-100-->                
        </div>
    </div><!-- end::row -->
    
    <div class="col-12">
        <div class="card">
			<div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title">Blocchi</h5>
                    </div>
                    <div class="col">
                         <?php
                                   Modal::begin([
                                        'title' => Yii::t('backend', 'Select block type'),
                                        'toggleButton' => ['label' => 'Crea blocco', 'class' => 'btn btn-primary'],
                                    ]);                                    
                                    echo Html::beginForm(['create-block'], 'post', ['enctype' => 'multipart/form-data']); 
                                    echo Html::hiddenInput('idPages', $model->id);
                                    echo "<div class='row'>";
                                        echo "<div class='col-6'>";  //$model->id
                                           echo Html::dropDownList('blockType','',ArrayHelper::map(Yii::$app->params['blockName'], 'id', 'name'),['prompt'=>'Seleziona...','class'=>'form-control',]);
                                        echo "</div>";
                                        echo "<div class='col-6'>";    
                                             echo Html::submitButton('Crea Blocco', ['class' => 'btn btn-primary']);
                                        echo "</div>";
                                    echo "</div>";
                                    echo Html::endForm();
                                    Modal::end();
                         ?>
                    </div>
                </div>

                 <?= SortableGridView::widget([
                    'dataProvider' => $blocks,
                    'orderUrl' => ['block/order'],
                    'columns' => [
                        [
                         'attribute' => 'enabled',
                         'format' => 'raw',
                         'value'  => function (Block $model) {return Helpers::showVisibility($model->enabled);},
                        ],   
                        'block_name',
                        'ord',
                        [
                            'class' => ActionColumn::className(),
                            'header' => 'Azioni',
                            'buttons'=>[

                                'view'=>function ($url, Block $blocks) {return null;},
                                                
                                'update' => function ($url, Block $blocks,) use ($redirect) {
                                                return  Html::a(Yii::$app->params['gridviewAction']['update']['string'], 
                                                                 ['block/update', 'id' => $blocks->id,
                                                                                  'redirect' => $redirect,
                                                                                  'blockPageType' => null,//Ci va la chiave se esiste per le viste definite nei params
                                                                 ], 
                                                                 ['class' => "btn btn-info mb-md-0 mb-2", 
                                                                  'data' => Yii::$app->params['gridviewAction']['update']['data'] , 
                                                                  'data-pjax' => '0' ]);
                                                },

                                'delete' => function ($url, Block $blocks) {return Helpers::actionButton( $blocks, 'delete', "block");},

                            ],
                        ],
                    ],
                ]); ?>
		    </div>
		</div>
    </div><!-- end::col-6-->



</div>
