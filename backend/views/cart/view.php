<?php

use common\models\Cart;
use common\models\Images;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\helpers\Helpers;

/** @var yii\web\View $this */
/** @var common\models\Cart $model */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Carts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$images = json_decode($model->list_images, true) ?? [];
$imageIds = array_column($images, 'id');
$imageRecords = $imageIds ? Images::find()->where(['id' => $imageIds])->indexBy('id')->all() : [];
?>
<div class="cart-view">

    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1 class="h3">Codice Atleta: <?= Html::encode($this->title) ?></h1>                    
                </div>
                <div class="col-md-2 mt-md-0 mt-3 col-12 d-flex justify-content-start justify-content-md-end">
                    <p>
                        <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>	

    <div class="row">
		<div class="col d-flex">
			<div class="w-100">
                <div class="card">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dettagli-tab" data-bs-toggle="tab" data-bs-target="#dettagli" type="button" role="tab" aria-controls="dettagli" aria-selected="true">Dettagli</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="immagini-tab" data-bs-toggle="tab" data-bs-target="#immagini" type="button" role="tab" aria-controls="immagini" aria-selected="false">Immagini</button>
                        </li>
                    </ul>   
                    <div class="card-body news-view">
                        <div class="row">
                            <div class="col mt-0 tab-content">
                                 <div class="tab-pane fade show active" id="dettagli" role="tabpanel" aria-labelledby="dettagli-tab">  
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            [
                                            'attribute' => 'state',
                                            'label' => 'Stato',
                                            'format' => 'raw',
                                            'value'  => function (Cart $model) {return Helpers::showStateRequest($model);},
                                            ],
                                            'email:email',
                                            'code',
                                            'note:ntext',
                                            'internal_details:ntext',
                                        ],
                                    ]) ?>
                                </div>
                                <!-- VISUALIZZA IMMAGINI -->
                                <div class="tab-pane fade" id="immagini" role="tabpanel" aria-labelledby="immagini-tab">
                                    <?php if (empty($images)): ?>
                                        <p class="text-muted mt-3">Nessuna immagine in questa lista.</p>
                                    <?php else: ?>
                                    <table class="table table-hover mt-3">
                                        <thead>
                                            <tr>
                                                <th>Anteprima</th>
                                                <th>Nome</th>
                                                <th>Azioni</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($images as $item): ?>
                                            <?php $rec = $imageRecords[$item['id']] ?? null; ?>
                                            <tr>
                                                <td>
                                                    <?php if ($rec): ?>
                                                        <?= Html::img('@frontendUploads/' . $rec->img_name . $rec->img_extension, ['width' => 80, 'alt' => '']) ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= Html::encode($rec ? ($rec->img_show_name ?: $rec->img_name) : $item['name']) ?></td>
                                                <td>
                                                    <?= Html::a('Dettaglio', Url::to(['/image/view', 'id' => $item['id']]), ['class' => 'btn btn-sm btn-primary']) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div><!-- end::card-body -->
                </div><!-- end::card -->
            </div><!-- end w-100-->                
        </div>
    </div><!-- end::row -->

</div>
