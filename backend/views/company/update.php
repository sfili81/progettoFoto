<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Company $model */

$this->title = Yii::t('backend', 'Company');

$this->params['breadcrumbs'][] = Yii::t('backend', 'Company');
?>
<div class="company-update">
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
    ]) ?>

</div>