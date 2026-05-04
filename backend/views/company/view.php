<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Company $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Companies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="company-view">

    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="col-md-2 mt-md-0 mt-3 col-12 d-flex justify-content-start justify-content-md-end">
                    <p>
                        <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
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
                    <div class="card-body news-view">
                    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'address:ntext',
            'email:email',
            'phone',
            'phone_mobile',
            'whatsapp',
            'pec',
            'p_iva',
            'social_capital',
            'rea',
            'facebook',
            'instagram',
            'youtube',
            'created_at',
            'updated_at',
        ],
    ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
