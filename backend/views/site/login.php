<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use backend\assets\AdminkitAsset;

//AppAsset::register($this);
AdminkitAsset::register($this);

$this->title = 'Login';
?>


<div class="site-login">
    <?= Html::img( Yii::getAlias('@backendImg') . "/iosystems-logo.svg", ['width' => '230px']) ?> 
    <!-- <h1>Vivicoglians</h1> -->
    
    <div class="wrap-loginForm">
        
        <p>Autenticazione</p>
       
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'Placeholder' => 'Username'])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['Placeholder' => 'Password'])->label(false) ?>

            <?= $form->field($model, 'rememberMe')->checkbox()->label('Ricordami') ?>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>