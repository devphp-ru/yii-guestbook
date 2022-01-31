<?php


namespace app\models;


use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Message extends ActiveRecord
{
    public $pageSize = 25;

    public static function tableName()
    {
        return 'message';
    }

    public function all()
    {
        $query = self::find();

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id_message' => SORT_DESC,
                ],
            ],
        ]);
    }
}
