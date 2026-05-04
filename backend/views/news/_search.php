<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\NewsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="news-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'news_title') ?>

    <?= $form->field($model, 'news_slug') ?>

    <?= $form->field($model, 'news_subtitle') ?>

    <?= $form->field($model, 'news_date') ?>

    <?php // echo $form->field($model, 'news_preview') ?>

    <?php // echo $form->field($model, 'news_text') ?>

    <?php // echo $form->field($model, 'news_images') ?>

    <?php // echo $form->field($model, 'news_is_published') ?>

    <?php // echo $form->field($model, 'news_is_visible_homepage') ?>

    <?php // echo $form->field($model, 'news_meta_description') ?>

    <?php // echo $form->field($model, 'news_meta_keywords') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
