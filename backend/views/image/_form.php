<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\bootstrap5\Modal;

use \softark\cropper\Cropper;

/** @var yii\web\View $this */
/** @var backend\models\Image $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="card image-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card-body">

        <div class="row">
            <div class="col-md-6 col-12">
                <div class="row">
                    <div class="col-12">     
                        <?= $form->field($model, 'img_show_name')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class= "col-12">     
                        <?= $form->field($model, 'img_description')->textarea(['rows' => 6]) ?>
                    </div>
                </div>

                <div class="row mt-md-5 mt-0">    
                    <div class="col-12">
                        <!-- Campo Immagine--> 
                        <?php //normale 
                            echo $form->field($model, 'imageFile')->widget(FileInput::classname(), [
                                'name' => 'imageFile',
                                'options' => [
                                    'accept' => 'image/*', 
                                ],
                                'pluginOptions' => [
                                    'showRemove' => false ,
                                    'showUpload' => false ,
                                    'showPreview' => false ,
                                ]            
                            ]);
                        ?>

                        <?php
                        /*******************************************************************************************/
                        //test input con BS Cropper
                           /* echo $form->field($model, '_image')->widget(Cropper::class, [

                                        // Unique ID of the cropper. Will be set automatically if not set.
                                        'uniqueId' => 'image_cropper',

                                        // The url of the initial image.
                                        // You can set the current image url for update scenario, and
                                        // set null for create scenario.
                                        // Defaults to null.
                                        'imageUrl' => ($model->isNewRecord) ? null : Yii::getAlias('@imagesUrl') .'/' .$model->img_name.$model->img_extension,
                                        
                                        // Cropper options
                                        'cropperOptions' => [
                                            // The dimensions of the image to be cropped and saved.
                                            // You have to specify both width and height.
                                            'width' => 1024,
                                            'height' => 768,
                                            
                                            'aspectRatioì' => 16 / 9,

                                            // Preview window options
                                            'preview' => [
                                                // The dimensions of the preview image must be specified.
                                                'width' => 600, // you can set as string '100%'
                                                'height' => 400, // you can set as string '100px'
                                                // The url of the initial image for the preview.
                                                'url' => (!empty($model->img_name)) ? Yii::getAlias('@imagesUrl' . '/' . $model->img_name.$model->img_extension) : null,
                                            ],

                                            // Whether to use FontAwesome icons
                                            'useFontAwesome' => false, // default = false : use Unicode Chars
                                        ],
                                        
                                        // Modal options
                                        'modalOptions' => [
                                            // Specify the size of the modal.
                                            // 'modal-md', 'modal-lg', or 'modal-xl'
                                            // Default and recommended value is 'modal-lg'
                                            'modalClass' => 'modal-lg',
                                        ],
                                    ]);*/

                        ?>

                    </div>
                </div>           
            </div><!-- end col -->

            <div class="col-md-6 col-12">

                <?php
                    echo $form->field($model, 'saveFormat')->radioList( ['webp' => Yii::t('backend', 'Save WebP Format'), 
                                                                         'avif' => Yii::t('backend', 'Save Avif Format'),
                                                                         'original' => Yii::t('backend', 'Original')], 
                                                                        ['unselect' => null,'class' => 'radioList'] );
                ?>
            
            </div><!-- end col -->
        </div>





        <?php // $form->field($model, 'img_name')->textInput(['maxlength' => true]) ?>

        <?php // $form->field($model, 'img_extension')->textInput(['maxlength' => true]) ?>

        <?php // $form->field($model, 'img_width')->textInput() ?>

        <?php // $form->field($model, 'img_height')->textInput() ?>

        <?php // $form->field($model, 'img_content_type')->textInput(['maxlength' => true]) ?>

        <?php // $form->field($model, 'img_content_size')->textInput() ?>

        <?php // $form->field($model, 'created_at')->textInput() ?>

        <?php // $form->field($model, 'updated_at')->textInput() ?>
        
        <div class="row mt-5">
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
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
