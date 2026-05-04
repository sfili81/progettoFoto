<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
    <div class="card company-form">
        <?php $form = ActiveForm::begin(); ?>
        <div class="card-body">
            <div class="tab-content">
                <!-- NUOVA COMPAGNIA -->
                <div class="tab-pane fade show active" id="dettagli" role="tabpanel" aria-labelledby="dettagli-tab">
                    <div class="row mb-3">
                        <div class="col-md-6 col-12">
                            <!-- Nome -->
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-auto col-12 mb-md-0 mb-4">
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success', 'name' => 'subaction', 'value' => 'saveMod']) ?>
                        </div>
                    </div>
                </div>

            </div><!-- -end::tab-content -->
        </div><!-- end::car-body -->

        <?php ActiveForm::end(); ?>
    </div>
</div>