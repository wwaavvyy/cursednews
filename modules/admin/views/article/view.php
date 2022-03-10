<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

    <h1><?= Html::a(Html::encode($this->title), Url::to(['/site/view', 'id' => $model->id])) ?></h1>

    <p>
        <?= Html::a('Установить теги', ['set-tags', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту новость?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user.username',
            'title',
            'description:ntext',
            'category.name',
            'status.name',
            //'content:ntext',
            'datestamp',
            //'image',
            'views',
            'likes',
        ],
    ]) ?>

</div>
