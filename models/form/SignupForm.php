<?php


namespace app\models\form;


use Yii;
use app\models\User;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $homepage;

    public $verifyCode;
    //public $reCaptcha;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'homepage'], 'filter', 'filter' => 'trim'],
            [['username', 'email', 'password',], 'required'],

            ['username', 'string', 'min' => 2, 'max' => 50],
            ['username', 'match', 'pattern' => '#^[а-яёА-ЯЁa-zA-Z ]+$#'],

            ['email', 'email'],
            ['email', 'string', 'max' => 100],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => 'email'],

            ['verifyCode', 'captcha'],
            //[['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => 'secret']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя',
            'email' => 'Эл. почта',
            'password' => 'Пароль',
            'homepage' => 'Домашняя страница',
        ];
    }

    /**
     * @return User
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->homepage = $this->homepage;
            $user->setPassword($this->password);
            $user->generateEmailConfirmToken();
            $user->status = User::STATUS_WAIT;

            if ($user->save(false)) {
                $this->sendActivationEmail($user);

                return $user;
            }
        }
    }

    /**
     * @param $user
     */
    public function sendActivationEmail($user)
    {
        Yii::$app->mailer->compose()
            ->setFrom(['testishop2@ukr.net' => 'Письмо с сайта'])
            ->setTo($this->email)
            ->setSubject('Подтвердите Вашу контактную информацию')
            ->setTextBody('Подтвердите Вашу контактную информацию')
            ->setHtmlBody("<b>Пожалуйста, нажмите следующую ссылку, чтобы верифицировать е-мейл адрес. <a href=\"http://guest-book.loc/site/confirm-email?token={$user->email_confirm_token}\">Подтвердить</a></b>")
            ->send();
    }
}
