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
    <div class="col-md-6 col-12">
        <!-- Immagine anteprima singola -->
        <?php echo $form->field($image, 'imageFile')->widget(FileInput::classname(), [
                        'name' => 'imageFile',
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => false, 
                        ],
                        'pluginOptions' => [
                            'maxFileCount' => 1,
                            'initialPreview'=>$listPreviewImg,
                            'initialPreviewConfig' =>  $initialImgPreviewConfig,
                            'initialPreviewAsData'=>true,
                            'overwriteInitial'=>false,
                            'deleteUrl' => Url::to(['update', 'id' => $model->id]),
                        ]            
                    ])->label('Aggiungi Immagine');
        ?>
    </div>
    <div class="col-md-6 col-12">
        <?php //Scelta Formato
            echo $form->field($image, 'saveFormat')->radioList( ['webp' => Yii::t('backend', 'Save WebP Format'), 
                                                        'avif' => Yii::t('backend', 'Save Avif Format'),
                                                        'original' => Yii::t('backend', 'Original')], 
                         ['unselect' => null,'class' => 'radioList'] );
        ?>
    </div>
</div><!-- end::row -->
<div class="row mt-md-3 mt-0"> 
    <div class="col-md-3 col-12 mt-2">
        <!-- Lato Immagine -->
        <?= $form->field($model, 'img_side')->dropDownList(Yii::$app->params['imgSide'], ['prompt' => 'Seleziona lato immagine']) ?>
    </div>
    <div class="col-12 mt-5">
        <!-- Testo -->
        <?= $form->field($model, 'text')->widget(TxtEditor::class ,Yii::$app->params['quillOptions']) ?>
    </div>
</div><!-- end:row -->