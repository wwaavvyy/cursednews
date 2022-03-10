<?php

use yii\bootstrap4\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Профиль пользователя - ' . $model->username;
$this->params['breadcrumbs'][] = 'Профиль пользователя ' . $model->username;;
\yii\web\YiiAsset::register($this);
?>
<div class="container">
    <div class="row">
        <div class="user-view col-lg-6">

            <h1> <?= $model->username ?> </h1>

            <div class="mb-4">
                <div class="row">
                    <div class="d-flex col-lg-4 align-items-center">
                        <div class="flex-column">
                            <?= Html::img('../web/uploads/' . $model->photo, ['class' => 'rounded img-fluid', 'alt' => $model->username . ' avatar']) ?>
                            <?php
                            if ($model->id == Yii::$app->user->identity->id) {
                                echo Html::a('Изменить аватар', ['setphoto', 'id' => $model->id], ['class' => 'btn btn-primary w-100 mt-3']);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="mt-3">
                            <?= Html::tag('p', 'Имя пользователя', ['class' => 'mb-0 font-weight-bold']) ?>
                            <?= Html::tag('p', $model->username) ?>
                        </div>
                        <div class="mt-3">
                            <?= Html::tag('p', 'Зарегистрирован', ['class' => 'mb-0 font-weight-bold']) ?>
                            <?= Html::tag('p', Yii::$app->formatter->asDatetime($model->datestamp, 'short')) ?>
                        </div>
                        <div class="mt-3">
                            <?= Html::tag('p', 'Роль', ['class' => 'mb-0 font-weight-bold']) ?>
                            <?= Html::tag('p', User::userRole($model->id)) ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
