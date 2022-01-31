<?php


namespace app\controllers;


use app\models\User;
use app\models\UserMessageSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $userId = Yii::$app->user->id;
        $userModel = $this->findModel($userId);
        $userMessageSearch  = new UserMessageSearch();
        $dataProvider = $userMessageSearch->search(Yii::$app->request->queryParams);

        return $this->render('index', compact(
            'userModel',
            'userMessageSearch',
            'dataProvider'
        ));
    }

    /**
     * @param $userId
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAjaxUpdateUserData($userId)
    {
        $modelUser = $this->findModel($userId);
        if ($modelUser->load(Yii::$app->request->post())) {
            return $this->asJson(['success' => $modelUser->save()]);
        }
    }

    /**
     * @param $userId
     * @return User|null
     * @throws NotFoundHttpException
     */
    protected function findModel($userId)
    {
        if (($model = User::findOne($userId)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
