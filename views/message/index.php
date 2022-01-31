<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $userMessageSearch \app\models\UserMessageSearch
 */

$this->title = 'Личный кабинет';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-12">

                <h1><?= Html::encode($this->title) ?></h1>

                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $userMessageSearch,
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
                            'value' => function ($model) {
                                if ($model->file_path) {
                                    return Html::img('@web/' . $model->file_path, ['width' => '80px']);
                                } else {
                                    return 'no file';
                                }
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update}',
                        ],
                    ],
                ]); ?>

            </div>
        </div>

    </div>
</div>
