<?php
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
                                <li>
                                    <a href="/gallery/<?= \common\models\Gallery::getLink($gallery['id'],$gallery['seo_url'])?>"><?= $gallery['title']?></a>
                                </li>
                            </ul>
                            <h3 class="post-title"><?= $gallery['title']?></h3>
                        </header>
                        <div class="container">
                            <div class="row">
                                <?php foreach ($photos as $photo): ?>

                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                                        <article class="box-primary box-blog">
                                            <figure class="box-figure">
                                                <a href="<?= Yii::getAlias('@backendBaseUrl').'/elfinder/global/gallery/'.$gallery['dir_name'].'/'.$photo?>" data-fancybox="gallery" class="image">
                                                    <img class="box-image blog-image" src="<?= Yii::getAlias('@backendBaseUrl').'/timthumb.php?src=/elfinder/global/gallery/'.$gallery['dir_name'].'/'.$photo.'&w=274&h=275'?>" alt="MOBILE FIRST &amp; RESPONSIVE"  />
                                                </a>
                                            </figure>
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