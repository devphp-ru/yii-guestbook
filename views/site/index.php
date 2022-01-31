<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider app\models\Message */
/* @var $messageForm app\models\form\MessageForm */

use yii\bootstrap4\Modal;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Гостевая книга';
$user = Yii::$app->currentUser->get();

?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-12">

                <h1><?= Html::encode($this->title) ?></h1>

                <div class="mt-2 mb-2">
                    <?= Html::beginForm([''], 'get') ?>
                    <label for="pager-selector">Число записей на странице </label>
                    <select name="per-page" id="pager-selector">
                        <?php
                        $perPage = empty(Yii::$app->session->get('perPage')) ? 5 : Yii::$app->session->get('perPage');
                        Yii::$app->session->set('perPage', null);
                        ?>
                        <?php
                        echo Html::renderSelectOptions('per-page', [
                            $perPage => $perPage,
                            2 => 2,
                            4 => 4,
                            5 => 5,
                            10 => 10,
                            15 => 15
                        ])
                        ?>
                    </select>
                    <?= Html::submitButton('Выбрать', ['class' => 'btn btn-default']) ?>
                    <?= Html::endForm() ?>
                </div>

                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'user_name',
                            'value' => 'user_name',
                            'label' => 'Имя',
                        ],
                        [
                            'attribute' => 'user_email',
                            'value' => 'user_email',
                            'label' => 'Email',
                        ],
                        'text',
                        [
                            'attribute' => 'created_at',
                            'label' => 'Дата добавления',
                        ],
                        [
                            'attribute' => 'file_path',
                            'format' => 'html',
                            'value' => function ($data) {
                                if ($data->file_path) {
                                    return Html::img('@web/' . $data->file_path, ['width' => '80px']);
                                } else {
                                    return 'no image';
                                }
                            }
                        ],
                    ],
                ]); ?>

                <h4 class="mt-5">Добавить сообщение</h4>

                <?php
                $form = ActiveForm::begin([
                    'id' => 'message_form',
                    'enableAjaxValidation' => false,
                    'options' => ['enctype' => 'multipart/form-data']
                ]);
                ?>

                <?= $form->field($messageForm, 'user_id')->hiddenInput([
                    'value' => $user->id ?? null,
                ])->label(false); ?>

                <?= $form->field($messageForm, 'user_name')->textInput([
                    'id' => 'user_name',
                    'value' => $user->username ?? null,
                ]); ?>

                <?= $form->field($messageForm, 'user_email')->textInput([
                    'id' => 'user_email',
                    'value' => $user->email ?? null,
                ]); ?>

                <?= $form->field($messageForm, 'homepage')->textInput([
                    'id' => 'homepage',
                    'value' => $user->homepage ?? null,
                ]); ?>

                <?= $form->field($messageForm, 'text')->textarea([
                        'id' => 'text',
                        'rows' => '3'
                ]); ?>

                <?= $form->field($messageForm, 'file_path')->fileInput(); ?>

                <?= $form->field($messageForm, 'verifyCode')->widget(Captcha::className())->label('Введите код:'); ?>

                <?php
                //    echo $form->field($messageForm, 'reCaptcha')->widget(
                //        \himiklab\yii2\recaptcha\ReCaptcha::className(),
                //        ['siteKey' => 'siteKey']
                //    )->label(false);
                ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
                    <button type="button" class="btn btn-primary see-message" data-toggle="modal" data-target=".bd-example-modal-xl">Предпросмотр сообщения</button>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>

<div class="modal fade see-modal" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Предпросмотр сообщения</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="see-body" class="panel-body">
                <div class="card-body">
                    <div class="mar-btm">
                        <p class="text-semibold media-heading box-inline">Имя: <span class="see-username"></span></p>
                    </div>
                    <div class="mar-btm">
                        <p class="text-semibold media-heading box-inline">Email: <span class="see-useremail"></span></p>
                    </div>
                    <div class="mar-btm">
                        <p class="text-semibold media-heading box-inline">Домашняя страница: <span class="see-homepage"></span></p>
                    </div>
                    <div class="mar-btm">
                        <p class="text-semibold media-heading box-inline">Сообщение: <span class="see-text"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
