<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\News $model */

$this->title = Yii::t('backend', 'Update News: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="news-update">

    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1 class="h3"><?= Html::encode($this->title) ?></h1>                      
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'uploadModel' => $uploadModel,
        'image'                => $image,
        'listImg'              => $listImg,
        'initialPreviewConfig' => $initialPreviewConfig,
        'listPreviewImg'       => $listPreviewImg,
        'initialImgPreviewConfig' => $initialImgPreviewConfig,
    ]) ?>

</div>
