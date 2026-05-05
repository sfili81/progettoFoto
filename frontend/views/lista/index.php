<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'La mia lista foto';
$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lista-view">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <div id="lista-foto"></div>

</div>
