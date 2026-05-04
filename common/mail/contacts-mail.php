<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<style type="text/css">
    body {
        background: #fff;
    }
</style>

<table style="padding:10px;width:100%;max-width:680px;background:#fff;">
    <tr>
        <td align="right" style="border-bottom:2px solid #000;">
            <img src="https://otticarussi.it/frontend/web/img/logo.png" alt="Logo">
        </td>
    </tr>
    <tr>
        <td style="padding-top:30px;padding-left:30px;padding-right:30px;">
            <p>Nuova richiesta informazioni ricevuta</p>
        </td>
    </tr>
    <tr>
        <td style="padding-top:10px;padding-left:30px;padding-right:30px;">
            <table style="border: 1px solid #dededf;padding:10px;width:100%;">
                <tr>
                    <td>
                        <p>
                            <strong>Nome</strong><br>
                            <?= $data->name ?><br>
                        </p>
                    </td>
                </tr>
                <tr>
                    <?php if (!empty($data->phone)): ?>
                        <td>
                            <p>
                                <strong>Telefono</strong><br>
                                <?= $data->phone ?><br>
                            </p>
                        </td>
                    <?php endif ?>
                </tr>
                <tr>
                    <td>
                        <p>
                            <strong>Email</strong><br>
                            <?= $data->email ?><br>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            <strong>Messaggio</strong><br>
                            <?= $data->text ?><br>
                        </p>
                    </td>

                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding-top:30px;padding-left:30px;padding-right:30px;padding-bottom:60px;">
            <p>Puoi contattare l'utente rispondendo direttamente a questo messaggio</p>
            <p>Cordiali saluti<br><i>IOsystems Agenzia Digitale</i></p>
        </td>
    </tr>
    <tr>
        <td style="border-top:1px solid #000;">
            <p style="font-size:12px;color:#817979;margin-top:10px;">
                In base al Reg.UE 2016/679 (GDPR), si precisa che le informazioni contenute in questo messaggio sono riservate e ad uso esclusivo del destinatario.<br><br>
                Qualora il messaggio in parola Le fosse pervenuto per errore, La preghiamo di eliminarlo senza copiarlo e di non inoltrarlo a terzi, dandocene gentilmente comunicazione
                a <a href="mailto:info@otticarussi.it" title="info@otticarussi.it" style="color:#000;">info@otticarussi.it</a>.
            </p>
        </td>
    </tr>
</table>