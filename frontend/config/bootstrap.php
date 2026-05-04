<?php

use yii\base\Event;
use yii\web\View;
use common\models\Company;

Event::on(View::className(), View::EVENT_BEFORE_RENDER, function() {
    $company = Company::findOne(['id' => 1]);
    Yii::$app->view->params['company'] = $company;
});