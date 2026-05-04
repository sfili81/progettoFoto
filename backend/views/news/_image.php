<?php
use yii\helpers\Html;
?>


<div class="imageselect-item" data-name="<?= $model->img_name ?>" data-key="<?= $model->id ?>">
    <?= Html::img('@frontendUploads/'.$model->img_name . $model->img_extension , ['alt' => '', 'width' => '150']) ?>
    <p><?= preg_replace("/^\d+\_{1}/", "", $model->img_name) ?></p>
</div>
