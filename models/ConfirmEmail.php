<?php


namespace app\models;


use yii\base\InvalidArgumentException;
use yii\base\Model;

class ConfirmEmail extends Model
{
    public $token;
    private $_user;

    /**
     * ConfirmEmail constructor.
     * @param $token
     * @param array $config
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Токен электронной почты не может быть пустым.');
        }

        $this->_user = User::findByEmailConfirmToken($token);

        if (!$this->_user) {
            throw new InvalidArgumentException('Неверный токен подтверждения электронной почты.');
        }

        parent::__construct($config);
    }

    /**
     * @return User|null
     */
    public function confirm()
    {
        $user = $this->_user;
        $user->status = User::STATUS_ACTIVE;
        return $user->save(false) ? $user : null;
    }
}
