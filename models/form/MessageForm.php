<?php


namespace app\models\form;


use Yii;
use yii\base\Model;
use Imagine\Image\Box;
use app\models\Message;
use Imagine\Gd\Imagine;

class MessageForm extends Model
{
    public $user_id = null;
    public $user_name = '';
    public $user_email;
    public $text;
    public $file_path;
    public $homepage;

    public $verifyCode;
    //public $reCaptcha;

    public function rules()
    {
        return [
            [['user_name', 'user_email', 'homepage', 'text'], 'filter', 'filter' => 'trim'],
            [['user_name', 'user_email', 'text'], 'required'],

            ['user_name', 'string', 'min' => 2, 'max' => 50],
            [['user_name'], 'match', 'pattern' => '/^[а-яёА-ЯЁa-zA-Z ]+$/'],

            ['user_email', 'email'],
            ['user_email', 'string', 'max' => 100],

            [['text'], 'filter', 'filter' => function ($value) {
                return strip_tags($value);
            }
            ],

            [['file_path'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif, jpeg, txt', 'maxFiles' => 1,],

            [['homepage'], 'url'],

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
            'user_name' => 'Имя*',
            'user_email' => 'Эл. почта*',
            'text' => 'Сообщение*',
            'file_path' => 'Файл',
            'homepage' => 'Домашняя страница',
        ];
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function upload()
    {
        $extension = $this->file_path->extension;
        $fileName = Yii::$app->security->generateRandomString(20) . '.' . $extension;
        $filePath = 'uploads/' . $fileName;
        $this->file_path->saveAs($filePath);

        if ($this->file_path->extension != 'txt') {
            $this->resize($filePath);
        }

        return $filePath;
    }

    /**
     * @param $filePath
     * @return bool
     */
    public function resize($filePath)
    {
        $size = getimagesize($filePath);
        if ($size[0] > 320 || $size[1] > 240) {
            $imagineObj = new Imagine();
            $photo = $imagineObj->open($filePath);
            $photo->thumbnail(new Box(320, 240))->save($filePath, ['quality' => 90]);
            return true;
        }
        return false;
    }

    /**
     * @param $fileName
     * @return bool
     */
    public static function deleteFile($fileName)
    {
        $filePath = __DIR__ . '/../../web/' . $fileName;
        if ($fileName != null && file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    public function create()
    {
        $message = new Message();
        $message->user_id = $this->user_id;
        $message->text = $this->text;
        $message->user_name = $this->user_name;
        $message->user_email = $this->user_email;
        $message->homepage = $this->homepage;
        $message->user_agent = Yii::$app->request->getUserAgent();
        $message->user_ip = ip2long(Yii::$app->request->userIP);
        $message->created_at = date('Y-m-d H:i:s');
        $message->file_path = $this->upload();

        return $message->save();
    }
}
