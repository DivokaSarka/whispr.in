<?php
/* @var $model \app\models\Note */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<?php Pjax::begin(['id' => 'pjax-container']); ?>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-2">
        <img src="/img/security.png">
    </div>
    <div class="col-md-10">
        Весь текст передается по безопасному соединению, мы получаем его,
        шифруем и отправляем на защищенный сервер, доступ к которому имеют только сотрудники сервиса.
        Мы не храним данные об IP-адресах пользователей и не ведем логи.
        Чтобы обеспечить максимальную анонимность, советуем использовать браузер TOR.
    </div>
</div>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'options' => [
        'data-pjax' => true,
    ],
]); ?>
<?= $form->field($model, 'body')
    ->textarea([
        'rows' => 12,
        'placeholder' => 'Напишите ваш текст здесь...',
    ])
    ->label(false) ?>

<div class="row">
    <div class="col-md-12">
        <h4>Секретный пароль
            <small>(по желанию)</small>
        </h4>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'password')
            ->passwordInput()
            ->hint('Введите пароль для дешифрования записки')
            ->label(false) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'passwordRepeat')
            ->passwordInput()
            ->hint('Повторить пароль')
            ->label(false) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('Создать записку', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end() ?>
<?php Pjax::end(); ?>
