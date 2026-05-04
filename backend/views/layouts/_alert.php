<?php
use kartik\alert\AlertBlock;
use kartik\growl\Growl;

/**
 * Mostra un alert quando trova un flash message.
 * Utilizza un'estensione ddi kartik
 * Se si vuole usare la versioen standard è necessario
 * nella vista layouts/main.php rimuovere il rendere di questa vista
 * ed usare <?= Alert::widget()  ?> 
 */

/*
* Array di configurazione per l'alert: per ogni tipo di messaggio verrà usata questa configurazione
* 
*/
$config = [ 'placement' => [
                'from' => 'center',
                'align' => 'center',
            ]
        ];

echo AlertBlock::widget([
    'useSessionFlash' => true,
    'type' => AlertBlock::TYPE_GROWL,
    'delay' => false,
    'alertSettings' => [
        'success' => [
            'type' => 'success',
            'icon' => 'fas fa-check',
            'title' => ' ',
            'showSeparator' => true,
            'pluginOptions' => $config
        ],
        'error' => [
            'type' => Growl::TYPE_DANGER,
            'icon' => 'fas fas fa-exclamation-triangle',
            'title' => strtoupper(Yii::t('backend', 'Error')),
            'showSeparator' => true, 
            'pluginOptions' => $config
        ],
        'warning' => [
            'type' => Growl::TYPE_WARNING,
            'icon' => 'far fa-bell', 
            'title' => 'WARNING',
            'showSeparator' => true,
            'pluginOptions' => $config
        ],
        'info' => [
            'type' => Growl::TYPE_INFO,
            'icon' => 'fas fa-info-circle',  
            'title' => 'INFO',
            'showSeparator' => true,
            'pluginOptions' => $config
        ],
    ],
    'closeButton' => [
        'tag' => 'button',
        'class' => 'btn-close alert-dismiss'
    ]
]);


