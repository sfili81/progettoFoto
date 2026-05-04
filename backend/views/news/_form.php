<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\bootstrap5\ActiveForm;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use \bizley\quill\Quill as TxtEditor;
use backend\helpers\Helpers;
use yii\bootstrap5\Modal;



/** @var yii\web\View $this */
/** @var common\models\News $model */
/** @var yii\widgets\ActiveForm $form */

//Da aggiungere nel caso in cui usiamo KArtik FileInput e l'immagine o immagini sono obbligatorie
/*$kartikRequired = false;
if($model->isNewRecord){
    $kartikRequired = true;
}*/
/* da aggiungere nelle pòuginOptions
   'required' => $kartikRequired,
*/

?>

<div class="formErrorList">
    <?= Yii::t('backend', 'An error occurred while creating the item.') ?> <i class="close far fa-times-circle"></i>
</div>

<!-- CAMBIO LINGUA -->
<?= Helpers::renderLanguageSwitcher() ?>
<!-- CAMBIO LINGUA -->

<div class="card news-form">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="dettagli-tab" data-bs-toggle="tab" data-bs-target="#dettagli" type="button" role="tab" aria-controls="dettagli" aria-selected="true"><?= Yii::t('backend', 'Details') ?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link " id="testi-tab" data-bs-toggle="tab" data-bs-target="#testi" type="button" role="tab" aria-controls="testi" aria-selected="true"><?= Yii::t('backend', 'Texts') ?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="immagini-tab" data-bs-toggle="tab" data-bs-target="#immagini" type="button" role="tab" aria-controls="immagini" aria-selected="false"><?= Yii::t('backend', 'Images') ?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false"><?= Yii::t('backend', 'Seo') ?></button>
        </li>
    </ul>



    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="card-body news-view">
        <div class="tab-content">
            <!-- DETTAGLI -->
            <div class="tab-pane fade show active" id="dettagli" role="tabpanel" aria-labelledby="dettagli-tab">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <!-- Titotlo -->
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mt-md-3 mt-0">
                    <div class="col-md-6 col-12">
                        <!-- Sottotitotlo -->
                        <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <div class="row mt-md-3 mt-0">
                    <div class="col-md-3 col-12">
                        <!-- Data-->
                        <label><strong><?= Yii::t('backend', 'Date') ?></strong></label>
                        <?= DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'date',
                            'options' => ['placeholder' => 'Seleziona data'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-md-1 col-6">
                        <!-- Pubblica news -->
                        <?= $form->field($model, 'is_published')->widget(SwitchInput::class,  Yii::$app->params['KartikSwitchOptions']) ?>
                    </div>

                    <div class="col-md-2 col-6">
                        <!-- Visibilità news Home page -->
                        <?= $form->field($model, 'is_visible_homepage')->widget(SwitchInput::class,  Yii::$app->params['KartikSwitchOptions'])->label('Visibile Home Page') ?>
                    </div>
                </div>
            </div>

            <!-- TESTI -->
            <div class="tab-pane fade show " id="testi" role="tabpanel" aria-labelledby="testi-tab">
                <div class="row mt-md-5 mt-0">
                    <div class="col-md-6 col-12">
                        <!-- Testo anteprima -->
                        <?= $form->field($model, 'preview')->widget(TxtEditor::class, Yii::$app->params['quillOptions']) ?>
                    </div>
                    <div class="col-12 mt-md-3 mt-0">
                        <!-- Testo news -->
                        <?= $form->field($model, 'text')->widget(TxtEditor::class, Yii::$app->params['quillOptions']) ?>
                    </div>
                </div>
            </div><!-- end::#testi -->

            <!-- IMMAGINI -->
            <div class="tab-pane fade show " id="immagini" role="tabpanel" aria-labelledby="immagini-tab">
                <div class="row mt-md-5 mt-0">
                    <div class="col-md-6 col-12">
                        <!-- Immagine anteprima singola -->
                        <?php echo $form->field($image, 'imageFile')->widget(FileInput::class, [
                            'name' => 'previewImg',
                            'options' => [
                                'accept' => 'image/*',
                                'multiple' => false,
                            ],
                            'pluginOptions' => [
                                'maxFileCount' => 1,
                                'initialPreview' => $listPreviewImg,
                                'initialPreviewConfig' =>  $initialImgPreviewConfig,
                                'initialPreviewAsData' => true,
                                'overwriteInitial' => false,
                                'deleteUrl' => Url::to(['update', 'id' => $model->id]),
                            ]
                        ]);
                        ?>

                        <?php echo $form->field($image, 'img_show_name')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6 col-12">
                        <?php //Scelta Formato
                        echo $form->field($image, 'saveFormat')->radioList(
                            [
                                'webp' => Yii::t('backend', 'Save WebP Format'),
                                'avif' => Yii::t('backend', 'Save Avif Format'),
                                'original' => Yii::t('backend', 'Original')
                            ],
                            ['unselect' => null, 'class' => 'radioList']
                        );
                        ?>
                    </div><!-- end col -->

                    <div class="col-12">
                        <!-- Immagini News-->
                        <?php
                        echo $form->field($uploadModel, 'imageFiles[]')->widget(FileInput::class, [
                            'name' => 'imageFiles[]',
                            'options' => [
                                'accept' => 'image/*',
                                'multiple' => true,
                            ],
                            'pluginOptions' => [
                                'maxFileCount' => 10,
                                'initialPreview' => $listImg,
                                'initialPreviewConfig' => $initialPreviewConfig,
                                'initialPreviewAsData' => true,
                                'overwriteInitial' => false,
                                'deleteUrl' => Url::to(['update', 'id' => $model->id]),
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div><!-- end::#immagini -->

            <!-- SEO -->
            <div class="tab-pane fade show " id="seo" role="tabpanel" aria-labelledby="seo-tab">
                <div class="row mt-md-5 mt-0">
                    <div class="col-md-6 col-12">
                        <!-- Meta Description -->
                        <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>
                    </div>
                    <div class="col-md-6 col-12">
                        <!-- Meta Title -->
                        <?= $form->field($model, 'meta_title')->textarea(['rows' => 6]) ?>
                    </div>
                </div>
            </div>

        </div><!-- end::tab-content -->

        <!-- SUBMIT BUTTON -->
        <div class="row mt-5">
            <div class="col-md-auto col-12 mb-md-0 mb-4">
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('backend', 'Save and modify'), ['class' => 'btn btn-success', 'name' => 'subaction', 'value' => 'saveMod']) ?>
                </div>
            </div>
            <div class="col-md-auto col-12 mb-md-0 mb-4">
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('backend', 'Save and return to the list'), ['class' => 'btn btn-success', 'name' => 'subaction', 'value' => 'saveReturn']) ?>
                </div>
            </div>
        </div>

    </div><!-- end::card -->
    <?php ActiveForm::end(); ?>
</div>