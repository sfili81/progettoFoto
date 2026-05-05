<?php

namespace frontend\controllers;

use Yii;
use common\models\Gara;
use common\models\GaraFoto;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class GaraController extends Controller
{
    public function actionView($id)
    {
        $gara = Gara::findOne(['id' => (int)$id, 'active' => 1]);
        if ($gara === null) {
            throw new NotFoundHttpException('Gara non trovata.');
        }

        $fotos = GaraFoto::findByGara((int)$id)->all();

        $fotosData = [];
        foreach ($fotos as $garaFoto) {
            $img = $garaFoto->image;
            if ($img === null) continue;
            $fotosData[] = [
                'id'      => $garaFoto->id,
                'url'     => Url::to('@web/uploads/images/' . $img->img_name . $img->img_extension),
                'caption' => $img->img_show_name ?: '',
            ];
        }

        return $this->render('view', [
            'gara'      => $gara,
            'fotosJson' => Json::encode($fotosData),
            'listaUrl'  => Url::to(['/lista/index']),
        ]);
    }
}
