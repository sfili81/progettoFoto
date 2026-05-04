<?php

use kartik\file\FileInput;
use \bizley\quill\Quill as TxtEditor;

/** @var yii\web\View $this */
/** @var common\models\Block $model */
/** @var yii\widgets\ActiveForm $form */
?>



<div class="row mt-md-3 mt-0">
    <div class="col-12">
        <h3 class="mt-5">Blocco PDF</h3>
    </div>
    <div class="col-md-6 col-12">
        <!-- Titolo -->
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>
</div><!-- end:row -->

<div class="row mt-md-3 mt-0">
    <div class="col-md-6 col-12">
        <!-- Testo Preview -->
        <?= $form->field($model, 'text_preview')->widget(TxtEditor::class ,Yii::$app->params['quillOptions']) ?>
    </div>
</div><!-- end:row -->

<div class="row mt-md-3 mt-0">
    <div class="col-md-6 col-12">
    <!-- PDF News-->
    <?php 
        echo $form->field($uploadModel, 'pdfFile')->widget(FileInput::classname(), [
                'name' => 'pdfFile',
                'options' => [
                    'accept' => 'application/pdf',
                ],
                'pluginOptions' => [
                    'initialPreview'=>$pdfList,
                    'initialCaption'=>$initialPreviewConfigPdf,
                    'initialPreviewAsData'=>true,
                    'overwriteInitial'=>false,
                    'showPreview' => false,
                    'showCaption' => true,
                    'showRemove' => true,
                    'showUpload' => false
                ]
            ]);
    ?>
    </div>
</div><!-- end:row -->
<div class="row mt-md-3 mt-0">
    <div class="col-md-6 col-12">
    <!-- PDF News-->
    <?= $form->field($model, 'cta')->textInput(['maxlength' => true]) ?>
    </div>
</div><!-- end:row -->