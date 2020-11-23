<?php
use common\models\Gallery;
use yii\widgets\LinkPager;
/*
<main class="page-two-col bg-white">
    <section class="section-blog-md-list p-t-105 p-b-130">
        <div class="container">
            <div class="row">
                <?php foreach ($galleries as $gallery): ?>

                <div class="col-lg-3 col-md-4">
                    <article class="box-primary box-blog">
                        <figure class="box-figure">
                            <a href="<?= Gallery::getLink($gallery['id'],$gallery['seo_url'])?>">
                                <img class="box-image blog-image" src="<?= Gallery::getMainImage($gallery);?>" alt="MOBILE FIRST &amp; RESPONSIVE" />
                            </a>
                        </figure>
                        <header class="box-header">
                            <h3 class="box-title blog-title">
                                <a href="<?= Gallery::getLink($gallery['id'],$gallery['seo_url'])?>"><?= $gallery['title'] ?></a>
                            </h3>
                        </header>

                    </article>
                </div>

                <?php endforeach;?>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination pagination-template d-flex justify-content-center">
                    <?php

//                    echo LinkPager::widget([
//                        'pagination' => $pagination,
//                    ]);
                    ?>
                </ul>
            </nav>
        </div>
    </section>
</main>
*/
?>
<main class="page-two-col bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="page-col-one p-t-35 p-b-60">
                    <article class="post-blog m-b-55">
                        <header class="post-header m-b-125">
                            <ul class="post-bre h-list">
                                <li>
                                    <a href="/">Головна</a>
                                </li>
                                <li>
                                    <a href="/gallery">Галерея</a>
                                </li>
                            </ul>
                            <h3 class="post-title"><?= 'Галерея'?></h3>
                        </header>
                        <div class="container">
                            <div class="row">
                                <?php foreach ($galleries as $gallery): ?>

                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                                        <article class="box-primary box-blog">
                                            <figure class="box-figure">
                                                <a href="<?= Gallery::getLink($gallery['id'],$gallery['seo_url'])?>">
                                                    <img class="box-image blog-image" src="<?= Gallery::getMainImage($gallery);?>" alt="MOBILE FIRST &amp; RESPONSIVE" />
                                                </a>
                                            </figure>
                                            <header class="box-header">
                                                <h3 class="box-title blog-title">
                                                    <a href="<?= Gallery::getLink($gallery['id'],$gallery['seo_url'])?>"><?= $gallery['title'] ?></a>
                                                </h3>
                                            </header>

                                        </article>
                                    </div>

                                <?php endforeach;?>
                            </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination pagination-template d-flex justify-content-center">
                                <?php

                                //                    echo LinkPager::widget([
                                //                        'pagination' => $pagination,
                                //                    ]);
                                ?>
                            </ul>
                        </nav>
                    </div>
                    </article>
                </div>
            </div>


            <div class="col-lg-3">
                <aside class="page-col-two p-t-100">
                    <?php require_once ('../views/blog/search_bar.php');?>
<!--                     Widget [Categories Widget]-->
                    <?php require_once ('../views/blog/categories.php');?>
                    <!-- Widget [Latest Posts Widget]        -->
                    <?php require_once ('../views/blog/latest_posts.php');?>

                    <?php require_once ('../views/archive.php');?>

                    <?php require_once ('../views/contacts.php');?>
                </aside>
            </div>
        </div>
    </div>
</main>