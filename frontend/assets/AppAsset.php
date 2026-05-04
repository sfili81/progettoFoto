<?php

namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
    public $depends = [
        //'yii\web\YiiAsset',
       // 'yii\bootstrap5\BootstrapAsset',
    ];

    public function init()
    {
        parent::init();

        $manifestPath = Yii::getAlias('@webroot/dist/manifest.json');

        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);

            if (isset($manifest['main.css'])) {
                $this->css[] = $manifest['main.css'];
            }

            if (isset($manifest['main.js'])) {
                $this->js[] = $manifest['main.js'];
            }
        } else {
            // fallback (sviluppo senza manifest)
            $this->css[] = 'dist/bundle.css';
            $this->js[] = 'dist/app.js';
        }
    }

    /*
    public $css = [
        'dist/bundle.css',
    ];
    public $js = [
        'dist/app.js'
    ];
    public $depends = [
        //'yii\web\YiiAsset',
       // 'yii\bootstrap5\BootstrapAsset',
    ];*/
}
