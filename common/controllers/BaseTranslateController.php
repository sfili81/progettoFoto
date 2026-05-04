<?php

namespace common\controllers;

use Yii;
use yii\web\Controller;

class BaseTranslateController extends Controller
{
    protected $lang;

    public function beforeAction($action)
    {
        if (Yii::$app->controllerNamespace === 'backend\controllers') {
            // Backend: prendi la lingua da GET, default a 'it'
            $this->lang = Yii::$app->request->get('lang', 'it');
            //echo $this->lang;
            //Yii::$app->language = $this->lang;
        } else {
            // Frontend: prendi la lingua già settata da localeurls
            $this->lang = Yii::$app->language;
        }
        return parent::beforeAction($action);
    }

    protected function applyLanguageToModel($model)
    {
        if ($model->hasMethod('getBehavior')) {
            $behavior = $model->getBehavior('translatable');

            if ($behavior !== null) {
                $behavior->language = $this->lang;
            }
        }
        //dd($behavior->language);
    }

    protected function saveModelWithTranslations($model)
    {
        $this->applyLanguageToModel($model);

        if ($this->lang === 'it') {
            return $model->save();
        } else {
            $behavior = $model->getBehavior('translatable');
            return $behavior->saveTranslations(); // salva solo traduzioni
        }
    }
}
