<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $surname;
    public $phone;
    public $email;
    public $subject;
    public $text;
    public $privacy;
    //public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email','surname',  'text','privacy',], 'required','message' => 'Campo obbligatorio'],
            [['phone','subject',], 'safe'],
            // email has to be a valid email address
            ['email', 'email'],
            /*[['reCaptcha'], 'required'],
            [['reCaptcha'], \luyadev\recaptcha\ReCaptchaValidator3::class, 'threshold' => 0.5, 'action' => 'homepage'],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($model): bool
    {
        $this->subject="Richiesta informazioni";
        return Yii::$app->mailer->compose('contacts-mail',[ 'data' => $model ])
            ->setTo(Yii::$app->params['senderEmail']) //manda la mail a 
            ->setFrom([$this->email => $this->name])
            ->setBcc(Yii::$app->params['urbano'])
            ->setReplyTo([$this->email => $this->name])
            ->setSubject('Richiesta Informazioni')
            ->send();
    }
}
