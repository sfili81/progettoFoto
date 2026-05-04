<?php

use yii\helpers\Html;
use yii\helpers\Url;

// Lingue dal params
$languages = Yii::$app->params['languages'];

// Lingua attuale
$currentLang = Yii::$app->language;

// Route attuale + parametri GET
$route = Yii::$app->controller->getRoute();
$params = Yii::$app->request->queryParams;

?>

<ul class="language-switcher">
    <?php foreach ($languages as $code => $language): ?>
        <li class="<?= $currentLang === $code ? 'active' : '' ?>">
            <?= Html::a(
                Html::encode($language['label']),
                Url::to(array_merge(['/' . $route], $params, ['language' => $code]))
            ) ?>
        </li>
    <?php endforeach; ?>
</ul>