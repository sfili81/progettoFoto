<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Image $model */

$this->title = Yii::t('backend', 'Create Image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-create">
    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1><?= Html::encode($this->title) ?></h1>                    
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->render('_form', [
        'model' => $model,
        'uploadModel' => $uploadModel
    ]) ?>

</div>
