<?php

namespace backend\controllers;

use Yii;
use common\models\News;
use common\models\NewsSearch;
use common\controllers\BaseTranslateController;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Image;
use backend\models\UploadFiles;
use yii\web\UploadedFile;
use yii\helpers\HtmlPurifier;
use backend\traits\ImageTrait;
use backend\models\ImageSearch;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends BaseTranslateController
{
    use ImageTrait;

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all News models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {

        $model = $this->findModelBySlug($slug);
        $list_img = array();
        //Prepare array img gallery if exist
        if ($model->images) {
            $temp = json_decode($model->images, true);
            $list_img = $temp['listItem'];
        }

        return $this->render('view', [
            'model' => $model,
            'list_img' => $list_img,
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model        = new News();
        $uploadModel  = new UploadFiles();
        $image  = new Image();

        //get values from both models
        if ($model->load($this->request->post()) && $uploadModel->load($this->request->post()) && $image->load($this->request->post())) {

            $uploadModel->imageFiles =  UploadedFile::getInstances($uploadModel, 'imageFiles');

            // Upload immagine preview principale
            if ($image->uploadAttributeImage('imageFile', 'preview')) {
                $model->id_image_preview  = $image->id;
            }

            //Upload images
            if (!empty($uploadModel->imageFiles)) {
                $uploadImages = $uploadModel->uploadImages('news');
                $model->images = json_encode($uploadImages);
            }

            $model->meta_description = HtmlPurifier::process($model->meta_description);
            $model->meta_title    = HtmlPurifier::process($model->meta_title);

            //se data è vuoto metto la data di oggi
            if (empty($model->date)) {
                $model->date = date("Y-m-d");
            }

            if ($model->save()) {
                //controllo se esiste un'imamgine di anteprima
                if (is_null($model->id_image_preview) && $model->is_published) {
                    $model->is_published = 0;
                    $model->update();
                    Yii::$app->session->setFlash('warning', "La news &quot;{$model->title}&quot; è stata correttamente salvata, ma non pubblicata in quanto manca l'immagine di anteprima");
                } else {
                    Yii::$app->session->setFlash('success', "La news &quot;{$model->title}&quot; è stata correttamente salvata");
                }

                //Yii::$app->session->setFlash('success', "La news &quot;{$model->title}&quot; è stata correttamente salvata");
                switch ($this->request->post('subaction')) {
                    case 'saveMod':
                        return $this->redirect(['update', 'id' => $model->id]);
                    case 'saveReturn':
                        return $this->redirect(['index']);
                    default:
                        return $this->redirect(['update', 'id' => $model->id]);
                }
            } else {
                var_dump($model->getErrors());
                exit;
            }
        }

        return $this->render('create', [
            'model'                => $model,
            'uploadModel'          => $uploadModel,
            'image'                => $image,
            'listImg'              => "",
            'initialPreviewConfig' => "",
            'previewImg'           => "",
            'listPreviewImg'       => "",
            'initialImgPreviewConfig' => "",
        ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $uploadModel = new UploadFiles();
        $image  = new Image();
        //$uploadModel->scenario='news-update';

        /** GESTIONE LINGUE */
        $this->applyLanguageToModel($model); // imposta la lingua corretta sul comportamento
        /************** FINE GESTIONE LINGUA */

        //save acutal images field
        $oldImages = $model->images;
        $oldPreview = $model->id_image_preview;

        $initialPreviewConfig = array();
        $list = array();

        if ($model->images) {
            $listImg = json_decode($model->images, true);
            $listImg['listItem'] = array_values($listImg['listItem']);
            // set the list of image 
            foreach ($listImg['listItem'] as $key => $img) {
                $list[] =  Yii::getAlias('@frontendUploads') . "/" . $img['name'] . '.' . $img['extension'];
                $initialPreviewConfig[] = (['key' => $key, 'caption' => $img['name']]);
            }
        }

        $initialImgPreviewConfig = array();
        $listPreviewImg = "";
        if ($model->id_image_preview) {
            $listPreviewImg = Yii::getAlias('@frontendUploads') . "/" . $model->imagePreview->img_name . $model->imagePreview->img_extension;
            $initialImgPreviewConfig[] = (['caption' => $model->imagePreview->img_name, 'extra' => ['singleImg' => true]]);
        }

        //Ajax call for delete file
        if (Yii::$app->request->isAjax) {
            $requestAjax = $this->request->post();
            if (array_key_exists("singleImg", $requestAjax)) {
                $this->deleteSingleImageFromAjax($model, $model->imagePreview->img_name . $model->imagePreview->img_extension, property: 'id_image_preview');
            }
            if ($model->images) {
                $model->load($this->request->post());
                //using traits
                $this->deleteImageFromAjax($model, $requestAjax, $listImg);
                $oldImages = $model->images;
            }
            //add remove file from server?
            return json_encode("From ajax");
        }

        /* Update */
        if ($model->load($this->request->post()) && $uploadModel->load($this->request->post()) && $image->load($this->request->post())) {

            $uploadModel->imageFiles =  UploadedFile::getInstances($uploadModel, 'imageFiles');

            //Upload multiple images
            if (!empty($uploadModel->imageFiles)) {
                //ho caricato immagini nuove e faccio merge con quelle già presenti
                $uploadImages = $uploadModel->uploadImages();
                $model->images = json_encode($uploadImages);
                $temp_upl = json_decode($model->images, true);
                $temp_img = json_decode($oldImages, true);
                //Se esistono immagini gia salvate allora faccio il merge con quelle da inserire
                if (!is_null($temp_img)) {
                    $temp_result =  array_merge($temp_img['listItem'], $temp_upl['listItem']);
                    $temp_img['listItem'] = $temp_result;
                    $model->images = json_encode($temp_img);
                }

                $uploadModel->imageFiles = "";
            } else {
                //Se non carico immagini nuove mantengo quelle precedenti
                $model->images = $oldImages;
            }


            // Upload immagine preview principale
            if ($image->uploadAttributeImage('imageFile', 'preview')) {
                $model->id_image_preview  = $image->id;
            } else {
                //anteprima non è modificaa uso quella vecchia
                $model->id_image_preview = $oldPreview;
            }

            //Upload image preview             
            if ($image->load($this->request->post())) {
                // Upload immagine principale (update)
                if ($image->uploadAttributeImage('imageFile', 'preview')) {
                    $model->id_image_preview  = $image->id;
                }

                // Upload immagine mobile (update) -> SE SERVE
                /*if ($image->uploadAttributeImage('imageMobile', 'mob')) {
                    $model->id_image_mob = $image->id;
                }*/
            }

            $model->meta_description = trim(HtmlPurifier::process($model->meta_description));
            $model->meta_title    = trim(HtmlPurifier::process($model->meta_title));

            //if(is_null($model->id_image_preview) && $model->is_published){
            //controllo se esiste un'imamgine di anteprima
            if (is_null($model->id_image_preview) && $model->is_published) {
                $model->is_published = 0;
                //$model->update();
                Yii::$app->session->setFlash('warning', "La news &quot;{$model->title}&quot; è stata correttamente salvata, ma non pubblicata in quanto manca l'immagine di anteprima");
            } else {
                Yii::$app->session->setFlash('success', "La news {$model->title} è stata correttamente modificata");
            }

            //salvo con traduzioni
            if ($this->saveModelWithTranslations($model)) {
                Yii::$app->session->setFlash('success', "La news {$model->title} è stata correttamente modificata");
            } else {
                $errors = $model->getBehavior('translatable')->translationErrors();
                Yii::$app->session->setFlash('error', "Errore nella modifica della news" . json_encode($errors));
            }
            $lang = Yii::$app->request->get('lang', 'it');
            switch ($this->request->post('subaction')) {
                case 'saveMod':
                    return $this->redirect(['update', 'id' => $model->id, 'lang' => $lang]);
                case 'saveReturn':
                    return $this->redirect(['index']);
                default:
                    return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model'                => $model,
            'uploadModel'          => $uploadModel,
            'image'                => $image,
            'listImg'              => $list,
            'initialPreviewConfig' => $initialPreviewConfig,
            'listPreviewImg'       => $listPreviewImg,
            'initialImgPreviewConfig' => $initialImgPreviewConfig,
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
    }

    /**
     * Finds the News model based on its slug value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $slug ID
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBySlug($slug)
    {
        if (($model = News::findOne(['slug' => $slug])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException();
        }
    }

    /* Sezione TEST dedicata alla selezione dell'immagine */

    /**
     * Show a test view for select images
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionSelectImage()
    {
        $model  = new News();
        $searchImage = new ImageSearch();
        $imageModel = new Image();
        $imageProvider = $searchImage->search($this->request->queryParams);
        //get values from both models
        if ($model->load($this->request->post())) {

            //DEBUG
            dd($model->attributes);

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "La news &quot;{$model->title}&quot; è stata correttamente salvata");
                switch ($this->request->post('subaction')) {
                    case 'saveMod':
                        return $this->redirect(['update', 'id' => $model->id]);
                    case 'saveReturn':
                        return $this->redirect(['index']);
                    default:
                        return $this->redirect(['update', 'id' => $model->id]);
                }
            } else {
                var_dump($model->getErrors());
                exit;
            }
        }

        return $this->render('selectImage', [
            'model'                => $model,
            'imageProvider' => $imageProvider,
            'searchImage' => $searchImage,
            'image' => $imageModel,
        ]);
    }
}
