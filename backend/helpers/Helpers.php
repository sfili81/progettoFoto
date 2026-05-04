<?php

namespace backend\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\ActiveRecord;

class Helpers
{

    /**
     * Function for Setting View Button on GridView 
     * 
     * */
    public static function actionButton(object $model, string $type, ?string $context = null, ?bool $is_slug = false)
    {

        $label = Yii::$app->params['gridviewAction'][$type]['string'];
        $class = Yii::$app->params['gridviewAction'][$type]['class'];
        $data  = Yii::$app->params['gridviewAction'][$type]['data'];

        $context ? $path = $context . '/' . $type : $path = $type;

        if ($is_slug) {
            return Html::a($label, [$path, 'slug' => $model->slug], ['class' => "btn {$class} mb-md-0 mb-2", 'data' => $data, 'data-pjax' => '0']);
        } else {
            return Html::a($label, [$path, 'id' => $model->id], ['class' => "btn {$class} mb-md-0 mb-2", 'data' => $data, 'data-pjax' => '0']);
        }
    }


    /**
     * Function for Setting Date from timestamp on GridView 
     * 
     * */
    public static function setDateFromTimestamp(?int $timestamp)
    {
        is_null($timestamp) ? $date = "non disponibile" : $date = date('d-m-Y', $timestamp);
        return $date;
    }

    /**
     * Function for Formatting Date from Y-m-d to d-m-Y
     * 
     * */
    public static function changeDateFormat($dateToChange)
    {
        empty($dateToChange) ? $date = "non disponibile" : $date = date('d-m-Y', strtotime($dateToChange));
        return $date;
    }

    /**
     *  Function for setting state of a visibility into backend
     *
     **/
    public static function showVisibility(bool $state)
    {
        $label = "si";
        $css = "";
        if ($state) {
            $label = Yii::t('backend', 'Yes');
            $css = 'label-success';
        } else {
            $label = Yii::t('backend', 'No');
            $css = 'label-error';
        }
        return "<span class='label {$css}'>{$label}</span> ";
    }

    public static function renderLanguageSwitcher()
    {
        $languages = Yii::$app->params['languages']; //lista lingue in cui posso tradurre prese da common/config/params
        // Prende la lingua dall'URL ma non cambia Yii::$app->language
        $currentLang = Yii::$app->request->get('lang', 'it');
        $action = Yii::$app->controller->action->id ?? null;
        echo  'lingua BE: ' . Yii::$app->language . " + Lingua per tradurre campi " . $currentLang;
        if ($action !== 'update') {
            return ''; // non mostra niente se non siamo in update
        }

        // Genera l’html del cambio lingua
        $html = '<div class="mb-4">';
        foreach ($languages as $code => $lang) {
            $url = Url::current(['lang' => $code]);
            $isActive = $code === $currentLang ? '' : 'filter:grayscale(1);';
            $html .= '<a href="' . $url . '" class="mx-1" title="' . $lang['name'] . '" style="font-size: 1.8rem; text-decoration: none;' . $isActive . '">'
                . Html::img(Yii::getAlias('@backendImg') . "/flags/" . $code . ".svg", ['style' => 'width:20px;']) .
                '</a>';
        }
        $html .= '</div>';
        $html .= '<div class="alert alert-info"><strong>Lingua attiva:</strong> ' . strtoupper($currentLang) . '</div>';

        return $html;
    }

    /**
     * Elimina più record in base a un array di ID.
     *
     * @param string|ActiveRecord $modelClass Classe modello o istanza
     * @param array $ids Array di ID da eliminare
     * @param string $primaryKey Nome campo PK, default 'id'
     * @return array ['success' => bool, 'message' => string, 'deletedCount' => int]
     */
    public static function deleteMultiple($modelClass, array $ids, $primaryKey = 'id')
    {
        if (empty($ids)) {
            return [
                'success' => false,
                'message' => 'Nessun ID fornito.',
                'deletedCount' => 0,
            ];
        }

        // Sanitizza gli ID: considera solo numeri interi positivi
        $ids = array_filter($ids, function ($id) {
            return filter_var($id, FILTER_VALIDATE_INT) !== false && $id > 0;
        });

        if (empty($ids)) {
            return [
                'success' => false,
                'message' => 'ID non validi.',
                'deletedCount' => 0,
            ];
        }

        try {
            // Verifica se la classe modello esiste
            if (is_string($modelClass)) {
                if (!class_exists($modelClass)) {
                    return [
                        'success' => false,
                        'message' => "Classe modello '$modelClass' non trovata.",
                        'deletedCount' => 0,
                    ];
                }
            } elseif (!$modelClass instanceof ActiveRecord) {
                return [
                    'success' => false,
                    'message' => "Parametro modello non valido.",
                    'deletedCount' => 0,
                ];
            }

            // Conta record esistenti (opzionale)
            $countToDelete = $modelClass::find()->where([$primaryKey => $ids])->count();

            if ($countToDelete === 0) {
                return [
                    'success' => false,
                    'message' => 'Nessun record trovato da eliminare.',
                    'deletedCount' => 0,
                ];
            }

            // Elimina i record
            $deletedCount = $modelClass::deleteAll([$primaryKey => $ids]);

            return [
                'success' => true,
                'message' => "Eliminati $deletedCount record.",
                'deletedCount' => $deletedCount,
            ];
        } catch (\Exception $ex) {
            Yii::error("Errore eliminazione multipla: " . $ex->getMessage(), __METHOD__);
            return [
                'success' => false,
                'message' => 'Errore durante l\'eliminazione: ' . $ex->getMessage(),
                'deletedCount' => 0,
            ];
        }
    }
}
