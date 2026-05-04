<?php

use \bizley\quill\Quill as TxtEditor;
use kartik\switchinput\SwitchInput;
use yii\helpers\Url;
use kartik\file\FileInput;

/** @var yii\web\View $this */
/** @var common\models\Block $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row mt-md-3 mt-0">    
    <div class="col-6 mt-md-3 mt-0">
        <!-- Titolo -->
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-3 mt-md-3 mt-0">
        <!-- Is h1? -->
        <?= $form->field($model, 'is_h1')->widget(SwitchInput::className(),  Yii::$app->params['KartikSwitchOptions'] )->label('Titolo H1'); ?>
    </div>
</div><!-- end:row -->


<div class="row mt-md-3 mt-0">    
    <div class="col-12">
        <!-- Listato immagini -->
        <?php 
            echo $form->field($uploadModel, 'imageFiles[]')->widget(FileInput::classname(), [
                'name' => 'imageFiles[]',
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true, 
                ],
                'pluginOptions' => [
                    'maxFileCount' => 10,
                    'initialPreview'=> $listImg,
                    'initialPreviewConfig' => $initialPreviewConfig,
                    'initialPreviewAsData'=> true,
                    'overwriteInitial'=> false,
                    'deleteUrl' => Url::to(['update', 'id' => $model->id]),
                    'fileActionSettings' => [
                        'showDrag' => true, // abilita icona drag
                    ],
                ]            
            ])->label('Aggiungi Immagini');
        ?>
    </div>
    <div class="col-3 mt-3">
        <!-- Is Slider? -->
        <?= $form->field($model, 'is_slider')->widget(SwitchInput::className(),  Yii::$app->params['KartikSwitchOptions'] ); ?>
    </div>
</div><!-- end::row -->
<div class="row mt-md-3 mt-0">     
    <div class="col-12 mt-5">
        <!-- Testo -->
        <?= $form->field($model, 'text')->widget(TxtEditor::class ,Yii::$app->params['quillOptions']) ?>
    </div>
</div><!-- end:row -->