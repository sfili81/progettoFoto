<?php

/** @var yii\web\View $this */
/** @var \common\models\Gara[] $gare */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="row">

        <!-- Menu gare -->
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header fw-bold">Gare</div>
                <?php if (empty($gare)): ?>
                    <div class="card-body text-muted small">Nessuna gara disponibile.</div>
                <?php else: ?>
                    <?php
                    $rootLvl = $gare[0]->lvl;
                    ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($gare as $g): ?>
                            <?php
                            $isLeaf = ($g->rgt - $g->lft === 1);
                            $depth  = $g->lvl - $rootLvl;
                            $indent = 12 + $depth * 16;
                            ?>
                            <?php if ($isLeaf): ?>
                                <a href="<?= Url::to(['/gara/view', 'id' => $g->id]) ?>"
                                   class="list-group-item list-group-item-action"
                                   style="padding-left: <?= $indent ?>px">
                                    <?= Html::encode($g->name) ?>
                                </a>
                            <?php else: ?>
                                <div class="list-group-item list-group-item-secondary fw-semibold"
                                     style="padding-left: <?= $indent ?>px">
                                    <?= Html::encode($g->name) ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Contenuto principale -->
        <div class="col-md-9">
            <div class="p-4 bg-transparent rounded-3 mb-4">
                <h1 class="display-5"><?= Html::encode(Yii::$app->name) ?></h1>
                <p class="fs-5 fw-light">Seleziona una gara dal menu per visualizzarne le foto.</p>
            </div>
        </div>

    </div>

</div>
