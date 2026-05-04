<?php

namespace backend\controllers;

use Yii;
use backend\models\Image;
use backend\models\ImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\InvalidRouteException;
use yii\filters\VerbFilter;
use backend\models\UploadFiles;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
//use backend\traits\ImageTrait;
use yii\data\ActiveDataProvider;

/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Image models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Image model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Image model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        
        $model = new Image();
        $uploadModel  = new UploadFiles();
        $model->saveFormat = 'original';
        //get values from both models
        if ($model->load($this->request->post())  ) {   

            //Get the uploaded file even is cropper is defined
            //It can be empty 
            $model->imageFile =  UploadedFile::getInstance( $model, 'imageFile');
            //Call upload image to server 
            $model->uploadSingleImage(  preview_tag: 'preview', format: $model->saveFormat); 
                       
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                dd($model->getErrors()); 
            }
        }else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'uploadModel'  => $uploadModel,
        ]);
    }

    /**
     * Updates an existing Image model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $uploadModel  = new UploadFiles();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            switch($this->request->post('subaction')){
                case 'saveMod': return $this->redirect(['update','id' => $model->id]); 
                case 'saveReturn': return $this->redirect(['index']); 
                default: return $this->redirect(['update','id' => $model->id]);
            }
            //return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'uploadModel'  => $uploadModel,
        ]);
    } 

    /**
     * Test con Cropper JS
     *
     * @return string
     */
    public function actionCropperJs(){
        $model = new Image();

    if ($this->request->isPost && $model->load($this->request->post()) ) {

        //Get the uploaded file even is cropper is defined
        //It can be empty 
        $model->imageFile =  UploadedFile::getInstance( $model, 'imageFile');
        //Call upload image to server 
        $model->uploadSingleImage(  preview_tag: 'preview', format: $model->saveFormat);
        
        //$model->save()
    }

        return $this->render('cropperExample', [
            'model' => $model,
        ]); 
    }
    

    /**
     * Deletes an existing Image model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $path = Yii::getAlias('@webroot') ."/uploads/images/". $model->img_name . $model->img_extension;
        $path = Yii::getAlias('@frontendUploads') ."/". $model->img_name . $model->img_extension;
        
        //dd($path);
        dd(@unlink($path));
        //@unlink(Yii::getAlias('@imagesPath') . '/' . $this->img_name);
        
        dd('blocked');
        //
        //dd(dirname(dirname(__FILE__)));
        //dd(Yii::$app->basePath."/uploads/images/". $model->img_name); 
        //dd($path);

        //$model->delete();
        //dd(FileHelper::unlink('localhost/yii-cms/backend/web/uploads/images/415034126_preview_lake.jpg') );

        return $this->redirect(['index']);
    }

    /**
     * Finds the Image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Image::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
    }

    /* TEST IMMAGINI PER CHART.JS */
    public function actionChartImg(){
        $provider = new ActiveDataProvider([
            'query' => Image::find(),
            'sort'=> [
                'defaultOrder' => [
                    'created_at' => SORT_ASC
                ]
            ],
        ]);

        // get the posts in the current page
        $images = $provider->getModels();

        if (Yii::$app->request->isAjax) {
            $data = array();
            foreach($images as $image){
                $month_key = date('F', $image->created_at);
                if(array_key_exists($month_key, $data)){
                    // If we've already added this month to the new array, add the value
                    $data[$month_key] += 1;
                }else{
                    // Otherwise create a new element with month as key and store the value
                    $data[$month_key] = 0;
                }
            }

            //$dateTime = date('Y-m-d H:i:s', $timestamp);
            //dd($data);
            return json_encode($data);
            
        }else{
            throw new NotFoundHttpException(Yii::t('backend', 'The requested page can be accessed only for ajax purpose.'));
        }
    }
    
}
