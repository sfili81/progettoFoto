<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'homeUrl' => $_ENV['BACKEND_HOMEURL'],
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'],
            'generators' => [ //here
                'crud' => [ // generator name
                    'class' => 'yii\gii\generators\crud\Generator', // generator class
                    'templates' => [ //setting for out templates
                        'IOcrud' => '@backend/giiCustomViewCrud', // template name => path to template
                    ]
                ]
            ],
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'XLuinHMpxBlumQxoKIKd',
            'csrfParam' => '_csrf-backend',
            'baseUrl' => $_ENV['BACKEND_BASEURL'],
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'assignmentFile' => '@console/rbac/assignments.php',
            'itemFile' => '@console/rbac/items.php',
            'ruleFile' => '@console/rbac/rules.php',
        ],
        'user' => [
            'identityClass' => 'common\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_backendUser', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            //'name' => 'advanced-backend',
            'name' => 'PHPBACKSESSID',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['login'],
                    'exportInterval' => 1,
                    'logFile' => '@backend/runtime/logs/login.log',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'baseUrl' => $_ENV['BACKEND_BASEURL'],
            'enablePrettyUrl' => true, // Cancel passing route in get 'r' paramater
            'showScriptName' => false, // Remove index.php from url
            'suffix' => '', // Add suffix to all routes (globally)
            // Compare requested urls to routes
            'rules' => [
                'home' => '/site/index',
                'signup' => '/site/signup'
            ],
        ],
    ],
    //force to login into every views if not recognized as login user
    'as access' => [
        'class' => \yii\filters\AccessControl::className(), //AccessControl::className(),
        'rules' => [
            [
                'actions' => ['login', 'error'],
                'allow' => true,
            ],
            [
                'actions' => ['signup'],
                'allow' => true,
                'roles' => ['admin'], // solo utenti con ruolo admin possono registrare un utente
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'on beforeRequest' => function ($event) {
        $lang = Yii::$app->session->get('lang');
        // fallback a lingua di default se non presente
        if (!$lang) {
            $lang = Yii::$app->language;
        }
        Yii::$app->language = $lang;
    },
    'params' => $params,
];
