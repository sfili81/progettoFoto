<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\ContactForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use frontend\helpers\ValidatorHelper;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;

//dd(ValidatorHelper::attributes($model, 'email'));

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'contact-form',
                'enableClientScript'     => false,
                'enableClientValidation' => false,
                'enableAjaxValidation'   => false,
            ]); ?>

            <?= $form->field($model, 'name')->textInput(array_merge(
                ValidatorHelper::attributes($model, 'name'),
                ['autofocus' => false,]
            )) ?>

            <?= $form->field($model, 'surname')->textInput(ValidatorHelper::attributes($model, 'surname')) ?>

            <?= $form->field($model, 'email')->textInput(ValidatorHelper::attributes($model, 'email')) ?>

            <?= $form->field($model, 'subject')->textInput(ValidatorHelper::attributes($model, 'subject')) ?>

            <?= $form->field($model, 'text')->textarea(array_merge(
                ValidatorHelper::attributes($model, 'text'),
                ['rows' => 6,]
            ))  ?>

            <div class="w-full md:col-span-2">
                <?= $form->field($model, 'privacy', [
                    'template' => '<div class="form-group prv mb-3">
                                                            <input type="checkbox" name="ContactForm[privacy]" class="" id="contactform-privacy" value="checked" data-required="true">
                                                            <label for="contactform-privacy" class="form-check-label " data-id="contactform-privacy">
                                                                In base al Reg.UE 2016/679 (GDPR), dichiaro di aver letto l’informativa sulla privacy raggiungibile da questo <a href="" class="iubenda-nostyle no-brand iubenda-noiframe iubenda-embed iubenda-noiframe " title="Privacy Policy ">link</a> e acconsento al trattamento dei miei dati.
                                                            </label></div><div class="invalid-feedback"></div>'
                ])->textInput(['class' => "prv", 'type' => 'checkbox']) ?>
            </div>

            <?php //echo $form->field($model, 'reCaptcha')->widget(\luyadev\recaptcha\ReCaptcha3::class, ['action' => 'homepage'])->label(false)
            ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>