<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Block $model */

$this->title = Yii::t('backend', 'Update Block: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="block-update">

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
        'image' => $image,
        'viewName' => $viewName,
        'listPreviewImg'       => $listPreviewImg,
        'initialImgPreviewConfig' => $initialImgPreviewConfig,
        'listPreviewMobileImg' => $listPreviewMobileImg,
        'initialImgMobilePreviewConfig' =>  $initialImgMobilePreviewConfig,
        'listImg' => $listImg,
        'initialPreviewConfig' => $initialPreviewConfig,
        'pdfList' => $pdfList,
        'initialPreviewConfigPdf' => $initialPreviewConfigPdf,
        'blockList' => $blockList,
    ]) ?>

</div>
