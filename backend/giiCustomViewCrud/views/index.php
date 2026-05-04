<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var yii\gii\generators\crud\Generator $generator */

$modelClass = StringHelper::basename($generator->modelClass);

echo "<?php\n";
?>

use <?= $generator->modelClass ?>;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use backend\helpers\Helpers;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/** @var yii\web\View $this */
<?= !empty($generator->searchModelClass) ? "/** @var " . ltrim($generator->searchModelClass, '\\') . " \$searchModel */\n" : '' ?>
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>                     
                </div>
                <div class="col-md-2 mt-md-0 mt-3 col-12 d-flex justify-content-start justify-content-md-end">
                    <p>
                        <?= "<?= " ?>Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="card">
        <div class="card-body news-view">
            <div class="row">
                <div class="col mt-0 tab-content">
                <?= $generator->enablePjax ? "    <?php Pjax::begin(); ?>\n" : '' ?>
                <?php if(!empty($generator->searchModelClass)): ?>
                <?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
                <?php endif; ?>

                <?php if ($generator->indexWidgetType === 'grid'): ?>
                    <?= "<?= " ?>GridView::widget([
                        'dataProvider' => $dataProvider,
                        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
                            ['class' => 'yii\grid\SerialColumn'],

                <?php
                $count = 0;
                if (($tableSchema = $generator->getTableSchema()) === false) {
                    foreach ($generator->getColumnNames() as $name) {
                        if (++$count < 6) {
                            echo "            '" . $name . "',\n";
                        } else {
                            echo "            //'" . $name . "',\n";
                        }
                    }
                } else {
                    foreach ($tableSchema->columns as $column) {
                        $format = $generator->generateColumnFormat($column);
                        if (++$count < 6) {
                            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                        } else {
                            echo "            //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                        }
                    }
                }
                ?>
                            [
                                'class' => ActionColumn::className(),
                                'header' => 'Azioni',
                                'buttons'=>[
                                    'view'=>function ($url, <?= $modelClass ?> $model) {return Helpers::actionButton( $model, 'view');},
                                    'update' => function ($url, <?= $modelClass ?> $model) {return Helpers::actionButton( $model, 'update');},
                                    'delete' => function ($url, <?= $modelClass ?> $model) {return Helpers::actionButton( $model, 'delete');},
                                ],
                                'urlCreator' => function ($action, <?= $modelClass ?> $model, $key, $index, $column) {
                                    return Url::toRoute([$action, <?= $generator->generateUrlParams() ?>]);
                                }
                            ],
                        ],
                    ]); ?>
                <?php else: ?>
                    <?= "<?= " ?>ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => function ($model, $key, $index, $widget) {
                            return Html::a(Html::encode($model-><?= $generator->getNameAttribute() ?>), ['view', <?= $generator->generateUrlParams() ?>]);
                        },
                    ]) ?>
                <?php endif; ?>

                <?= $generator->enablePjax ? "    <?php Pjax::end(); ?>\n" : '' ?>
                </div>
            </div>
        </div>
    </div>

</div>
