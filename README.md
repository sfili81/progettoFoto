<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">IOsystems Yii 2 Advanced Project </h1>
    <br>
</p>

- Clone project from github `[git clone -address- folder-to-clone]`
- Launch `composer install` to create vendor directory
- Launch `npm install`
- Enter into [nome app] directory and launch 'php init'
- Into `.env.dist` you will find the accesses for the db under development
- Launch `cp .env.dist .env` and then modify the .env file
- Create a new database
- Open a console terminal, apply migrations with command `php yii migrate`
- If you use xamp read [host yii2 xampp](docs/XAMPP.md)
- Now you base Yii-Application must work</li>
- If you want to use Tailwind and Webpack you must first install node etc etc Follow Guide

### Abilitare Schema cache per db

La memorizzazione nella cache dello schema del db è una funzione di memorizzazione nella cache speciale che deve essere abilitata ogni volta che si utilizza `Active Record`. Come sai, Active Record è sufficientemente intelligente da rilevare le informazioni sullo schema (ad esempio nomi di colonne, tipi di colonne, vincoli) su una tabella `DB` senza richiedere la loro descrizione manuale. Active Record ottiene queste informazioni **eseguendo query SQL aggiuntive**. Abilitando la memorizzazione nella cache dello schema, le informazioni sullo schema recuperate verranno salvate nella cache e riutilizzate nelle richieste future.

Per abilitare la `schema cache` aggiungere questi codici nel file di configurazione della connessione DB (es: `common\config\main-local.php`)

```php
return [
    // ...
    'components' => [
        // ...
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=mydatabase',
            'username' => 'root',
            'password' => '',
            'enableSchemaCache' => true,

            // Duration of schema cache.
            'schemaCacheDuration' => 3600,

            // Name of the cache component used to store schema information
            'schemaCache' => 'cache',
        ],
    ],
];
```

### Modello Company disponibile nelle viste generiche (es. main.php)

Per fare in modo che un dato o modello sia disponibile nelle viste generiche al di furoi di un controller, come ad esempio i dati aziendali nel footer, bisogna utilizzare il seguente codice nel file `frontend/config/bootstrap.php`

```php
    use yii\base\Event;
    use yii\web\View;
    use common\models\Company;

    Event::on(View::className(), View::EVENT_BEFORE_RENDER, function() {
        $company = Company::findOne(['id' => 1]);
        Yii::$app->view->params['company'] = $company;
    });
```

Questo codice intercetta la richiesta della classe View e, prima di effettuare il render di una vista, associa ai parametri il modello con i dettagli Aziendali. Nelle varie viste si può accedere a tali valori semplicemente richiamando `Yii::$app->view->params['company']`

### Note per Modelli Immagine

Le immagini singole vengono caricate usando il modello `Image` (backend\models\Image) in modo da prima salvare nella relativa tabella e poi associare
l'immagine al contenitore.
Per le immagini multiple (Slider/Gallery) viene utilizzato il modello `UploadFiles` (backend\models\UploadFiles) che salva un oggetto JSON contenete i dati relativi alle immagini

### Set a new remove for git

<p>Dopo aver fatto tutti i passaggi necessari all'installazione del nuovo progetto tramite git bisogna ricordarsi di cambiare i remote url di git
    altrimenti ogni volta che facciamo push pubblichiamo sul repository originale
 </p>
    <ol>
        <li> Creiamo un nuovo repository in github </li>
        <li> git remote set-url origin <code>url nuovo repository</code> </li>        
        <li> git push -u origin master</li>
    </ol>

<p>
Una volta effettuata la migrazione per creare due user nel backend (admin e iosystems) lanciare su mysql queste due query
<pre>
INSERT INTO admin (id, username, auth_key, password_hash, password_reset_token, email, status, created_at, updated_at, verification_token) VALUES (NULL, 'iosystems', 'totGJL0gAm56x0A9TzeWciPXMB-iiZlf', '$2y$10$FQXWU4TqYcgoG2Cvym6Qlez/Vjc5MVIl8ef1pQjP80c1YwHghFi4e', NULL, 'sfiligoi@iosystems.it', '10', '1709289821', '1709289821', 'apAJYtgQhk5NXn5_tAwT-ztIlzYIvA_R_1709289821') 
</pre>
<pre>
INSERT INTO admin (id, username, auth_key, password_hash, password_reset_token, email, status, created_at, updated_at, verification_token) VALUES (NULL, 'admin', 'me6UBncIKFpb70o-lFMb1MXnhFdH1Lo9', '$2y$13$KpiuV1YzsBfn8KuJwYSTiO38fjjTxzhu3ZHSbgmmq7Dzj7WshTsUS', NULL, 'admin@admin.com', '10', '1707730060', '1707730060', '39aF_1cO9xbLp0iGiDv8L2WlFvLivzbH_1707730060') 
</pre>
</p>

## Modifica globale al template di DetailView

Il widget DetailView mostra i dettagli di un singolo modello. In particolare li mostra sotto forma di tabella di questo tipo:
in una sola riga attributo -> valore.<br>
Se vogliamo cambiarlo abbiamo due possibilità:

1. Impostando il parametro template all'interno del widget:
   ```php
        DetailView::widget([
            'model' => $model,
            'template' => '<tr><td><h4>{label}</h4>{value}</td></tr>',
            //..
        ]);
   ```
2. Impostando un template in maniera globale tramite la [Dependency Injection](https://www.yiiframework.com/doc/guide/2.0/en/concept-di-container).
   ```php
        Yii::$container->set('yii\widgets\DetailView', ['template' => '<tr><td><h4>{label}</h4>{value}</td></tr>']);
   ```
   Aggiungendo questo codice ad esempio nel file bootstrap.php del backend, ogni DetailView utilizzerà questo template per visualizzarlo.

[DRAG & DROP SORT ORDER PER YII2 GRIDVIEW](docs/SORTABLEYII2JS.md)

[VALIDAZIONE FORM VANILLA JS YII2](docs/YII2VANILLAJSVALIDATOR.md)

[GRAFICA MIGLIORATA YII2 KARTIK TREEVIEW](docs/KARTIKTREEVIEWGRAPHIC.md)

[SALVATAGGIO IMMAGINI YII2](docs/IMGSAVE.md)

[STRING HELPER YII2](docs/STRINGHELPER.md)

[TRASFERIMENTO FILE VERSO SERVER](docs/FILETRANSFER.md)

[VSCODE + ESLINT + PRETTIER YII2](docs/ESLINT.md)

[DEPLOY YII2](docs/DEPLOYERGUIDE.md)

[YII2 MULTILANGUAGE](docs/MULTILANGUAGE.md)

[GESTIONE FILTRI E REDIRECT](docs/FILTERS.md)

[WEBPACK + YII2 ASSET MANAGEMENT CON MANIFEST.JSON](docs/WBPMANIFEST.md)

[PDF VIEWER INTEGRAZIONE YII2](docs/PDFVIEWER.md)

[ELIMINAZIONE MULTIPLA GRIDVIEW](docs/ELIMINAZIONEMULTIPLAYII2.md)

[GESTIONE PAGINE ERRORE YII2](docs/GESTERRORI.md)

[ORDINAMENTO BLOCCHI DRAG&DROP PER TABELLE ONETOMANY YII2](docs/BLOCKORDER.md)

[DOCKER SU YII2](docs/DOCKERYII2.md)

[BACKEND VISIBILE SOLO SE LOGGATI YII2](docs/BACKENDLOGIN.md)

[SEPARARE LOGIN FRONTEND E BACKEND YII2](docs/SEPARATEUSER.md)

[GESTIONE PAGINE E BLOCCHI YII2](docs/BLOCKS.md)

[VISTE CUSTOMIZZATE GII](docs/GII.md)

[MANY TO MANY YII2](docs/MANYTOMANY.md)

[CREARE SLUG PER PRETTY URL YII2](docs/SLUGS.md)

[ELIMINAZIONE IMMAGINI DA SERVER SU KARTIK FILEINPUT YII2](docs/DELETEIMG.md)

[WEBPACK + TAILWIND PER YII2](docs/WEBPACK.md)

[UTILIZZO DI TAILWIND PER YII2](docs/TAILWIND.md)

[TWIG YII2](docs/TWIG.md)

[INTERNATIONALIZATION YII2](docs/INTERNATIONALIZATION.md)

[KARTIK GRID VIEW YII2](docs/KGRIDVIEW.md)

[SORTABLE GRID VIEW](docs/SORTABLEGRIDVIEW.md)

[SEARCH ON ENTIRE YII2 APP](docs/SEARCHYII2.md)

[CREATE API FOLDER FOR RestFul API YII2](docs/APIFOLDER.md)

[CREATE RestFul API YII2](docs/RESTAPI.md)

[RBAC](docs/RBAC.md)

######################################################

<h2> TO-DO LIST</h2>

[Creazione salvataggio immagini in tabella dedicata](docs/IMGTABLE.md)
