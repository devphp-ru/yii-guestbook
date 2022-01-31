<?php


namespace app\models\form;



class MessageUpdateForm extends MessageForm
{
    public function rules()
    {
        return [
            [['text'], 'required'],
            ['text', 'trim'],
            [['text'], 'filter', 'filter' => function ($value) {
                return strip_tags($value);
            },
            ],

            [['file_path'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif, jpeg, txt', 'maxFiles' => 1,],
        ];
    }

    /**
     * @param $message
     * @return bool
     * @throws \yii\base\Exception
     */
    public function update($message)
    {
        $message->text = $this->text;

        if ($this->file_path != null) {
            self::deleteFile($message->file_path);
            $message->file_path = $this->upload();
        }

        return $message->save();
    }
}
