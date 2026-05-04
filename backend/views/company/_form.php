<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Company $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="formErrorList">
    <?= Yii::t('backend', 'An error occurred while creating the item.') ?> <i class="close far fa-times-circle"></i>
</div>

<div class="card company-form">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="dettagli-tab" data-bs-toggle="tab" data-bs-target="#dettagli" type="button" role="tab" aria-controls="dettagli" aria-selected="true"><?= Yii::t('backend', 'Details') ?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false"><?= Yii::t('backend', 'Social') ?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="dati-tab" data-bs-toggle="tab" data-bs-target="#dati" type="button" role="tab" aria-controls="dati" aria-selected="false"><?= Yii::t('backend', 'Company Legal') ?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="linkpreview-tab" data-bs-toggle="tab" data-bs-target="#linkpreview" type="button" role="tab" aria-controls="preview link" aria-selected="false"><?= Yii::t('backend', 'Link Preview') ?></button>
        </li>
    </ul>

    <?php $form = ActiveForm::begin(); ?>
    <div class="card-body">
        <div class="tab-content">
            <!-- DETTAGLI -->
            <div class="tab-pane fade show active" id="dettagli" role="tabpanel" aria-labelledby="dettagli-tab">
                <div class="row mb-3">
                    <div class="col-md-6 col-12">
                        <!-- Nome -->
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 col-12">
                        <!-- Indirizzo -->
                        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-2 col-12">
                        <!-- Città -->
                        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-1 col-12">
                        <!-- CAP -->
                        <?= $form->field($model, 'cap')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 col-12">
                        <!-- EMail -->
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 col-12">
                        <!-- Telefono -->
                        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-3 col-12">
                        <!-- Whatsapp -->
                        <?= $form->field($model, 'whatsapp')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-3 col-12">
                        <!-- Cellulare -->
                        <?= $form->field($model, 'phone_mobile')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
            <!-- FINE DETTAGLI -->

            <!-- SOCIAL -->
            <div class="tab-pane fade show" id="social" role="tabpanel" aria-labelledby="social-tab">
                <div class="row mb-3">
                    <div class="col-md-6 col-12">
                        <!-- Facebook -->
                        <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 col-12">
                        <!-- Instagram -->
                        <?= $form->field($model, 'instagram')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 col-12">
                        <!-- Youtube -->
                        <?= $form->field($model, 'youtube')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
            <!-- FINE SOCIAL -->
            <!-- DATI -->
            <div class="tab-pane fade show" id="dati" role="tabpanel" aria-labelledby="dati-tab">
                <div class="row mb-3">
                    <div class="col-md-3 col-12">
                        <!-- PEC -->
                        <?= $form->field($model, 'pec')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 col-12">
                        <!-- Partita Iva -->
                        <?= $form->field($model, 'p_iva')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 col-12">
                        <!-- Capitale sociale -->
                        <?= $form->field($model, 'social_capital')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 col-12">
                        <!-- Rea -->
                        <?= $form->field($model, 'rea')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
            <!-- FINE DATI -->
            <!-- LINK PREVIEW -->
            <div class="tab-pane fade show" id="linkpreview" role="tabpanel" aria-labelledby="linkpreview-tab">
                <div class="row mb-3">
                    <div class="col-md-6 col-12">
                        <!-- Og Url -->
                        <?= $form->field($model, 'og_url')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 col-12">
                        <!-- Og title -->
                        <?= $form->field($model, 'og_title')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 col-12">
                        <!-- Og description -->
                        <?= $form->field($model, 'og_description')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 col-12">
                        <!-- Og image -->
                        <?= $form->field($model, 'og_image')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
            <!-- FINE LINK PREVIEW -->

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