<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\widgets\Pjax;
use yii\bootstrap4\LinkPager;
use yii\helpers\Url;

?>
<div class="col-lg-4">
    <!-- Search widget-->
    <div class="card mb-4">
        <div class="card-header">Поиск по названию</div>
        <?php $form = ActiveForm::begin([
            'id' => 'search-form',
            'options' => ['class' => 'card-body'],
            'enableClientValidation' => false,
            'fieldConfig' =>
                ['options' => ['class' => 'mb-0']],
        ]); ?>

        <?= $form->field($search, 'searchLine')->textInput()->label(false) ?>

        <?php ActiveForm::end(); ?>
    </div>
    <!-- Categories widget-->
    <?php Pjax::begin(['id' => 'category_selector', 'enablePushState' => false]); ?>
    <div class="card mb-4">
        <div class="card-header">Поиск по категориям</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($categories as $category) { ?>
                            <?=  Html::Tag('li', Html::a($category->name . ' (' . $category->getArticlesCount() . ')', Url::toRoute(['site/category', 'id' => $category->id]), ['data-pjax' => 0]));?>
                        <?php } ?>
                    </ul>
                </div>
                <div class="d-flex col-sm-12 justify-content-center mt-4">
                    <?php echo LinkPager::widget([
                        'pagination' => $paginationCat,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
