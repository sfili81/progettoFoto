<?php

namespace backend\controllers;

use Yii;
use common\models\Company;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
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
     * Displays a single Company model.
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
    * Create a Company model.
    * @return \yii\web\Response
    */
    public function actionCreate(): string|Response
    {
        $model = new Company();
        
        if ($model->load($this->request->post())  ) {
            if($model->save()){
                Yii::$app->session->setFlash('success', Yii::t('backend', 'The company has been successfully created'));  
                return $this->redirect(['update']);
            }else{
                Yii::$app->session->setFlash('error', Yii::t('backend', 'An error occurred while creating the company' ));    
            }             
        }

       return $this->render('create', [
            'model' => $model,
        ]);
    }

    
    /**
     * Updates an existing Company model.
     * If the model isn't found yu can create it 
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id = 1): Response|string
    {
        $model = $this->findModel($id);
        if(is_null($model)){
            return $this->redirect(['create']);
        }

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
        ]);
    }

    /**
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Company|null
    {
        if (($model = Company::findOne(['id' => $id])) !== null) {
            return $model;
        }

        return null;

        //throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
    }
}
