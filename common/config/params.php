<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'sfiligoi@iosystems.it',
    'senderEmail' => 'noreply@example.com',
    'urbano' => 'urbano.iosystems@gmail.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,

    //Set Language for translate DB
    'languages' => [
        'it' => ['label' => 'it', 'name' => 'Italiano', 'locale' => 'it-IT'],
        'en' => ['label' => 'en', 'name' => 'English' , 'locale' => 'en-EN'],
        'fr' => ['label' => 'fr', 'name' => 'Français', 'locale' => 'fr-FR'],
    ],

    /* nome dei blocchi standard */
    'blockName' =>[
        ['id' => '0', 'name' => 'Header','view' => '_header' ],
        ['id' => '1', 'name' => 'Titolo e testo','view' => '_titleText' ],
        ['id' => '2', 'name' => 'Testo','view' => '_text' ],
        ['id' => '3', 'name' => 'Immagine e testo','view' => '_imgText' ],
        ['id' => '4', 'name' => 'Slider','view' => '_slider' ],
        ['id' => '5', 'name' => 'Pdf','view' => '_pdf',],
        //eventuali altre viste aggiungerle qui
    ],

];
