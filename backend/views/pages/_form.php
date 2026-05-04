<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\switchinput\SwitchInput;

/** @var yii\web\View $this */
/** @var common\models\Pages $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="formErrorList">
    <?= Yii::t('backend', 'An error occurred while creating the item.') ?> <i class="close far fa-times-circle"></i>
</div>

<div class="pages-form card">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body news-view">
        <div class="row">
            <div class="col-md-6 col-12">
                <!-- Nome pagina -->
                <?= $form->field($model, 'pages_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-12 mt-md-3 mt-0">
                <!-- Tag -->
                <?= $form->field($model, 'pages_tag')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-12"></div>
            <div class="col-md-6 col-12 mt-md-3 mt-0">
                <!-- Pubblica news -->
                <?= $form->field($model, 'pages_visibility')->widget(SwitchInput::class,  Yii::$app->params['KartikSwitchOptions']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-12 mt-md-3 mt-0">
                <!-- Meta description -->
                <?= $form->field($model, 'pages_meta_description')->textarea(['rows' => 6]) ?>
            </div>
            <div class="col-md-6 col-12 mt-md-3 mt-0">
                <!-- Meta TITLE -->
                <?= $form->field($model, 'pages_meta_title')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 col-12 mb-md-0 mb-4">
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>