<?php
/* @var $model \app\models\Note */

use yii\bootstrap\Html;
use yii\widgets\Pjax;
?>
<?php Pjax::begin(['id' => 'pjax-container']); ?>
<h2>Ссылка на записку готова</h2>
<?= Html::textInput(null, $model->getLink(), ['class' => 'form-control', 'readonly' => true]) ?>
<p>
    <div class="btn-group" role="group" aria-label="...">
        <?= Html::mailto('Отправить по почте', '?body=' . $model->getLink(), [
            'class' => 'btn btn-primary',
            'data-pjax' => 0,
        ]) ?>
        <?= Html::a('Уничтожить записку сейчас', ['/note/delete', 'uid' => $model->uid], [
            'class' => 'btn btn-danger',
            'data-pjax' => 0,
        ]) ?>
    </div>
</p>
<?php Pjax::end(); ?>
