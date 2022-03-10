<?php

/* @var $this yii\web\View */

use yii\bootstrap4\LinkPager;
use yii\bootstrap4\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'CursedNews - ' . 'Результаты поиска';
?>
<div class="container mt-5">
    <div class="row">
        <!-- Blog entries-->
        <div class="col-lg-8">
            <!-- Featured blog post-->
            <div class="mb-4">
                <h1 class="fw-bolder"><?= 'Результаты поиска' ?></h1>
                <h4><?= 'по запросу "' . $searchLine . '"'?></h4>
            </div>
            <?php
            if (!empty($articles)) {
                foreach ($articles as $article) { ?>
                    <div class="card mb-4">
                        <a href="#"><img class="card-img-top" src="<?= '../web/uploads/' . $article->image ?>" alt="<?= $article->title ?>"/></a>
                        <div class="card-body">
                            <div class="small text-muted mb-2"><?= Yii::$app->formatter->asDatetime($article->datestamp, 'medium') ?></div>
                            <h2 class="card-title"><?= $article->title ?></h2>
                            <p class="card-text"><?= $article->description ?></p>
                            <a class="btn btn-primary" href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>">Читать →</a>
                        </div>
                    </div>
                <?php }
            } else {
                echo Html::tag('a', 'Новостей не найдено. Попробуйте найти что-нибудь еще...');
            } ?>
            </div>
        <!-- Side widgets-->
        <?= $this->render('sidebar', [
            'paginationCat' => $paginationCat,
            'categories' => $categories,
            'search' => $search,
        ]) ?>
    </div>
</div>
