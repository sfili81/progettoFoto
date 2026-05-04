<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\helpers\Helpers;

/** @var yii\web\View $this */
/** @var common\models\News $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="news-view">

    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1 class="h3"><?= Html::encode($this->title) ?></h1>
                    
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
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="meta-tab" data-bs-toggle="tab" data-bs-target="#meta" type="button" role="tab" aria-controls="meta" aria-selected="false">Meta</button>
                        </li>
                    </ul>   
                    <div class="card-body news-view">
                        <div class="row">
                            <div class="col mt-0 tab-content">
                                 <div class="tab-pane fade show active" id="dettagli" role="tabpanel" aria-labelledby="dettagli-tab">  
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            ['attribute' => 'title',
                                             'label'     => 'Titolo',
                                            ],
                                            ['attribute' => 'subtitle',
                                             'label'     => 'Sottotitolo',
                                            ],
                                            ['attribute' => 'date',
                                             'label'     => 'Data',
                                            ],
                                            ['attribute' => 'preview',
                                             'label'     => 'Testo anteprima',
                                             'format' => 'raw',
                                            ],
                                             ['attribute' => 'text',
                                             'label'     => 'Testo',
                                             'format' => 'raw',
                                            ],
                                            ['attribute' => 'is_published',
                                                'label'     => 'Pubblicata',
                                                'format'   => 'raw',
                                                'value'    => function ( $model) { return Helpers::showVisibility($model->is_published);},
                                                ],
                                            ['attribute' => 'is_published',
                                                'label'     => 'Visibilità home page',
                                                'format'   => 'raw',
                                                'value'    => function ( $model) { return Helpers::showVisibility($model->is_visible_homepage);},
                                                ],
                                        ],
                                    ]) ?>
                                </div>
                                <!-- VISUALIZZA IMMAGINI -->
                                <div class="tab-pane fade" id="immagini" role="tabpanel" aria-labelledby="immagini-tab">
                                    <?php
                                        if($model->id_image_preview){    
                                            echo '<h3 class="mb-3">Immagine anteprima</h3>';
                                            echo "<figure>";
                                                echo Html::img( Yii::getAlias('@frontendUploads') . "/" . $model->imagePreview->img_name, ['width' => '250px', ]);
                                            echo "</figure>";
                                        }
                                    ?>
                                    
                                    <?php 
                                        if($list_img){
                                            echo '<h3 class="mb-3">Immagini</h3>';
                                            echo "<div class='row'>";
                                                foreach($list_img as $img){
                                                    echo "<div class='col-md-2'>";
                                                        echo "<figure>";
                                                            echo Html::img( Yii::getAlias('@frontendUploads') . "/" . $img['name'] .'.'. $img['extension'], ['width' => '250px', ]);
                                                            echo "<figcaption>".$img['name']."</figcaption>";
                                                        echo "</figure>";
                                                    echo "</div>";
                                                }
                                            echo "</div>";
                                        }
                                    ?>
                                </div>

                                <!-- VISUALIZZA META DATI -->
                                <div class="tab-pane fade" id="meta" role="tabpanel" aria-labelledby="meta-tab">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <h3 class="mb-3">Meta Description</h3>
                                            <?= $model->meta_description ?>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <h3 class="mb-3">Meta Keywords</h3>
                                            <?= $model->meta_keywords ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div><!-- end::card-body -->
                </div><!-- end::card -->
            </div><!-- end w-100-->                
        </div>
    </div><!-- end::row -->


</div>

<?php

echo "<pre>";
//var_dump(json_decode($model->images));
