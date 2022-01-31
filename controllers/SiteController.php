<?php

namespace app\controllers;


use app\models\form\MessageForm;
use app\models\Message;
use Yii;
use app\models\ConfirmEmail;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\form\SignupForm;
use app\models\form\LoginForm;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $messageModel = new Message();

        if (!empty(Yii::$app->request->queryParams['per-page'])) {
            Yii::$app->session->set('perPage', Yii::$app->request->queryParams['per-page']);
            $messageModel->pageSize = Yii::$app->session->get('pre-page');
        }

        $dataProvider = $messageModel->all();

        $messageForm = new MessageForm();
        if ($messageForm->load(Yii::$app->request->post())) {
            $messageForm->file_path = UploadedFile::getInstance($messageForm, 'file_path');
            if ($messageForm->validate() && $messageForm->create()) {
                return $this->redirect('/');
            }
        }

        return $this->render('index', compact(
            'dataProvider',
            'messageForm'
        ));
    }

    /**
     * @return string|Response
     * @throws \yii\base\Exception
     */
    public function actionSignup()
    {
        $signupModel = new SignupForm();

        if ($signupModel->load(Yii::$app->request->post())) {
            if ($signupModel->signup()) {
                Yii::$app->session->setFlash('success', 'На Ваш адрес почты отправлено письмо с инструкцией по активации.');
                return $this->goHome();
            }
        }

        return $this->render('signup', compact(
            'signupModel'
        ));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginModel = new LoginForm();
        if ($loginModel->load(Yii::$app->request->post()) && $loginModel->login()) {
            return $this->goBack();
        }

        $loginModel->password = '';

        return $this->render('login', compact(
            'loginModel'
        ));
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @param $token
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionConfirmEmail($token)
    {
        try {
            $model = new ConfirmEmail($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (($user = $model->confirm()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Ваш email был подтвержден!');
        } else {
            Yii::$app->session->setFlash('error', 'К сожалению, мы не можем подтвердить вашу учетную запись с помощью предоставленного токена.');
        }

        return $this->goHome();
    }
}
