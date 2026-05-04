<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$statusCode = $exception instanceof \yii\web\HttpException ? $exception->statusCode : 500;

$this->title = 'Errore ' . $statusCode;
?>
<h1>Errore <?= Html::encode($statusCode) ?> </h1>

<?php if ($statusCode == 404): ?>
    <p>La pagina richiesta non è stata trovata.</p>
<?php elseif ($statusCode == 500): ?>
    <p>Errore interno del server. Stiamo lavorando per risolvere il problema.</p>
<?php else: ?>
    <p>Si è verificato un errore. Codice: <?= Html::encode($statusCode) ?></p>
<?php endif; ?>

<?php if (YII_ENV_DEV): ?>
    <hr>
    <h4>Dettagli tecnici:</h4>
    <pre><?= Html::encode($exception->getMessage()) ?></pre>
<?php endif; ?>
