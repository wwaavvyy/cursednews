<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use phpnt\summernote\SummernoteWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Обновить новость: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'col-lg-5 pl-0'],
        'fieldConfig' => [
            'inputOptions' => ['class' => 'form-control'],
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'content')->widget(SummernoteWidget::class, [
        'widgetAsset' => 'bootstrap-4',
        'i18n' => true,
        'emoji' => false,
        'codemirror' => false,
        'widgetOptions' => [
            'toolbar' => [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol']],
                ['table', ['table']],
                ['view', ['fullscreen', 'help']],
            ],
            'height' => 250,
        ],
    ]) ?>

    <?= $form->field($model, 'status_id')->dropDownList($statusList) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryList) ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
