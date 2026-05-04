<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\ImageSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="image-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'img_name') ?>

    <?= $form->field($model, 'img_show_name') ?>

    <?= $form->field($model, 'img_description') ?>

    <?= $form->field($model, 'img_extension') ?>

    <?php // echo $form->field($model, 'img_width') ?>

    <?php // echo $form->field($model, 'img_height') ?>

    <?php // echo $form->field($model, 'img_content_type') ?>

    <?php // echo $form->field($model, 'img_content_size') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
