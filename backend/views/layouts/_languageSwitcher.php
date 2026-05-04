<?php

use yii\helpers\Url;


$languages = Yii::$app->params['be_languages'];
$currentLang = Yii::$app->language;
$current = $languages[$currentLang] ?? reset($languages);
?>

<li class="nav-item dropdown ">
    <a class="nav-flag dropdown-toggle ioDropdown" href="#"
        id="languageDropdown"
        aria-expanded="false"
        data-pjax="0"
        data-method="">
        <img src="<?= Yii::getAlias('@backendImg') ?>/flags/<?= $current['flag'] ?>" alt="<?= $current['label'] ?>">
    </a>
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown" data-bs-popper="static">
        <?php foreach ($languages as $code => $data): ?>
            <a class="dropdown-item" href="<?= Url::to(['site/change-language', 'lang' => $code]) ?>">
                <img src="<?= Yii::getAlias('@backendImg') ?>/flags/<?= $data['flag'] ?>" width="20" class="align-middle me-1" alt="<?= $data['label'] ?>">
                <span class="align-middle"><?= $data['label'] ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</li>