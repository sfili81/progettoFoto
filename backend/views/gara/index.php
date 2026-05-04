<?php

use backend\components\CustomTreeView;
use common\models\Gara;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('backend', 'Gara');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-index">
    <div class="card card-top">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col d-flex card-top-header">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-reset-gara">
                        <i class="fas fa-trash-alt me-1"></i>
                        <?= Yii::t('backend', 'Cancella tutto') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php echo CustomTreeView::widget([
                'query'            => Gara::find()->addOrderBy('root, lft'),
                'headingOptions'   => ['label' => 'Filtri'],
                'fontAwesome'      => false,
                'isAdmin'          => Yii::$app->user->can('admin'),
                'displayValue'     => 1,
                'softDelete'       => false,
                'showIDAttribute'  => false,
                'cacheSettings'    => ['enableCache' => true],
                'hideTopRoot'      => true,
                'rootOptions'      => ['label' => '', 'icon' => ''],
                'iconEditSettings' => ['show' => 'none'],
                'options'          => ['id' => 'kv-gara-widget'],
                'treeWrapperOptions' => [
                    'style' => 'border:1px solid #dee2e6;border-radius:10px;overflow:hidden;',
                ],
                'treeOptions' => [
                    //'style' => 'height:auto;/*max-height:600px;overflow-y:auto;*/',
                ],
                'searchOptions' => [
                    'class'       => 'form-control form-control-sm kv-search-input',
                    'placeholder' => 'Cerca...',
                ],
            ]); ?>
        </div>
    </div>
</div>

<!-- Modal conferma reset -->
<div class="modal fade" id="modal-reset-gara" tabindex="-1" aria-labelledby="modal-reset-gara-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modal-reset-gara-label">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= Yii::t('backend', 'Cancella tutto') ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><?= Yii::t('backend', 'Stai per eliminare:') ?></p>
                <ul>
                    <li><?= Yii::t('backend', "l'intero albero delle gare") ?></li>
                    <li><?= Yii::t('backend', 'tutte le foto caricate') ?></li>
                    <li><?= Yii::t('backend', 'tutti i file su disco') ?></li>
                </ul>
                <p class="text-danger fw-bold mb-0">
                    <?= Yii::t('backend', 'Questa operazione è irreversibile.') ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <?= Yii::t('backend', 'Annulla') ?>
                </button>
                <button type="button" class="btn btn-danger" id="btn-confirm-reset">
                    <i class="fas fa-trash-alt me-1"></i>
                    <?= Yii::t('backend', 'Sì, cancella tutto') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$resetUrl = Url::to(['/gara/reset-all']);

$js = <<<JS
$(function () {
    var \$el    = $('#kv-gara-widget');
    var modalEl = document.getElementById('kv-node-modal');
    if (modalEl) {
        var kvModal = new bootstrap.Modal(modalEl);

        \$el.on('treeview:beforeselect', function () {
            kvModal.show();
        });
    }

    // Pulsante "Modifica" personalizzato nelle righe dell'albero
    $(document).on('click', '.kv-btn-edit', function (e) {
        e.stopPropagation();
        var key = $(this).closest('li').data('key');
        \$el.treeview('select', [key]);
    });

    // Pulsante "Elimina" personalizzato nelle righe dell'albero
    $(document).on('click', '.kv-btn-delete', function (e) {
        e.stopPropagation();
        var key = $(this).closest('li').data('key');
        \$el.treeview('select', [key]);
        setTimeout(function () {
            \$el.treeview('remove');
        }, 100);
    });

    // Cancella tutto
    $('#btn-confirm-reset').on('click', function () {
        var \$btn = $(this)
            .prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-1"></i>...');

        $.ajax({
            url: '$resetUrl',
            method: 'POST',
            data: { _csrf: yii.getCsrfToken() },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    window.location.reload();
                } else {
                    alert('Errore durante il reset.');
                    \$btn.prop('disabled', false)
                        .html('<i class="fas fa-trash-alt me-1"></i> Sì, cancella tutto');
                }
            },
            error: function () {
                alert('Errore di rete.');
                \$btn.prop('disabled', false)
                    .html('<i class="fas fa-trash-alt me-1"></i> Sì, cancella tutto');
            }
        });
    });
});
JS;
$this->registerJs($js);
?>
