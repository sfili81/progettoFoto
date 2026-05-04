<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var yii\gii\generators\crud\Generator $generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var <?= ltrim($generator->modelClass, '\\') ?> $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="formErrorList">
    <?= "<?= " . $generator->generateString('An error occurred while creating the item.') . " ?>" ?> <i class="close far fa-times-circle"></i>
</div>

<div class="card <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="dettagli-tab" data-bs-toggle="tab" data-bs-target="#dettagli" type="button" role="tab" aria-controls="dettagli" aria-selected="true"><?= "<?= " . $generator->generateString('Details') . " ?>" ?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="immagini-tab" data-bs-toggle="tab" data-bs-target="#immagini" type="button" role="tab" aria-controls="immagini" aria-selected="false"><?= "<?= " . $generator->generateString('Images') . " ?>" ?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="meta-tab" data-bs-toggle="tab" data-bs-target="#meta" type="button" role="tab" aria-controls="meta" aria-selected="false"><?= "<?= " . $generator->generateString('Meta') . " ?>" ?></button>
        </li>
    </ul>

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
    <div class="card-body">
        <div class="tab-content">
            <!-- DETTAGLI -->
            <div class="tab-pane fade show active" id="dettagli" role="tabpanel" aria-labelledby="dettagli-tab">
                <?php foreach ($generator->getColumnNames() as $attribute) {
                    if (in_array($attribute, $safeAttributes)) {
                        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
                    }
                } ?>
            </div>
            <!-- IMMAGINI -->
            <div class="tab-pane fade show " id="immagini" role="tabpanel" aria-labelledby="immagini-tab">
            </div>
            <!-- SEO -->
            <div class="tab-pane fade show " id="seo" role="tabpanel" aria-labelledby="seo-tab">
            </div>
        </div><!-- end::tab-content -->
        <div class="row mt-5">
            <div class="col-md-auto col-12 mb-md-0 mb-4">
                <div class="form-group">
                    <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Save and modify') ?>, ['class' => 'btn btn-success','name' => 'subaction', 'value' => 'saveMod']) ?>
                </div>
            </div>
            <div class="col-md-auto col-12 mb-md-0 mb-4">
                <div class="form-group">
                    <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Save and return to the list') ?>, ['class' => 'btn btn-success','name' => 'subaction', 'value' => 'saveReturn']) ?>
                </div>
            </div>
        </div>


    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>