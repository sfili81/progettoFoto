<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;

/** @var yii\web\View $this */
/** @var common\models\Block $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="card block-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation' => false,'enableClientValidation' => true,]); ?>
        <div class="card-body">

            <div class="row">
                <div class="col-md-1 col-12">
                    <!-- Abilitato -->
                    <?= $form->field($model, 'enabled')->widget(SwitchInput::className(),  Yii::$app->params['KartikSwitchOptions'] )->label('Pubblica'); ?>
                </div>
                <div class="col-md-5 col-12">
                    <!-- NOME BLOCCO -->
                    <?php 
                        echo $form->field($model, 'block_name')->textInput(['maxlength' => true])->label('Nome blocco (uso interno)');
                    ?>                
                </div>
                <div class="col-md-5 col-12">
                     <!-- Tag -->
                    <?php 
                        if($blockList){
                           echo $form->field($model,'block_tag')->dropdownlist($blockList);     
                        }else{
                            echo $form->field($model, 'block_tag')->textInput(['maxlength' => true]);
                        }
                    ?>
                </div>
            </div>

            <?= $this->render($viewName, [
                'model' => $model,                
                'uploadModel' => $uploadModel,
                'image' => $image,
                'form' => $form,
                'listPreviewImg' => $listPreviewImg,
                'initialImgPreviewConfig' => $initialImgPreviewConfig,
                'listPreviewMobileImg' => $listPreviewMobileImg,
                'initialImgMobilePreviewConfig' =>  $initialImgMobilePreviewConfig,
                'listImg' => $listImg,
                'initialPreviewConfig' => $initialPreviewConfig,
                'pdfList' => $pdfList,
                'initialPreviewConfigPdf' => $initialPreviewConfigPdf,
            ]) ?>

            <div class="row mt-5">
                <?php if($model->isNewRecord): ?>
                    <div class="col-md-6 col-12 mb-md-0 mb-4">
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-md-auto col-12 mb-md-0 mb-4">
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('backend', 'Save and modify'), ['class' => 'btn btn-success','name' => 'subaction', 'value' => 'saveMod']) ?>
                        </div>            
                    </div>
                    <div class="col-md-auto col-12 mb-md-0 mb-4">
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('backend', 'Save and return to the list'), ['class' => 'btn btn-success','name' => 'subaction', 'value' => 'saveReturn']) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>   

        </div>        
    <?php // $form->field($model, 'ord')->textInput() ?>
    <?php ActiveForm::end(); ?>
</div><!-- end::view --> 