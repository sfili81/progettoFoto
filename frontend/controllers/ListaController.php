<?php

namespace frontend\controllers;

use Yii;
use common\models\Cart;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class ListaController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'inviaUrl' => Url::to(['/lista/invia']),
        ]);
    }

    public function actionInvia()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $req     = Yii::$app->request;
        $code    = trim($req->post('code',  ''));
        $email   = trim($req->post('email', ''));
        $note    = trim($req->post('note',  ''));
        $fotoIds = Json::decode($req->post('fotoIds', '[]') ?: '[]');

        if (!$code) {
            Yii::$app->response->statusCode = 422;
            return ['error' => 'Il codice è obbligatorio.'];
        }

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Yii::$app->response->statusCode = 422;
            return ['error' => 'Email non valida.'];
        }

        if (empty($fotoIds)) {
            Yii::$app->response->statusCode = 422;
            return ['error' => 'Nessuna foto selezionata.'];
        }

        $cart               = new Cart();
        $cart->state        = 0;
        $cart->email        = $email;
        $cart->note         = $note ?: null;
        $cart->code         = $code;
        $cart->list_images  = Json::encode(array_map('intval', $fotoIds));
        $cart->created_at   = time();
        $cart->updated_at   = time();

        if (!$cart->save()) {
            Yii::$app->response->statusCode = 500;
            return ['error' => 'Errore nel salvataggio. Riprova.'];
        }

        return ['success' => true, 'code' => $cart->code];
    }
}
