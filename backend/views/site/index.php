<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\helpers\Url;

/** Application name  **/
$this->title =  $_ENV['APP_NAME'];


?>

<div class="card flex-fill w-100">
    <div class="card-body">
        <div class="jumbotron text-center bg-transparent">
            <h1 class="display-4"> <?= \Yii::t('backend', 'Welcome'); ?> !</h1>

            <p class="lead"></p>
        </div>

        <div class="body-content">
            <?php if (Yii::$app->user->can('admin')): ?>
                <div class="row justify-content-md-center">
                    <div class="col-lg-4 d-flex flex-column align-items-center">
                        <!-- PAGINA ADMIN KIT -->
                        <h2>Vedi Sito</h2>
                        <p><a class="btn btn-outline-secondary" href="<?= Yii::$app->request->hostInfo ?>" target="_blank">Vedi Sito &raquo;</a></p>
                    </div>

                    <div class="col-lg-4 d-flex flex-column align-items-center">
                        <!-- GII -->
                        <h2>GII Crud Generator</h2>
                        <p><a class="btn btn-outline-secondary" href="<?= Url::base(); ?>/gii" target="_blank">Vedi &raquo;</a></p>
                    </div>

                </div><!-- end::row-->
            <?php endif ?>
            <!-- TEST -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <a href="<?= Yii::$app->request->hostInfo ?>" target="_blank" class="small-box-link"></a>
                        <div class="inner">
                            <div>
                                <h3>Sito</h3>
                                <p></p>
                            </div>
                            <div class="icon">
                                <i class="fa-regular fa-browser"></i>
                            </div>
                        </div>
                        <span class="small-box-footer">Visualizza <i class="fas fa-arrow-circle-right"></i></span>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <a href="<?= Url::to(['product/index']) ?>" class="small-box-link"></a>
                        <div class="inner">
                            <div>
                                <h3>Prodotti</h3>
                                <p></p>
                            </div>
                            <div class="icon">
                                <i class="fa-regular fa-chair"></i>
                            </div>
                        </div>
                        <span class="small-box-footer">Sezione Prodotti <i class="fas fa-arrow-circle-right"></i></span>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <a href="<?= Url::to(['request/index']) ?>" class="small-box-link"></a>
                        <div class="inner">
                            <div>
                                <h3>Richieste</h3>
                                <p></p>
                            </div>
                            <div class="icon">
                                <i class="fa-light fa-pencil"></i>
                            </div>
                        </div>
                        <span class="small-box-footer">Vedi Richieste <i class="fas fa-arrow-circle-right"></i></span>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <a href="<?= Url::to(['company/update']) ?>" class="small-box-link"></a>
                        <div class="inner">
                            <div>
                                <h3>Azienda</h3>
                                <p></p>
                            </div>
                            <div class="icon">
                                <i class="fa-light fa-building"></i>
                            </div>
                        </div>
                        <span class="small-box-footer">Dettagli Azienda <i class="fas fa-arrow-circle-right"></i></span>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- END TEST -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-body news-view">
                <h3>Lista Estensioni già presenti nel progetto</h3>
                <ul>
                    <li><a href="https://demos.krajee.com/widget-details/fileinput" title="" target="_blank">File input (Multiple upload etc etc)</a></li>
                    <li><a href="https://demos.krajee.com/widget-details/datepicker" title="" target="_blank">Date Picker</a></li>
                    <li><a href="https://github.com/bizley/yii2-quill" title="" target="_blank">Yii2 Quill</a> - WYSIWYG test editor</li>
                    <li><a href="https://github.com/bizley/yii2-migration" title="" target="_blank">Migration Tool </a> - creazione di migrazioni per DB</li>
                    <li><a href="https://github.com/yiisoft/yii2-twig" title="" target="_blank">Yii2 Twig </a> - estensione twig per yii2</li>
                    <li><a href="https://github.com/luyadev/yii2-recaptcha-widget?tab=readme-ov-file" target="_blank" title="">Yii2 reCAPTCHA</a> - google reCAPTCHA v3 [Versione mantenuta]</li>
                    <li><a href="https://github.com/sjaakp/yii2-sortable-behavior" title="" target="_blank">Sortable gridView</a></li>
                    <li><a href="https://demos.krajee.com/mpdf" title="" target="_blank">Yii2-mpdf</a> generate PDF files from HTML</li>
                    <li><a href="https://github.com/vlucas/phpdotenv" title="" target="_blank">PHP dotenv</a> PHP DotEnv for Yii2 framework</li>
                </ul>
            </div><!-- end::card-body -->
        </div>
    </div>

    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-body news-view">
                <h3>Lista Estensioni utili da integrare</h3>
                <ul>
                    <li><a href="https://demos.krajee.com/grid" target="_blank" title="">Kartik GridView</a> (Estensione per GridView)</li>
                    <li><a href="https://github.com/sjaakp/yii2-sortable-behavior" target="_blank" title="">Sortable GridView</a> (Riordinamento ActiveRecord tramite drag and drop)</li>
                    <li><a href="https://github.com/yii2-extensions/summernote?trk=article-ssr-frontend-pulse_little-text-block" target="_blank" title="">Summernote text editor</a></li>
                    <li><a href="https://www.sjaakpriester.nl/software/index" target="_blank" title="">Various Yii2 Extensions</a></li>
                    <li><a href="https://github.com/yiisoft/yii2-apidoc" target="_blank" title="">Estensione per generare documentazione</a></li>
                    <li><a href="https://github.com/yii2mod/yii2-rbac" target="_blank" title="" style="color:red;">Estensione per generare Rbac direttamente da backend [TESTARE]</a></li>
                    <li><a href="https://github.com/sfili81/imageConverter" target="_blank" title="">Estensione per generare file webp/avif al volo</a></li>
                    <li><a href="https://github.com/yiisoft/strings" title="" target="_blank">YII2 String Helper</a> </li>
                </ul>
            </div><!-- end::card-body -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body news-view">
                <div>
                    <canvas id="myChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo Url::home(true);
echo '<pre>';
var_dump(Yii::$app->params);
