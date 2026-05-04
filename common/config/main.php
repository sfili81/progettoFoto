<?php
return [
    // set target language to be Italian
    'language' => 'it-IT',
    //set application name
    'name' => $_ENV['APP_NAME'], 

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ]
    ],
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'i18n' => [
            'translations' => [
                'backend*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap'  => [
                        'backend' => 'backend.php',
                    ],
                ],

                'app*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap'  => [
                        'app' => 'app.php',
                    ],
                ],
                // Per attivare le traduzioni da database leggi documentazione
                /*'frontend*' => [
                    'class'           => 'yii\i18n\DbMessageSource',
                    'enableCaching'   => true,
                    'cachingDuration' => 3600
                ],*/
            ],
        ],
        //RECAPCTHA V3
        /*'reCaptcha' => [
            'class' => 'luyadev\recaptcha\ReCaptchaConfig',
            'siteKeyV3' => $ENV['GOOGLE_RECAPTCHA_SITE'],
            'secretV3'  => $ENV['GOOGLE_RECAPTCHA_SECRET'],
        ],*/
    ],
];
