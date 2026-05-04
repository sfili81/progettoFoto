<?php
    /** @var yii\web\View $this */
    use yii\bootstrap5\Html;
    use yii\bootstrap5\Modal;

    use yii\helpers\Url;
    //use kartik\editors\Summernote;   
    //use kartik\editors\Codemirror;
    use yii\bootstrap5\ActiveForm;
    // kartik\form\ActiveForm;


    //use dosamigos\ckeditor\CKEditor;


   

    /** Application name  **/
    $this->title = 'yii CMS - test view';
?>

<div class="container-fluid p-0" >

    <div class="card card-top">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 col-12 d-flex card-top-header">
                    <h1 class="h3">Header Example</h1>                    
                </div>
                <div class="col-md-2 mt-md-0 mt-3 col-12 d-flex justify-content-start justify-content-md-end">
                    <p>
                        <?= Html::a('Update', ['update', 'id' => ''], ['class' => 'btn btn-primary']) ?>
                                    <?= Html::a('Delete', ['delete', 'id' => ''], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
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
                            <button class="nav-link active" id="dettagli-tab" data-bs-toggle="tab" data-bs-target="#dettagli" type="button" role="tab" aria-controls="dettagli" aria-selected="true">Tab1</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="immagini-tab" data-bs-toggle="tab" data-bs-target="#immagini" type="button" role="tab" aria-controls="immagini" aria-selected="false">Tab2</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="meta-tab" data-bs-toggle="tab" data-bs-target="#meta" type="button" role="tab" aria-controls="meta" aria-selected="false">Tab3</button>
                        </li>
                    </ul>  

                    <div class="card-body news-view">
                        
                        <div class="tab-content">
                            <!-- DETTAGLI -->    
                            <div class="tab-pane fade show active" id="dettagli" role="tabpanel" aria-labelledby="dettagli-tab">
                                <div class="row">
                                    <div class="col mt-0 tab-content">
                                        <div class="tab-pane fade show active" id="dettagli" role="tabpanel" aria-labelledby="dettagli-tab">  
                                        Contenuto
                                        <?php
                                        Modal::begin([
                                                'title' => 'Hello world',
                                                'toggleButton' => ['label' => 'Esempio modale', 'class' => 'btn btn-light'],
                                            ]);

                                            echo 'Say hello...';

                                            Modal::end();
                                        ?>


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

</div>	<!-- end:container fluid-->
       

