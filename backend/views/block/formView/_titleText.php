<?php

use \bizley\quill\Quill as TxtEditor;
use kartik\switchinput\SwitchInput;

/** @var yii\web\View $this */
?>
?
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
        <!-- Testo -->
        <?= $form->field($model, 'text')->widget(TxtEditor::class ,Yii::$app->params['quillOptions']) ?>
    </div>
</div><!-- end:row -->