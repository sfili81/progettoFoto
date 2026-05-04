<?php

    //This set a global template for DetailView  with DI
    \Yii::$container->set('yii\widgets\DetailView', ['template' => '<tr><td><h4>{label}</h4>{value}</td></tr>']); 
