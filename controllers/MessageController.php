<?php


namespace app\controllers;


use Yii;
use app\models\Message;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\UserMessageSearch;
use yii\web\NotFoundHttpException;
use app\models\form\MessageUpdateForm;

class MessageController extends Controller
{
    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $userMessageSearch  = new UserMessageSearch();
        $dataProvider = $userMessageSearch->search(Yii::$app->request->queryParams);

        return $this->render('index', compact(
            'userMessageSearch',
            'dataProvider'
        ));
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $oneMessage = $this->findModel($id);
        if (Yii::$app->user->isGuest && ($oneMessage->user_id !== Yii::$app->user->id)) {
            return $this->redirect('/');
        }

        $updateModel = new MessageUpdateForm();

        if ($updateModel->load(Yii::$app->request->post())) {
            $updateModel->file_path = UploadedFile::getInstance($updateModel, 'file_path');
            if ($updateModel->validate() && $updateModel->update($oneMessage)) {
                return $this->redirect('/message/update?id=' . $oneMessage->id_message);
            }
        }

        $updateModel->text = $oneMessage->text;

        return $this->render('update', compact(
            'updateModel',
            'oneMessage'
        ));
    }

    /**
     * @param $id
     * @return Message|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
