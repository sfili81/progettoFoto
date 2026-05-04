<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AdminkitAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/Adminkit';
    public $css = [
        /*[
            'href' => 'favicon/favicon.png',
            'rel' => 'icon',
            'sizes' => '32x32',
        ],*/
        'css/app.css',
        'css/custom.css',
        'css/tree.css',
        /*'https://use.fontawesome.com/releases/v7.1.0/css/all.css',*/
        'https://kit.fontawesome.com/ab55e89af5.css',
    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/chart.js',
        'js/app.js',
        'js/custom.js',
        'js/filter-tree.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
}
