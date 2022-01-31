<?php

namespace app\models;


use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [

            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[а-яёА-ЯЁa-zA-Z ]+$#'],
            ['username', 'string', 'min' => 2, 'max' => 50],

            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => 'Почта уже зарегистрирована.'],
            ['email', 'string', 'max' => 100],

            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],

            ['homepage', 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @param $email
     * @return User|null
     */
    public static function findByUserEmail($email)
    {
        return static::findOne([
            'email' => $email,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @param $email_confirm_token
     * @return User|null
     */
    public static function findByEmailConfirmToken($email_confirm_token)
    {
        return static::findOne([
            'email_confirm_token' => $email_confirm_token,
            'status' => self::STATUS_WAIT,
        ]);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    /**
     *
     */
    public function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
