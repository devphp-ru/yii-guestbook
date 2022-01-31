<?php


namespace app\models;


use yii\data\ActiveDataProvider;

class MessageSearch extends Message
{
    public $user_name;
    public $user_email;
    public $created_at;

    public $pageSize = 25;

    public function rules()
    {
        return [
            [['user_name', 'user_email', 'created_at'], 'safe']
        ];
    }

    public function search($params)
    {
        $query = Message::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $this->pageSize,
        ]);

        return $dataProvider;
    }
}