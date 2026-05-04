<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use kartik\file\FileInput;

/** @var yii\web\View $this */
/** @var array $leafOptions [id => 'percorso / nome'] */
/** @var int|null $gara_id */
/** @var common\models\Gara|null $selectedNode */
/** @var common\models\GaraFoto[] $fotos prime 24 foto con ->image caricato */
/** @var int $totalFotos totale foto nel DB per questa gara */

$this->title = Yii::t('backend', 'Carica foto gara');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Gara'), 'url' => ['/gara']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="foto-gara-index">

    <div class="card card-top">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col d-flex card-top-header">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="col-auto">
                    <?= Html::a(
                        '<i class="fas fa-images me-1"></i>' . Yii::t('backend', 'Vai a index immagini'),
                        ['/image/index'],
                        ['class' => 'btn btn-outline-primary']
                    ) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Selezione categoria (solo foglie) -->
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title mb-3"><?= Yii::t('backend', 'Seleziona categoria') ?></h5>

            <?php if (empty($leafOptions)): ?>
                <div class="alert alert-warning">
                    <?= Yii::t('backend', 'Nessuna categoria foglia trovata. Crea almeno un nodo figlio nell\'albero gara.') ?>
                </div>
            <?php else: ?>
                <form method="get" action="<?= Url::to(['/foto-gara/index']) ?>">
                    <div class="row align-items-end g-3">
                        <div class="col-md-8 col-12">
                            <?= Html::dropDownList('gara_id', $gara_id, $leafOptions, [
                                'class'  => 'form-select',
                                'prompt' => '-- ' . Yii::t('backend', 'Seleziona una categoria') . ' --',
                                'id'     => 'gara-leaf-select',
                            ]) ?>
                            <div class="form-text text-muted mt-1">
                                <?= Yii::t('backend', 'Sono elencate solo le categorie foglia (senza sotto-categorie).') ?>
                            </div>
                        </div>
                        <div class="col-md-auto col-12">
                            <?= Html::submitButton(
                                '<i class="fas fa-folder-open me-1"></i>' . Yii::t('backend', 'Apri'),
                                ['class' => 'btn btn-primary']
                            ) ?>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($selectedNode !== null): ?>

        <!-- Upload widget (senza initialPreview: kartik serve solo per caricare) -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title mb-1">
                    <i class="fas fa-cloud-upload-alt me-2 text-primary"></i>
                    <?= Html::encode($leafOptions[$selectedNode->id] ?? $selectedNode->name) ?>
                </h5>
                <p class="text-muted mb-3" style="font-size:.85rem">
                    <?= Yii::t('backend', 'Seleziona o trascina le foto da caricare.') ?>
                </p>

                <?= FileInput::widget([
                    'name'          => 'imageFiles',
                    'options'       => [
                        'id'       => 'foto-gara-fileinput',
                        'accept'   => 'image/*',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'uploadUrl'             => Url::to(['/foto-gara/upload']),
                        'uploadAsync'           => true,
                        'uploadExtraData'       => ['gara_id' => $gara_id],
                        'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'],
                        'maxFileSize'           => 10240,
                        'maxFileCount'          => 200,
                        'showRemove'            => true,
                        'showUpload'            => true,
                        'showCancel'            => true,
                        'dropZoneEnabled'       => true,
                        'dropZoneTitle'         => Yii::t('backend', 'Trascina le foto qui &hellip;'),
                        'fileActionSettings'    => ['showDrag' => false],
                    ],
                ]) ?>

            </div>
        </div>

        <!-- Griglia foto salvate (paginata) -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="fas fa-images me-2"></i>
                    <?= Yii::t('backend', 'Foto salvate') ?>
                    <span class="badge bg-secondary ms-2" id="foto-count"><?= $totalFotos ?></span>
                </h5>

                <p class="text-muted mb-2" id="foto-empty-msg"<?= $totalFotos > 0 ? ' style="display:none"' : '' ?>>
                    <?= Yii::t('backend', 'Nessuna foto ancora caricata.') ?>
                </p>

                <div class="row g-2" id="foto-grid">
                    <?php foreach ($fotos as $garaFoto): ?>
                        <?php
                        $img = $garaFoto->image;
                        if (!$img) continue;
                        $url     = Yii::getAlias('@frontendUploads') . '/' . $img->img_name . $img->img_extension;
                        $caption = $img->img_show_name ?: basename($img->img_name);
                        ?>
                        <div class="col-6 col-md-3 col-lg-2 foto-card" data-id="<?= $garaFoto->id ?>">
                            <div class="card h-100">
                                <img src="<?= Html::encode($url) ?>"
                                     class="card-img-top"
                                     loading="lazy"
                                     style="height:110px;object-fit:cover"
                                     alt="<?= Html::encode($caption) ?>">
                                <div class="card-body p-1 d-flex justify-content-between align-items-center">
                                    <small class="text-truncate me-1" title="<?= Html::encode($caption) ?>">
                                        <?= Html::encode($caption) ?>
                                    </small>
                                    <button class="btn btn-sm btn-danger btn-delete-foto flex-shrink-0"
                                            title="<?= Yii::t('backend', 'Elimina') ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-center mt-3" id="load-more-wrap"<?= $totalFotos <= count($fotos) ? ' style="display:none"' : '' ?>>
                    <button class="btn btn-outline-secondary" id="btn-load-more">
                        <i class="fas fa-chevron-down me-1"></i>
                        <?= Yii::t('backend', 'Carica altre') ?>
                        <span id="load-more-info">(<?= count($fotos) ?> di <?= $totalFotos ?>)</span>
                    </button>
                </div>

            </div>
        </div>

    <?php endif; ?>

</div>

<?php if ($selectedNode !== null):
    $deleteUrl = Json::encode(Url::to(['/foto-gara/delete-photo']));
    $listUrl   = Json::encode(Url::to(['/foto-gara/photo-list']));
    $jsGaraId  = (int) $gara_id;
    $jsTotal   = (int) $totalFotos;
    $jsShown   = count($fotos);

    $this->registerJs(<<<JS
(function () {
    var deleteUrl  = $deleteUrl;
    var listUrl    = $listUrl;
    var garaId     = $jsGaraId;
    var curPage    = 1;
    var totalFotos = $jsTotal;
    var shown      = $jsShown;

    /* ---- Elimina foto ---- */
    \$(document).on('click', '.btn-delete-foto', function () {
        var \$card = \$(this).closest('.foto-card');
        var fotoId = \$card.data('id');
        if (!confirm('Eliminare questa foto?')) return;

        \$.ajax({
            url: deleteUrl,
            method: 'POST',
            data: { key: fotoId, gara_id: garaId, _csrf: yii.getCsrfToken() },
            dataType: 'json',
            success: function (res) {
                if (res.error === '') {
                    \$card.remove();
                    totalFotos--;
                    shown--;
                    \$('#foto-count').text(totalFotos);
                    updateInfo();
                    if (totalFotos === 0) {
                        \$('#foto-empty-msg').show();
                    }
                }
            }
        });
    });

    /* ---- Carica altre ---- */
    \$('#btn-load-more').on('click', function () {
        var \$btn = \$(this).prop('disabled', true);
        curPage++;

        \$.getJSON(listUrl, { gara_id: garaId, page: curPage }, function (res) {
            appendCards(res.items);
            if (!res.hasMore) {
                \$('#load-more-wrap').hide();
            } else {
                \$btn.prop('disabled', false);
                updateInfo();
            }
        });
    });

    /* ---- Aggiorna griglia al termine di ogni batch upload ---- */
    \$('#foto-gara-fileinput').on('filebatchuploadcomplete.fileinput', function () {
        curPage = 1;
        \$.getJSON(listUrl, { gara_id: garaId, page: 1 }, function (res) {
            \$('#foto-grid').empty();
            shown = 0;
            appendCards(res.items);
            totalFotos = res.total;
            \$('#foto-count').text(totalFotos);
            if (totalFotos > 0) {
                \$('#foto-empty-msg').hide();
            }
            if (res.hasMore) {
                \$('#load-more-wrap').show();
                updateInfo();
            } else {
                \$('#load-more-wrap').hide();
            }
        });
    });

    /* ---- Helpers ---- */
    function appendCards(items) {
        if (!items) return;
        \$.each(items, function (i, item) {
            \$('#foto-grid').append(buildCard(item.id, item.url, item.caption));
            shown++;
        });
    }

    function buildCard(id, url, caption) {
        var esc = \$('<span>').text(caption).html();
        return '<div class="col-6 col-md-3 col-lg-2 foto-card" data-id="' + id + '">' +
            '<div class="card h-100">' +
            '<img src="' + url + '" class="card-img-top" loading="lazy" style="height:110px;object-fit:cover" alt="' + esc + '">' +
            '<div class="card-body p-1 d-flex justify-content-between align-items-center">' +
            '<small class="text-truncate me-1" title="' + esc + '">' + esc + '</small>' +
            '<button class="btn btn-sm btn-danger btn-delete-foto flex-shrink-0" title="Elimina"><i class="fas fa-trash"></i></button>' +
            '</div></div></div>';
    }

    function updateInfo() {
        \$('#load-more-info').text('(' + shown + ' di ' + totalFotos + ')');
    }
}());
JS);
endif; ?>
