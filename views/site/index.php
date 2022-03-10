<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'CursedNews - Главная';
?>
<div class="container mt-5">
    <div class="row">
        <!-- Blog entries-->
        <div class="col-lg-8">
            <!-- Nested row for non-featured blog posts-->
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-4">
                        <h1 class="fw-bolder">Популярное</h1>
                    </div>
                    <!-- Blog post-->
                    <?php foreach ($popularArticles as $article) { ?>
                        <div class="card mb-4">
                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>"><img class="card-img-top post-img" src="<?= '../web/uploads/' . $article->image ?>" alt="<?= $article->title ?>" /></a>
                            <div class="card-body">
                                <p class="mb-1"><a class="badge bg-light text-decoration-none link-light" href="#"><?= $article->category->name ?></a>
                                </p>
                                <div class="small text-muted mb-2"><?= Yii::$app->formatter->asDatetime($article->datestamp, 'medium') ?></div>
                                <h2 class="card-title h4"><?= $article->title ?></h2>
                                <div class="w-100 content mb-2">
                                    <p class="card-text post-content mb-0"><?= $article->description ?></p>

                                    <?php $d_none = (mb_strlen($article->description) > 119) ? '' : 'd-none'  ?>
                                    <div class="w-100 smoke <?= $d_none ?>">
                                    </div>
                                </div>
                                <p class="card-text">
                                    <a class="btn btn-primary" href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>">Читать →</a>
                                    <span class="small text-muted float-right text-right"><?= 'Оценка: ' . $article->likes ?> <br> <?= 'Просмотры: ' . $article->views ?></span>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-lg-6">
                    <div class="mb-4">
                        <h1 class="fw-bolder">Свежее</h1>
                    </div>
                    <!-- Blog post-->
                    <?php foreach ($newArticles as $article) { ?>
                        <div class="card mb-4">
                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>"><img class="card-img-top post-img" src="<?= '../web/uploads/' . $article->image ?>" alt="<?= $article->title ?>" /></a>
                            <div class="card-body">
                                <p class="mb-1"><a class="badge bg-light text-decoration-none link-light" href="#"><?= $article->category->name ?></a>
                                </p>
                                <div class="small text-muted mb-2"><?= Yii::$app->formatter->asDatetime($article->datestamp, 'medium') ?></div>
                                <h2 class="card-title h4"><?= $article->title ?></h2>
                                <div class="w-100 content mb-2">
                                    <p class="card-text post-content mb-0"><?= $article->description ?></p>

                                    <?php $d_none = (mb_strlen($article->description) > 119) ? '' : 'd-none'  ?>
                                        <div class="w-100 smoke <?= $d_none ?>">
                                        </div>
                                </div>
                                <p class="card-text">
                                    <a class="btn btn-primary" href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>">Читать →</a>
                                    <span class="small text-muted float-right text-right"><?= 'Оценка: ' . $article->likes ?> <br> <?= 'Просмотры: ' . $article->views ?></span>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- Side widgets-->
        <?= $this->render('sidebar', [
            'paginationCat' => $paginationCat,
            'categories' => $categories,
            'search' => $search,
        ]) ?>
    </div>
</div>
