<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

//Url::to('@web/uploads/pdf/Analytics-Mania-Working-in-GA4-reports.pdf')

$this->title = Yii::$app->name; /* $page->pages_meta_title ?: Yii::$app->name; */
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Congratulations!</h1>
            <p class="fs-5 fw-light">La stringa qui sopra è tradotta da db</p>
            <p><a class="btn btn-lg btn-success" href="https://www.yiiframework.com">Get started with Yii</a></p>
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 ">
                <h2>TWIG</h2>

                <p> <?= Html::a('Esempio vista twig', ['twig-example'], ['class' => 'profile-link']) ?></p>
                <p> <?= Html::a('Twig ita doc', ['https://www.html.it/pag/397396/introduzione-a-twig/'], ['class' => 'profile-link']) ?> </p>

                <?= \Yii::t('app', 'Welcome'); ?>


                <p><a class="btn btn-outline-secondary" href="https://twig.symfony.com/doc/3.x/">Twig Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="https://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p><?= Html::a('?', ['site/news'], ['class' => 'btn btn-outline-secondary']) ?></p>

            </div>
        </div>

        <div class="bg-gradient-to-b from-gray-700 to-gray-900"> TEST TAILWIND</div>




        <div id="pdf-viewer"
            data-pdf-url="<?= Url::to('@web/uploads/pdf/Analytics-Mania-Working-in-GA4-reports.pdf') ?>"
            data-pdf-mode="single"> <!-- oppure "multi" -->

            <!-- Controls visibili solo in modalità single -->
            <div id="pdf-controls">
                <button class="pdf-btn" data-action="prev">⬅️ Prev</button>
                <span id="pdf-page-info">Pagina <span id="pdf-current-page">1</span> / <span id="pdf-total-pages">?</span></span>
                <button class="pdf-btn" data-action="next">Next ➡️</button>

                <button class="pdf-btn" data-action="zoom-out">➖</button>
                <button class="pdf-btn" data-action="zoom-in">➕</button>
                <button class="pdf-btn" data-action="zoom-reset">🔄</button>
            </div>

            <!-- canvas per single-page -->
            <canvas id="pdf-canvas"></canvas>

            <!-- container per multi-page -->
            <div id="pdf-pages"></div>
        </div>


    </div>
</div>