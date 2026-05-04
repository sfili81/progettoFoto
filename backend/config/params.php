<?php
return [
    'bsVersion'  => '5.x', // this will set globally `bsVersion` to Bootstrap 5.x for all Krajee Extensions
    'adminEmail' => 'sfiligoi@iosystems.it',

    /* Lingue del backend  */
    'be_languages' => [
        'it-IT' => ['label' => 'Italiano', 'flag' => 'it.svg'],
        'en-EN' => ['label' => 'English', 'flag' => 'en.svg'],
    ],
    /* Lista dei blocchi per modelli diversi da page */
    'block' => [
        /*'Company' => [
            '_view_firstBlock' => 'Primo Blocco',
            '_view_secondBlock' => 'Secondo Blocco',
            '_view_talentiMatarans' => 'Advisor Matarans', 
        ],*/],

    /* img side */
    'imgSide' => [
        '0' => 'sinistra',
        '1' => 'destra',
    ],

    /* Dati per pulsanti gridview backend */
    'gridviewAction' => [
        'view' => [
            'string' => '<i class="far fa-eye"></i>',
            'class'  => 'btn-primary',
            'data' => "",
        ],
        'update' => [
            'string' => '<i class="far fa-edit"></i>',
            'class'  => 'btn-info',
            'data' => "",
        ],
        'delete' => [
            'string' => '<i class="far fa-trash-alt"></i>',
            'class'  => 'btn-danger',
            'data' => [
                'confirm' => 'Sei sicuro di voler proseguire ?',
                'method' => 'post',
            ],
        ],
    ],

    /* Kartik switch plugin options */
    'KartikSwitchOptions' => [
        'pluginOptions' => [
            'size' => 'medium',
            'onText' => 'Si',
            'offText' => 'No',
            'animate' => false,
            'onColor' => 'success',
            'offColor' => 'danger',
        ],
    ],

    /* Array Toolbar options per Text Editor Quill */
    'quillOptions' => [
        'toolbarOptions' => [
            ['bold', 'italic', 'underline'],
            [['header' => [1, 2, 3, 4, 5, 6, false]]],
            [['list' => 'ordered'], ['list' => 'bullet']],
        ],
    ],


];
