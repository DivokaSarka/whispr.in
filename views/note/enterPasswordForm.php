<?php
/* @var $model \app\models\Note */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<?php Pjax::begin(['id' => 'pjax-container']); ?>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'options' => [
        'data-pjax' => true,
    ],
]); ?>

<div class="row">
    <div class="col-md-12">
        <h4>Секретный пароль</h4>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'password')
            ->passwordInput()
            ->label(false) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('Показать', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end() ?>
<?php Pjax::end(); ?>
