<?php

namespace backend\controllers;

use Yii;
use common\models\Block;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadFiles;
use backend\traits\ImageTrait;
use yii\web\UploadedFile;
use backend\models\Image;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;

/**
 * BlockController implements the CRUD actions for Block model.
 */
class BlockController extends Controller
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
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ],
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['create', 'delete',], //only this actions
                    'rules' => [
                        [
                            'actions' => ['delete', 'create',], // Define specific actions
                            'allow' => true, // Has access
                            'roles' => ['admin'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Block models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Block::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Function to order BLOCK with Sortable widget
     * key: the value of the item's primary key;
     * pos: the zero-indexed new position of the item.
     */
    public function actionOrder()
    {
        //dd('Block controller');
        $post = Yii::$app->request->post();
        if (isset($post['key'], $post['pos'])) {
            $this->findModel($post['key'])->order($post['pos']);
        }
    }

    /**
     * Displays a single Block model.
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
     * Creates a new Block model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $type Indica la chiave dell' array blockName in confing/params serve ad identificare quale vista renderizzare per il blocco
     * @param string $junctionTable Indica qule è la tabella di join
     * @param string $junctionModel Nome del modello con cui si esegue la join
     * @param string $blockPageType Indica il tipo di chiave per recuperare il nome della vista del blocco nel caso in cui sia diverso da quello di default 'blockname' presente in params
     * @param string $field Nome del campo per la tabella di join (es. id_pages)
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate(int $type, int $idPage, ?string $junctionTable = NULL, ?string $field = NULL, ?string $junctionModel = NULL, ?string $blockPageType = NULL)
    {
        $model = new Block();
        $uploadModel  = new UploadFiles();
        $image  = new Image();
        //Gestione di una eventuale immagine mobile
        $imageMob = new Image();

        is_null($blockPageType) ?  $blockParams = Yii::$app->params['blockName'] :  $blockParams = Yii::$app->params[$blockPageType];

        //SE $junctionModel non è null recupero i nomi dei tpl predefiniti per un dropdown
        $blockList = "";
        if (!is_null($junctionModel) &&  array_key_exists($junctionModel, Yii::$app->params['block'])) {
            $blockList = Yii::$app->params['block'][$junctionModel];
        }

        $viewName = "formView/" . $blockParams[$type]['view'];

        //Block name va aggiunto nel modello al momento di salvare
        //$block_name = $blockParams[$type]['name'];
        ///$idPage è l'id della pagina a cui è associato il blocco è da inserire nel modello dopo aver caricato i valori dal form

        //get values from both models
        if ($model->load($this->request->post())) {

            $model->block_type = $type;

            if ($uploadModel->load($this->request->post())) {
                //Upload Slider
                // Get instance of images for gallery and save it to the model
                $uploadModel->imageFiles =  UploadedFile::getInstances($uploadModel, 'imageFiles');
                //Upload images for gallery
                if (!empty($uploadModel->imageFiles)) {
                    $uploadImages = $uploadModel->uploadImages('news');
                    $model->images = json_encode($uploadImages);
                }

                //Upload PDF
                $uploadModel->pdfFile = UploadedFile::getInstance($uploadModel, 'pdfFile');
                if (!empty($uploadModel->pdfFile)) {
                    $model->pdf =  $uploadModel->uploadPdf();
                    $uploadModel->pdfFile = ""; //reset
                }
            } //end image model post

            //Get Single image update
            if ($image->load($this->request->post())) {
                // Upload immagine principale
                if ($image->uploadAttributeImage('imageFile', 'preview')) {
                    $model->id_image = $image->id;
                }

                // Upload immagine mobile
                if ($image->uploadAttributeImage('imageMobile', 'mob')) {
                    $model->id_image_mob = $image->id;
                }
            }

            //Save Model with transaction
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save();
                $transaction->commit();
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }

            Yii::$app->session->setFlash('success', "Blocco correttamente salvato");

            //return $this->redirect(['pages/view', 'id' =>$idPage]);
            $id = $model->id;
            $idJunction = $idPage;
            $this->setJunctionBlock($id, $idJunction, $junctionTable, $field);
            return $this->redirect([strtolower($junctionModel) . '/view', 'id' => $idPage]);
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'uploadModel' => $uploadModel,
            'image' => $image,
            'viewName' => $viewName,
            'listPreviewImg'       => '',
            'initialImgPreviewConfig' => '',
            'listPreviewMobileImg' => '',
            'initialImgMobilePreviewConfig' => '',
            'listImg' => "",
            'initialPreviewConfig' => "",
            'pdfList' => '',
            'initialPreviewConfigPdf' => '',
            'blockList' => $blockList,
        ]);
    }

    /**
     * Updates an existing Block model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param string $blockPageType Indica il tipo di chiave per recuperare il nome della vista del blocco nel caso in cui sia diverso da quello di default 'blockname' presente in params
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate($id, $redirect = NULL, ?string $blockPageType = NULL)
    {
        $model = $this->findModel($id);
        $uploadModel  = new UploadFiles();
        $image  = new Image();
        //Gestione di una eventuale immagine mobile
        $imageMob = new Image();

        //$blockParams = Yii::$app->params['blockName'];
        is_null($blockPageType) ?  $blockParams = Yii::$app->params['blockName'] :  $blockParams = Yii::$app->params[$blockPageType];

        $viewName = "formView/" . $blockParams[$model->block_type]['view'];

        //Prepare view for showing preview image if Exist
        $initialImgPreviewConfig = array();
        $listPreviewImg = "";
        if (!is_null($model->id_image)) {
            $listPreviewImg = Yii::getAlias('@frontendUploads') . "/" . $model->image->img_name . $model->image->img_extension;
            $initialImgPreviewConfig[] = (['caption' => $model->image->img_name, 'extra' => ['singleImg' => true]]);
        }

        //Prepare view for showing preview mobile image if Exist
        $initialImgMobilePreviewConfig = array();
        $listPreviewMobileImg = "";
        if (!is_null($model->id_image_mob)) {
            $listPreviewMobileImg = Yii::getAlias('@frontendUploads') . "/" . $model->imageMob->img_name . $model->imageMob->img_extension;
            $initialImgMobilePreviewConfig[] = (['caption' => $model->imageMob->img_name, 'extra' => ['singleImgMob' => true]]);
        }

        //Prepare for showing Gallery Image
        //save actual images field
        $initialPreviewConfig = '';
        $listImg = '';
        $list = '';
        $oldImages = $model->images;
        if (!empty($model->images) || !is_null($model->images)) {
            $listImg = json_decode($model->images, true);
            //using traits
            $config = $this->setPreviewMultipleImage($model->images);
            $initialPreviewConfig = $config['initialPreviewConfig'];
            $list = $config['list'];
        }

        //Ajax call for delete file
        if (Yii::$app->request->isAjax) {
            $requestAjax = $this->request->post();
            if (array_key_exists("singleImg", $requestAjax)) {
                $this->deleteSingleImageFromAjax($model, $model->image->img_name . '' . $model->image->img_extension);
            }
            if (array_key_exists("singleImgMob", $requestAjax)) {
                $this->deleteSingleImageFromAjax($model, $model->imageMob->img_name . '' . $model->imageMob->img_extension, 'mobile');
            }
            if ($model->images && !isset($requestAjax['oldIndex'], $requestAjax['newIndex'])) {
                $model->load($this->request->post());
                //using traits
                $this->deleteImageFromAjax($model, $requestAjax, $listImg);
                $oldImages = $model->images;
            }
            if (isset($requestAjax['oldIndex'], $requestAjax['newIndex'])) {
                //Reorder Images
                $this->reorderImages($model, $requestAjax['oldIndex'], $requestAjax['newIndex'], $listImg);
                //return json_encode(['success' => true]);
            }

            //add remove file from server?
            return json_encode("From ajax");
        }

        //Prepare for showing pdf if existPdf
        $oldPdf =  $model->pdf;
        $pdfList = array();
        $pdfList[] =  $model->pdf;
        $initialPreviewConfigPdf = $model->pdf;

        if ($model->load($this->request->post())) {

            //Get image gallery and pdf uploaded
            if ($uploadModel->load($this->request->post())) {
                //Upload Multiple images.
                //Get instance of multiple image    
                $uploadModel->imageFiles =  UploadedFile::getInstances($uploadModel, 'imageFiles');
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
                    $uploadModel->imageFiles = ""; //reset
                } else {
                    //Se non carico immagini nuove mantengo quelle precedenti
                    $model->images = $oldImages;
                }

                //Upload PDF
                $uploadModel->pdfFile = UploadedFile::getInstance($uploadModel, 'pdfFile');
                //getInstanceByName
                if (!empty($uploadModel->pdfFile)) {
                    $model->pdf =  $uploadModel->uploadPdf();
                } else {
                    $model->pdf = $oldPdf;
                }
            }

            if ($image->load($this->request->post())) {
                // Upload immagine principale (update)
                if ($image->uploadAttributeImage('imageFile', 'preview')) {
                    $model->id_image = $image->id;
                }

                // Upload immagine mobile (update)
                if ($image->uploadAttributeImage('imageMobile', 'mob')) {
                    $model->id_image_mob = $image->id;
                }
                // Se vuoi gestire anche immagini multiple:
                // $savedIds = $image->uploadMultipleImages('gallery');
                // qui puoi aggiornare il modello correlato con gli ID delle immagini
            }
            //Save Model with transaction
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save();
                $transaction->commit();
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }

            Yii::$app->session->setFlash('success', "Blocco correttamente modificato");

            if (!is_null($redirect)) {
                //return $this->redirect([$redirect.'/index']);   
                switch ($this->request->post('subaction')) {
                    case 'saveMod':
                        return $this->redirect(Yii::$app->request->referrer);
                    case 'saveReturn':
                        return $this->redirect($redirect);
                    default:
                        return $this->redirect(Yii::$app->request->referrer);
                }
            } else {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'uploadModel' => $uploadModel,
            'image' => $image,
            'viewName' => $viewName,
            'listPreviewImg' => $listPreviewImg,
            'initialImgPreviewConfig' => $initialImgPreviewConfig,
            'listPreviewMobileImg' => $listPreviewMobileImg,
            'initialImgMobilePreviewConfig' => $initialImgMobilePreviewConfig,
            'listImg' => $list,
            'initialPreviewConfig' => $initialPreviewConfig,
            'pdfList' => $pdfList,
            'initialPreviewConfigPdf' => $initialPreviewConfigPdf,
            'blockList' => '', //$blockList,
        ]);
    }

    protected function setJunctionBlock($id, $idJunction, $junctionTable, $field = "", $toDeleteJunction = ""): void
    {
        $t = Yii::$app->db->createCommand()
            ->insert($junctionTable, [
                'id_block' => $id,
                $field => $idJunction,
            ])->execute();
    }

    /**
     * Deletes an existing Block model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, string $redirect = NULL, string $junctionTable = NULL)
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', "Blocco eliminato");

        if (!is_null($junctionTable)) {
            $x = Yii::$app->db->createCommand("
                    DELETE FROM {$junctionTable} 
                    WHERE id_block = '$id' 
                ")->execute();
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
    /**
     * Finds the Block model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Block the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Block::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested Block does not exist.');
    }
}
