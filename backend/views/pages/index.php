<?php

use common\models\Pages;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\helpers\Helpers;

use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\PagesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('backend', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="pages-index">

    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1 class="h3"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="col-md-2 mt-md-0 mt-3 col-12 d-flex justify-content-start justify-content-md-end">
                    <p>
                        <?= Html::a(Yii::t('backend', 'Create Pages'), ['create'], ['class' => 'btn btn-success']) ?>
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

                                <div class="toolbar mb-3">
                                    <?= Html::button(Yii::t('backend', 'Delete selected'), ['class' => 'btn btn-danger', 'id' => 'delete-selected', 'data-url' => Url::to(['delete-multiple'])]) ?>
                                </div>

                                <?php // echo $this->render('_search', ['model' => $searchModel]); 
                                ?>

                                <?php
                                echo GridView::widget([
                                    'id' => 'kv-grid-demo',
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'columns' => [
                                        ['class' => '\kartik\grid\CheckboxColumn'],
                                        [
                                            'class' => 'kartik\grid\SerialColumn',
                                            'contentOptions' => ['class' => 'kartik-sheet-style'],
                                            'width' => '46px',
                                            'header' => '#',
                                            'headerOptions' => ['class' => 'kartik-sheet-style']
                                        ],

                                        [
                                            'class' => 'kartik\grid\EditableColumn',
                                            'attribute' => 'pages_visibility',
                                            'filter' => array(0 => Yii::t('backend', 'No'), 1 => Yii::t('backend', 'Yes')),
                                            'filterInputOptions' => ['prompt' => Yii::t('backend', 'All'), 'class' => 'form-control'],
                                            'pageSummary' => '',
                                            'vAlign' => 'middle',
                                            'width' => '310px',
                                            'readonly' => function ($model, $key, $index, $widget) {
                                                return Helpers::showVisibility($model->pages_visibility);
                                            },
                                            'editableOptions' =>  function ($model, $key, $index) {
                                                return [
                                                    'header' => 'Visibilità',
                                                    'asPopover' => false, //se false mostra un popover
                                                    'size' => 'md',
                                                    'inputType' => Editable::INPUT_SWITCH,
                                                    'data' => [0 => Yii::t('backend', 'No'), 1 => Yii::t('backend', 'Yes')],
                                                    'options' => Yii::$app->params['KartikSwitchOptions'],
                                                    'displayValueConfig' => [
                                                        '0' => Helpers::showVisibility(0),
                                                        '1' => Helpers::showVisibility(1),
                                                    ],
                                                ];
                                            }
                                        ],
                                        'pages_name',
                                        [
                                            'attribute' => 'pages_tag',
                                            'visible' => Yii::$app->user->can('admin') ? true : false
                                        ],
                                        [
                                            'class' => ActionColumn::class,
                                            'header' => Yii::t('backend', 'grid.action'),
                                            'buttons' => [
                                                'view' => function ($url, Pages $model) {
                                                    return Helpers::actionButton($model, 'view');
                                                },

                                                'update' => function ($url, Pages $model) {
                                                    return Helpers::actionButton($model, 'update');
                                                },

                                                'delete' => function ($url, Pages $model) {
                                                    return Helpers::actionButton($model, 'delete');
                                                },
                                            ],
                                            'urlCreator' => function ($action, Pages $model, $key, $index, $column) {
                                                return Url::toRoute([$action, 'id' => $model->id]);
                                            }
                                        ],

                                    ], //end grid columns 
                                    // check this value by clicking GRID COLUMNS SETUP button at top of the page
                                    //'headerContainer' => ['class' => 'kv-table-header'],
                                    //'floatFooter' => false, // disable floating of table footer
                                    //'pjax' => false, // pjax is set to always false for this demo
                                    // parameters from the demo form
                                    'responsive' => false,
                                    'bordered' => true,
                                    'striped' => false,
                                    'condensed' => false,
                                    'hover' => false,
                                    'showPageSummary' => false,
                                    'panel' => false,
                                    // set export properties
                                    'persistResize' => false,
                                ]);
                                ?>

                            </div>
                        </div>
                    </div><!-- end::card-body -->
                </div><!-- end::card -->
            </div><!-- end w-100-->
        </div>
    </div><!-- end::row -->
</div><!-- end page -->

<?php

$js = <<<JS
// Seleziona/deseleziona tutti i checkbox 
/* NON SERVE SE USO KARTIK
$('#select-all').on('change', function() {
   // $('input[name="selection[]"]').prop('checked', this.checked);
    $(this).closest('tr').toggleClass('table-danger', this.checked);
});
*/

//// Gestione click bottone elimina
/*$('#delete-selected').on('click', function(e) {
    e.preventDefault();
    var keys = $('#kv-grid-demo').yiiGridView('getSelectedRows');
    if(keys.length === 0) {
        alert('Seleziona almeno un elemento da eliminare.');
        return;
    }
    if(!confirm('Sei sicuro di voler eliminare gli elementi selezionati?')) {
        return;
    }

});*/

JS;//END Javascript
//$this->registerJs($js);
