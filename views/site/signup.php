<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните данные ниже, чтобы войти:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'signup-form',
        'fieldConfig' => [
            'inputOptions' => ['class' => 'col-lg-5 form-control'],
        ],
    ]); ?>

    <?= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'agreement')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
