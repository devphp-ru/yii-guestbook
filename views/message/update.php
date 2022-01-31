<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $modelUser \app\models\User
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchUserMessage \app\models\UserMessageSearch
 */

$this->title = 'Редактировать сообщение#' . $oneMessage->id_message;
$this->params['breadcrumbs'][] = ['label' => 'Все сообщения', 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <div class="message-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($updateModel, 'text')->textarea(['rows' => '6']) ?>
        <?= $form->field($updateModel, 'file_path')->fileInput() ?>


        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?php
    if ($oneMessage->file_path) {
        echo Html::img('@web/' . $oneMessage->file_path, ['width' => '400px']);
    }
    ?>

</div>