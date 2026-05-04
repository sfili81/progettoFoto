<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="site-signup">

<div class="container-fluid p-0" >

    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col d-flex">
                <h1 class="h3 mb-3">Signup</h1>
                </div>
                <div class="col d-flex justify-content-end">
                   
                </div>
            </div>
        </div>
    </div>

    <div class="row">
		<div class="col d-flex">
			<div class="w-100">
                <div class="card">
                    <div class="card-body news-index">
                        <div class="row">
                            <div class="col mt-0">
                                
                                <!-- Content Goes Here -->
                                <div class="col-lg-5">
                                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                                    <?= $form->field($model, 'email') ?>

                                    <?= $form->field($model, 'password')->passwordInput() ?>

                                    <div class="form-group">
                                        <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                                    </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                            </div>
                        </div>
                    </div><!-- end::card-body -->
                </div><!-- end::card -->
            </div><!-- end w-100-->                
        </div>
    </div><!-- end::row -->

</div><!-- end::container fluid -->

   