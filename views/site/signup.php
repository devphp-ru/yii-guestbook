<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $signupModel app\models\form\SignupForm */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin([
        'id' => 'signup_form',
    ]); ?>

    <?= $form->field($signupModel, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($signupModel, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($signupModel, 'password')->passwordInput(['maxlength' => true]) ?>


    <?= $form->field($signupModel, 'homepage')->input('url', ['maxlength' => true]) ?>

    <?= $form->field($signupModel, 'verifyCode')->widget(Captcha::className())->label('Введите код:'); ?>

    <?php
//    echo $form->field($signupModel, 'reCaptcha')->widget(
//        \himiklab\yii2\recaptcha\ReCaptcha::className(),
//        ['siteKey' => 'siteKey']
//    )->label(false);
    ?>

    <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

    <?php ActiveForm::end(); ?>
</div>
