<?php

namespace backend\controllers;

use Yii;
use common\models\Gara;
use common\models\GaraFoto;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\FileHelper;

class GaraController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'reset-all' => ['POST'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Elimina l'intero albero gare, tutte le foto associate e le cartelle fisiche.
     */
    public function actionResetAll()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $imagesRoot = Yii::getAlias('@frontend') . '/web/uploads/images';

        // 1. Raccoglie le cartelle top-level PRIMA di eliminare i nodi dell'albero
        $topFolders = [];
        foreach (Gara::find()->all() as $node) {
            $path    = $node->getFolderPath();
            $relPath = ltrim(str_replace($imagesRoot, '', $path), '/\\');
            $parts   = explode('/', $relPath);
            if (!empty($parts[0])) {
                $topFolders[$parts[0]] = $imagesRoot . '/' . $parts[0];
            }
        }

        // 2. Elimina file fisici + record image per ogni foto gara
        foreach (GaraFoto::find()->with('image')->all() as $gf) {
            $img = $gf->image;
            if ($img) {
                $filePath = $imagesRoot . '/' . $img->img_name . $img->img_extension;
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
                $img->delete();
            }
        }

        // 3. Svuota pivot e albero (gara_foto prima per rispettare la FK)
        GaraFoto::deleteAll();
        Gara::deleteAll();

        // 4. Reset AUTO_INCREMENT
        $db = Yii::$app->db;
        $db->createCommand('ALTER TABLE {{%gara}} AUTO_INCREMENT = 1')->execute();
        $db->createCommand('ALTER TABLE {{%gara_foto}} AUTO_INCREMENT = 1')->execute();
        $db->createCommand('ALTER TABLE {{%image}} AUTO_INCREMENT = 1')->execute();

        // 4. Rimuove le cartelle fisiche rimaste
        foreach ($topFolders as $folder) {
            if (is_dir($folder)) {
                FileHelper::removeDirectory($folder);
            }
        }

        return ['success' => true];
    }
}
