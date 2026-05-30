<?php

use common\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use backend\helpers\Helpers;

/** @var yii\web\View $this */
/** @var common\models\CartSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Richieste';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">

<div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1><?= Html::encode($this->title) ?></h1>                     
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
                             'attribute' => 'state',
                             'label' => 'Stato',
                             'format' => 'raw',
                             'value'  => function (Cart $model) {return Helpers::showStateRequest($model);},
                             ],
                            'email:email',
                            'code',
                            [
                                'class' => ActionColumn::class,
                                'header' => 'Azioni',
                                'buttons'=>[
                                    'view'=>function ($url, Cart $model) {return Helpers::actionButton( $model, 'view');},
                                    'update' => function ($url, Cart $model) {return Helpers::actionButton( $model, 'update');},
                                    'delete' => function ($url, Cart $model) {return Helpers::actionButton( $model, 'delete');},
                                ],
                                'urlCreator' => function ($action, Cart $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>
                
                </div>
            </div>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
