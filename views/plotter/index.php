<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(['options' => [
    'enctype' => 'multipart/form-data',
    'id' => 'set_file'
]]) ?>
<?= $form->field($model, 'file')->fileInput(['class' => 'work btn btn-success']) ?>
<?= Html::submitButton('Загрузить файл', ['id' => 'js_loadFile',  'class' => 'work btn btn-success']) ?>
<?php ActiveForm::end(); ?>
<div id="js_parse">
    <?php if ($result): ?>
        <a href="<?= \yii\helpers\Url::toRoute(['plotter/parse']) ?>" class="js_parse btn btn-success">Построить график</a>
        <?= $this->render('_plotter') ?>
        <div id="file_content">
            <?= $result ?>
        </div>
    <?php else: ?>
        <p id="message"><?= $message ?></p>
    <?php endif; ?>

</div>
