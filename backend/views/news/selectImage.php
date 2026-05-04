<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use yii\bootstrap5\Modal;
use kartik\file\FileInput;
use yii\widgets\DetailView;
use yii\helpers\Url;    
use backend\helpers\Helpers;
use yii\widgets\Pjax; 
use yii\grid\GridView;

/** @var yii\web\View $this */
$this->title = Yii::t('backend', 'Test selezione immagine');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="image-create">
    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1><?= Html::encode($this->title) ?></h1>                    
                </div>
            </div>
        </div>
    </div>

    <div class="formErrorList">
        Si è verificato un errore durante la creazione dell'elemento. 
        <i class="close bi bi-x-circle"></i>
    </div> 
    
   <div class="card image-form">

        <?php $form = ActiveForm::begin([ 'options' => ['data-pjax' => "0"]]); ?>
        <div class="card-body">

            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="row">
                        <div class="col-12">     
                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class= "col-12">     
                            <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
                        </div>
                    </div>

                    <div class="row mt-md-5 mt-0">    
                        <div class="col-md-3 col-6">
                            <!-- Pubblica news -->
                            <?= $form->field($model, 'is_published')->widget(SwitchInput::className(),  Yii::$app->params['KartikSwitchOptions'] )->label('Pubblica'); ?>
                        </div>

                        <div class="col-md-3 col-6">
                            <!-- Visibilità news Home page -->
                            <?= $form->field($model, 'is_visible_homepage')->widget(SwitchInput::className(),  Yii::$app->params['KartikSwitchOptions'] )->label('Visibile Home Page') ?>
                        </div>
                    </div>           
                </div><!-- end col -->
            </div>

            <!-- PULSANTE APERTRa MODALE -->
            <div class="row mt-5">
                <div class="col">
                    <?php // Control display of widget elements
                        echo $form->field($image, 'imageFile')->widget(FileInput::classname(), [
                                'name' => 'previewImg',
                                'options' => [
                                    'accept' => 'image/*',
                                    'multiple' => false, 
                                ],
                                'pluginOptions' => [
                                'showPreview' => false,
                                'showCaption' => true,
                                'showRemove' => true,
                                'showUpload' => false
                            ]           
                        ])->label('Carica Immagine');
                    ?>
                </div>
                <div class="col d-flex align-items-end">
                    <!-- Button trigger modal -->
                    <p style="margin:0 20px 5px 0;">Oppure </p> 
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#imageSelect">
                        Selezione immagine
                    </button>
                    <?= $form->field($model, 'id_image_preview')->hiddenInput(['id'=>'idImagePreview'])->label(false) ?>

                </div>
            </div>
            
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

    </div><!-- end::image-form -->

    

</div>

<?php  echo $this->render('_modalSelectImage.php', [
            'model'  => $model,
            'imageProvider' => $imageProvider,
            'searchImage' => $searchImage,
            //'imageModel' => $imageModel,
        ]); 
?>