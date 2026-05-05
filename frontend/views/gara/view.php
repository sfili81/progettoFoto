<?php

/** @var yii\web\View $this */
/** @var \common\models\Gara $gara */
/** @var string $fotosJson */
/** @var string $listaUrl */

use yii\helpers\Html;

$this->title = $gara->name;
$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gara-view">

    <h1 class="mb-4"><?= Html::encode($gara->name) ?></h1>

    <div id="gara-selector"
         data-fotos="<?= Html::encode($fotosJson) ?>"
         data-lista-url="<?= Html::encode($listaUrl) ?>"></div>

</div>
