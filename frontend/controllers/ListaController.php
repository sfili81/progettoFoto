<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class ListaController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionInvia()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $body = Yii::$app->request->getRawBody();
        $data = json_decode($body, true);

        if (!$data) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'Dati non validi.'];
        }

        $nome    = trim($data['nome']    ?? '');
        $cognome = trim($data['cognome'] ?? '');
        $email   = trim($data['email']   ?? '');
        $note    = trim($data['note']    ?? '');
        $fotoIds = $data['fotoIds']       ?? [];

        if (!$nome || !$cognome || !$email) {
            Yii::$app->response->statusCode = 422;
            return ['error' => 'Campi obbligatori mancanti.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Yii::$app->response->statusCode = 422;
            return ['error' => 'Email non valida.'];
        }

        // TODO: salva in DB o invia email con $nome, $cognome, $email, $note, $fotoIds

        Yii::info("Lista richiesta da {$nome} {$cognome} <{$email}> - foto: " . implode(',', $fotoIds), 'lista');

        return ['success' => true];
    }
}
