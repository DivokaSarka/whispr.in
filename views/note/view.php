<?php
/* @var $model \app\models\Note */

use yii\bootstrap\Html;
use yii\widgets\Pjax;
?>
<?php Pjax::begin(['id' => 'pjax-container']); ?>
<h2>Содержание записки</h2>

<?php if ($model->lifetime === 0): ?>
    <div class="alert alert-warning" role="alert">
        Эта записка удалена. Если вам нужно сохранить текст, скопируйте его перед закрытием этого окна.
    </div>
<?php else: ?>
    <div class="alert alert-warning" role="alert">
        Записка будет удалена автоматически <?= date('d.m.Y в H:i', $model->lifetime) ?>.
    </div>
<?php endif; ?>

<?= Html::textarea(null, $model->body, [
    'class' => 'form-control',
    'readonly' => true,
    'rows' => 12,
]) ?>
<?php Pjax::end(); ?>

<?php if (!empty($model->file_path)): ?>
    <?= Html::a(
        'Скачать файл',
        '@web/uploads/' . $model->file_path,
        ['style' => 'margin-top: 20px; display: block;']
    ) ?>
<?php endif; ?>
