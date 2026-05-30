<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Images $model */

$this->title = $model->img_show_name ?: $model->img_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="image-view">

    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 col-12 d-flex align-items-center card-top-header gap-3">
                    <a href="javascript:history.back()" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> <?= Yii::t('backend', 'Back') ?>
                    </a>
                    <h1 class="mb-0"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="col-md-4 mt-md-0 mt-3 col-12 d-flex justify-content-start justify-content-md-end align-items-center d-none">
                    <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-7 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center justify-content-center" style="background:#f8f9fa; min-height:300px;">
                    <?php if ($model->img_name): ?>
                        <?= Html::img(
                            "@frontendUploads/{$model->img_name}{$model->img_extension}",
                            [
                                'alt'   => $model->img_show_name ?: $model->img_name,
                                'class' => 'img-fluid',
                                'style' => 'max-height:600px; object-fit:contain;',
                            ]
                        ) ?>
                    <?php else: ?>
                        <p class="text-muted"><?= Yii::t('backend', 'No image available') ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-5 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <?= DetailView::widget([
                        'model'      => $model,
                        'attributes' => [
                            'id',
                            'img_name',
                            'img_show_name',
                            'img_description:ntext',
                            'img_extension',
                            /*'img_width',
                            'img_height',
                            'img_content_type',
                            [
                                'attribute' => 'img_content_size',
                                'value'     => $model->img_content_size
                                    ? round($model->img_content_size / 1024, 1) . ' KB'
                                    : null,
                            ],*/
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
