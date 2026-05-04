<?php

namespace backend\controllers;

use backend\helpers\Helpers;
use Yii;
use yii\web\Response;
use common\models\Pages;
use common\models\PagesSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * PagesController implements the CRUD actions for Pages model.
 */
class PagesController extends Controller
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
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['create', 'delete', 'create-block'],// List of action IDs that this filter should apply to.
                    'rules' => [
                        [
                            'actions' => ['delete','create', 'create-block' ], // Define specific actions
                            'allow' => true, // Has access
                            'roles' => ['admin'],// only admin
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Pages models.
     *
     * @return string|array
     */
    public function actionIndex()
    {
        $query = Pages::find()->indexBy('id'); // where `id` is your primary key
        $searchModel = new PagesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        //TODO usare un'action dedicata per queste operazioni non usare la stessa del render 
        
        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            $model = $this->findModel($_POST['editableKey']);
            // use Yii's response format to encode output as JSON
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            // store old value of the attribute
            $oldValue = $model->pages_visibility;
            $visibility = $_POST['Pages'][$_POST['editableIndex']]['pages_visibility'];
            // read your posted model attributes
            $model->pages_visibility = $visibility;

            if ($model->save()) {   
                // return JSON encoded output in the below format on success with an empty `message`
                return ['output' => $model->pages_visibility, 'message' => ''];
            }else{
                // alternatively you can return a validation error (by entering an error message in `message` key)
                return ['output' => $oldValue, 'message' => 'Incorrect Value! Please reenter.'];
            }
        }
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Function to order PAGES with Sortable widget
     * key: the value of the item's primary key;
     * pos: the zero-indexed new position of the item.
     */
      public function actionOrder( )   {
        $post = Yii::$app->request->post();
        if (isset( $post['key'], $post['pos'] )) {
           $this->findModel( $post['key'] )->order( $post['pos'] );
        }
    }

    /**
     * Displays a single Pages model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = $this->findModel($id); 
        $blockProvider = new ActiveDataProvider([
            'query' => $model->getBlocks()->orderBy('ord'),
            'sort' => false,
	        'pagination' => false,
        ]);

        if (!Yii::$app->user->can('admin')) {
            $message = Yii::t('backend', "You do not have permission to perform this action. Please contact the administrator");
            throw new ForbiddenHttpException($message);
        }

        return $this->render('view', [
            'model' => $model,            
            'blocks' => $blockProvider, 
        ]);
    }

    /**
     * Creates a new Pages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Pages();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('success', "La news &quot;{$model->pages_name}&quot; è stata correttamente salvata");

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateBlock(){
        //return $this->redirect(['block/create', 'type' => $this->request->post('blockType'), 'idPage' => $this->request->post('idPage')]);
        return $this->redirect(['block/create', 'type' => $this->request->post('blockType'), 
                                                    'idPage' => $this->request->post('idPages'),
                                                    'junctionTable' => 'pagesxblock',
                                                    'field' => 'id_pages',
                                                    'junctionModel' => 'Pages',                                                
                                ]);
    }

    /**
     * Updates an existing Pages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

             Yii::$app->session->setFlash('success', "La pagina &quot;{$model->pages_name}&quot; è stata correttamente salvata");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pages model.
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
     * Finds the Pages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pages::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionDeleteMultiple()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $ids = Yii::$app->request->post('ids', []);

        $result = Helpers::deleteMultiple(Pages::class, $ids);

        if ($result['success']) {
            Yii::$app->session->setFlash('success', $result['message']);
        } else {
            Yii::$app->session->setFlash('error', $result['message']);
        }

        return $result;
    }

}
