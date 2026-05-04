<?php

namespace common\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use Yii;
use common\models\ContentTranslation;

class TranslatableBehavior extends Behavior
{
    public $attributes = [];
    public $language;
    private $_translationErrors = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'loadTranslations',
            ActiveRecord::EVENT_AFTER_INSERT => 'saveTranslations',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveTranslations',
        ];
    }

    public function loadTranslations()
    {
        $language = $this->getLanguage();
        // se siamo in italiano, non facciamo nulla
        if ($language === 'it') {
            return;
        }
        foreach ($this->attributes as $attribute) {
            $translation = ContentTranslation::findOne([
                'model' => $this->owner->className(),
                'model_id' => $this->owner->primaryKey,
                'language' => $language,
                'attribute' => $attribute,
            ]);

            if ($translation) {
                // se c'è la traduzione, usa il valore
                // altrimenti imposta a stringa vuota
                $this->owner->$attribute = $translation ? $translation->value : '';
            } else {
                $this->owner->$attribute = ''; // <- importante per lingua non tradotta
            }
        }
    }

    public function saveTranslations()
    {
        $language = $this->getLanguage();
        $this->_translationErrors = []; // reset errori

        foreach ($this->attributes as $attribute) {
            ContentTranslation::deleteAll([
                'model' => $this->owner->className(),
                'model_id' => $this->owner->primaryKey,
                'language' => $language,
                'attribute' => $attribute,
            ]);

            $translation = new ContentTranslation([
                'model' => $this->owner->className(),
                'model_id' => $this->owner->primaryKey,
                'language' => $language,
                'attribute' => $attribute,
                'value' => $this->owner->$attribute,
            ]);
            if (!$translation->save()) {
                $this->_translationErrors[$attribute] = $translation->getErrors();
            }
        }
        return empty($this->_translationErrors); // true se tutto ok
    }

    public function translationErrors()
    {
        return $this->_translationErrors;
    }

    protected function getLanguage(): array|string
    {
        /*$lang = $this->language ?: Yii::$app->language;
        dd($lang);
        return substr($lang, 0, 2);*/
        // legge direttamente la lingua dal parametro GET 'lang'
        if (Yii::$app->controllerNamespace === 'backend\controllers') {
            $lang = Yii::$app->request->get('lang', 'it');
        } else {
            $lang = Yii::$app->language;
        }
        return $lang;
    }
}
