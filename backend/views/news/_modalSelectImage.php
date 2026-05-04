
<?php
use yii\widgets\Pjax; 
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Html;
//use yii\bootstrap5\ActiveForm;
use yii\widgets\ActiveForm;
?>

<!-- Modal -->
<div class="modal fade" id="imageSelect" tabindex="-1" aria-labelledby="imageSelectLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageSelectLabel"><?= Yii::t('backend', 'Select image') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
            Pjax::begin([
                'id'=>'pjax-t',
                'timeout' => false,
                'enablePushState' => false,
            ]);

            $form = ActiveForm::begin([
                        'action' => ['select-image'],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => 1
                        ],
                    ]); 

                echo $form->field( $searchImage, 'img_name');            
                echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary mt-3']) ;
            ActiveForm::end(); 
            
            echo ListView::widget([
                'dataProvider' => $imageProvider,
                'itemView' => '_image',
                'options' => [
                        'class' => 'imageselect-wrapper ',
                        'id' => 'imageselect',
                ],
                'itemOptions' => ['class' => 'imageselect-item','data-name' => '?', 'tag' => false]//remove tag view container 'layout' => "<li>{item}</li>"
            ]);

            Pjax::end();
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>