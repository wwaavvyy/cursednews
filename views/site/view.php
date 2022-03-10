<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'CursedNews - ' . $article->title;
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Post content-->
            <article>
                <!-- Post header-->
                <header class="mb-4">
                    <!-- Post title-->
                    <h1 class="fw-bolder mb-1"><?= $article->title ?></h1>
                    <!-- Post meta content-->
                    <div class="text-muted fst-italic mb-2">Опубликовано <?= Yii::$app->formatter->asDatetime($article->datestamp, 'medium') ?></div>
                    <!-- Post categories-->
                    <a class="badge bg-light text-decoration-none link-light" href="<?= Url::toRoute(['site/category', 'id' => $article->category_id]) ?>"><?= $article->category->name ?></a>
                </header>
                <!-- Preview image figure-->
                <figure class="mb-4"><img class="img-fluid rounded" src="<?= '../web/uploads/' . $article->image ?>" alt="<?= $article->title ?>" /></figure>
                <!-- Post content-->
                <section class="mb-4">
                    <p class="mb-4"> <?= $article->content ?> </p>
                    <?php if (!empty($selectedTags)) {
                        foreach ($selectedTags as $tag) { ?>
                        <a class="badge badge-secondary"><?= '#' . $tag->name ?></a>
                    <?php }
                    } ?>
                    <div class="d-flex justify-content-end">
                        <span class="small text-muted text-right"><?= 'Оценка: ' . $article->likes ?> <br> <?= 'Просмотры: ' . $article->views ?></span>
                    </div>
                </section>
            </article>
            <!-- Comments section-->
            <section class="mb-5">
                <div class="card bg-light mb-0">
                    <div class="card-body">
                        <h4>Комментарии</h4>
                        <!-- Comment form-->
                        <?php
                        if (Yii::$app->user->isGuest) {
                            echo 'Чтобы оставить комментарий, пожалуйста, авторизуйтесь!';
                        } else {
                            $form = ActiveForm::begin([
                                'id' => 'form-comment',
                                'options' => ['class' => 'mt-3'],
                                'action' => ['site/comment', 'id' => $article->id],
                            ]); ?>

                            <?= $form->field($commentForm, 'content')->textarea(['row' => 6, 'class' => 'form-control', 'placeholder' => 'Напишите, что вы думаете...'])->label(false) ?>

                            <div class="form-group mb-0">
                                <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
                            </div>

                            <?php ActiveForm::end();
                        }
                        ?>
                        <!-- Comment with nested comments-->
                        <?php if (!empty($comments)) {
                            foreach ($comments as $comment) { ?>
                                <div class="d-flex mt-4">
                                    <!-- Parent comment-->
                                    <div class="flex-shrink-0">
                                        <?= HTML::a(Html::img('../web/uploads/' . $comment->user->photo, ['class' => 'rounded-circle comment-avatar', 'alt' => $comment->user->username . 'photo']), ['user/view', 'id' => $comment->user_id]) ?>
                                    </div>
                                    <div class="ml-3 w-100">
                                        <div class="font-weight-bold"><?= Html::a($comment->user->username, ['user/view', 'id' => $comment->user_id]) ?><?php
                                            if ($comment->user_id == Yii::$app->user->identity->id) { ?>
                                                <?= Html::a('Удалить', ['site/comment-delete', 'id' => $comment->id], ['class' => 'float-right']); ?>
                                            <?php } ?></div>
                                        <div>
                                            <span class="small text-muted text-right"><?= Yii::$app->formatter->asDatetime($comment->datestamp, 'short') ?></span>
                                        </div>
                                        <?= $comment->content ?>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </section>
        </div>
        <?= $this->render('sidebar', [
            'paginationCat' => $paginationCat,
            'categories' => $categories,
            'search' => $search,
        ]) ?>
    </div>
</div>
