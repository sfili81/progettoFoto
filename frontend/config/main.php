<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'PUdKTylbzBNusPeMnnFv',
            'baseUrl' => '',
        ],
        //removing bootstrap5 assets it manteins jQuery if some Yii2 plugin requires
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [],
                    'depends' => [],
                ],
                'yii\web\YiiAsset' => [
                    'js' => [],
                    'depends' => [],
                ],
                'yii\widgets\ActiveFormAsset' => [
                    'js' => [],
                    'depends' => [],
                ],
                'yii\bootstrap5\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap5\BootstrapAsset' => [
                    'css' => [],
                ],

            ],
        ],
        // If you want to use Twig activate this
        //'view' => [
        //    'class' => 'yii\web\View',
        //    'renderers' => [
        //        'twig' => [
        //            'class' => 'yii\twig\ViewRenderer',
        //            'cachePath' => '@runtime/Twig/cache',
        //            // Array of twig options:
        //            'options' => [
        //                'auto_reload' => true,
        //            ],
        //            'globals' => ['html' => '\yii\helpers\Html'],
        //            'uses' => ['yii\bootstrap'],
        //        ],
        // ...
        //    ],
        //],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'baseUrl' => '',
            'enablePrettyUrl' => true, // Cancel passing route in get 'r' paramater
            'showScriptName' => false, // Remove index.php from url
            'suffix' => '', // Add suffix to all routes (globally)
            // codemix/yii2-localeurls CONFIGURATION
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => array_keys($params['languages']), // estrai le chiavi dal params,//['en', 'fr', 'it', ],
            'enableLanguageDetection' => true, // imposta lingua se non presente nella URL (solo al primo accesso)
            'enableDefaultLanguageUrlCode' => false, // se true, mostrerà sempre /it/, anche se è default
            // Compare requested urls to routes
            'rules' => [
                '' => 'site/index',
                '<controller>/' => '<controller>/index',
                '<controller>/<action>' => '<controller>/<action>',
                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
