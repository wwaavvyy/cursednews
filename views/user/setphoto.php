<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use phpnt\summernote\SummernoteWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Изменить аватар';
?>
<div class="set-photo">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'col-lg-5 pl-0'],
        'fieldConfig' => [
            'inputOptions' => ['class' => 'form-control'],
        ],
    ]); ?>

    <?= $form->field($model, 'photo')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
