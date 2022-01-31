<?php


namespace app\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserMessageSearch extends Message
{
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Message::find();

        $userId = Yii::$app->user->id;
        $query->andFilterWhere([
            'user_id' => $userId,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
