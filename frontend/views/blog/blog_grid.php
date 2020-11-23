<?php

/* @var $this yii\web\View */

use common\models\Article;
use yii\grid\GridView;
use yii\widgets\LinkPager;

$this->title = 'Новини';

if(isset($meta_category)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => \common\models\Article::META_TITLE . '. Категорiя:' .$meta_category
]);
}
?>


<main class="page-two-col bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <section class="section-blog-wide-list page-col-one">
                    <div class="blog-wide-list p-t-100 p-b-135">
                        <?php if(!$articles):?>
                        <h4 class="lw-title">Нічого не знайдено. Спробуйте ще.</h4>
                        <?php endif;?>
                        <?php foreach ($articles as $article): ?>
                             <article class="box-blog-wide">
                            <header class="bw-header m-b-30">
                                <h3 class="bw-title">
                                    <a href="<?= Article::getLink($article['id'],$article['seo_url']) ?>"><?= $article['title']?></a>
                                </h3>
                                <ul class="bw-cates h-list">
                                    <li>
                                        <a href="<?= \common\models\Category::getLink($article['category_id'],$article['seo_url'])?>"><?= $article['category']?></a>
                                    </li>
                                </ul>
                            </header>
                            <figure class="bw-image img-radius img-hv-zoomIn">
                                <a href="<?= Article::getLink($article['id'],$article['seo_url']) ?>">
                                    <img class="img-fluid" src="<?= Article::getMainImage($article,1600,718) ?>" alt="<?= $article['title']?>">
                                </a>
                            </figure>
                            <div class="bw-body m-b-30">
                                <p class="bw-text"><?= substr($article['description'],0,600)?></p>
                                <a class="read-more" href="<?= Article::getLink($article['id'],$article['seo_url']) ?>">ПРОДОВЖИТИ ЧИТАННЯ</a>
                            </div>
                            <div class="bw-footer">
                                <ul class="bw-infos h-list">
                                    <li>By
                                        <a href="#"><?= $article['login']?></a>
                                    </li>
                                    <li><?= date('Y-m-d', $article['created_at'])?></li>
                                    <li>
                                        <?= $article['comment_count']?> Коментарів
                                    </li>
                                </ul>
                            </div>
                        </article>
                        <?php endforeach; ?>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination pagination-template d-flex justify-content-center">
                                <?php
                                echo LinkPager::widget([
                                    'pagination' => $pagination,
                                ]);
                                ?>
                            </ul>
                        </nav>
                    </div>
                </section>
            </div>



            <div class="col-lg-3">
                <aside class="page-col-two p-t-100">
                    <?php require_once ('search_bar.php');?>
                    <!-- Widget [Categories Widget]-->
                    <?php require_once ('categories.php');?>
                    <!-- Widget [Latest Posts Widget]        -->
                    <?php require_once ('latest_posts.php');?>

                    <?php require_once ('../views/archive.php');?>

                    <?php require_once ('../views/contacts.php');?>
                </aside>
            </div>
        </div>
    </div>
</main>
