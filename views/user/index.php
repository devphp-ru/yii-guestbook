<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $userModel \app\models\User
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchUserMessage \app\models\UserMessageSearch
 */

$this->title = 'Личный кабинет';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-12">

                <h1><?= Html::encode($this->title) ?></h1>

                <?php $form = ActiveForm::begin([
                    'id' => 'user_form',
                    'method' => 'POST',
                    'action' => Url::to([
                        '@web/user/ajax-update-user-data',
                        'userId' => $userModel->id,
                    ]),
                ]); ?>

                <table class="table">
                    <tbody>
                    <tr>
                        <th scope="row">Имя</th>
                        <td><?= $form->field($userModel, 'username')->textInput(['maxlength' => true])->label(false); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td><?= $form->field($userModel, 'email')->textInput(['maxlength' => true])->label(false); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Домашняя страница</th>
                        <td> <?= $form->field($userModel, 'homepage')->textInput(['maxlength' => true])->label(false); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Дата регистрации</th>
                        <td>
                            <?php echo \date('d.m.Y H:i', $userModel->created_at); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div id="response"></div>
                <?= HTML::submitButton('Изменить', ['class' => 'btn btn-success']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>
