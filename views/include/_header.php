<?php

/** @var yii\web\View $this */

use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Html;

?>
<header>
    <?php
    NavBar::begin([
        'brandLabel' => 'Гостевая книга',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);

    $menu = [
        ['label' => 'Сообщения', 'url' => ['/']],
    ];

    if (Yii::$app->user->isGuest) {
        $menu[] = ['label' => 'Регистрация', 'url' => ['/signup']];
        $menu[] = ['label' => 'Вход', 'url' => ['/login']];
    } else {
        $menu[] = ['label' => 'Личный кабинет', 'url' => ['/user']];
        $menu[] = ['label' => 'Мои сообщения', 'url' => ['/message']];
        $menu[] = '<li>'
            . Html::beginForm(['/logout'], 'post')
            . Html::submitButton(
                'Выход (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menu,
    ]);

    NavBar::end();
    ?>
</header>
