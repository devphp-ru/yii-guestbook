<?php


namespace app\components;


use Yii;
use app\models\User;
use yii\base\Component;

class CurrentUserComponent extends Component
{
    public $user = null;

    public function __construct($config = [])
    {
        $this->user = User::findOne([
            'id' => Yii::$app->user->id,
            'status' => User::STATUS_ACTIVE,
        ]);

        parent::__construct($config);
    }

    public function get()
    {
        return $this->user;
    }
}