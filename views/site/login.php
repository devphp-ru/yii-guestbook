<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $loginModel app\models\form\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Заполните поля, чтобы войти:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>

    <?= $form->field($loginModel, 'email')->textInput() ?>

    <?= $form->field($loginModel, 'password')->passwordInput() ?>

    <?= $form->field($loginModel, 'rememberMe')->checkbox([
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ]) ?>

    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

    <?php ActiveForm::end(); ?>
</div>

