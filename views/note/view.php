<?php
/* @var $model \app\models\Note */

use yii\bootstrap\Html;
use yii\widgets\Pjax;
?>
<?php Pjax::begin(['id' => 'pjax-container']); ?>
<h2>Содержание записки</h2>
<div class="alert alert-warning" role="alert">
    Эта записка удалена. Если вам нужно сохранить текст, скопируйте его перед закрытием этого окна.
</div>
<?= Html::textarea(null, $model->body, [
    'class' => 'form-control',
    'readonly' => true,
    'rows' => 12,
]) ?>
<?php Pjax::end(); ?>
