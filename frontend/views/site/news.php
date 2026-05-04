<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = Yii::$app->name; /* $page->pages_meta_title ?: Yii::$app->name; */

echo Yii::$app->language;
//dd($model->getAttributes());//

echo $model->title;//
