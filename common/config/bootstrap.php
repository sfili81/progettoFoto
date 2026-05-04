<?php
use yii\web\Request;

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');


$baseUrl = str_replace('/web', '', (new Request)->getBaseUrl());

Yii::setAlias('@imagesUrl',  '/frontend/web/uploads/images/');
Yii::setAlias('@imagesPath',  '/frontend/web/uploads/images/');
