<?php

use \bizley\quill\Quill as TxtEditor;

/** @var yii\web\View $this */
/** @var common\models\Block $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row mt-md-3 mt-0">    
    <div class="col-12 mt-md-3 mt-0">
        <!-- Testo -->
        <?= $form->field($model, 'text')->widget(TxtEditor::class ,Yii::$app->params['quillOptions']) ?>
    </div>
</div><!-- end:row -->