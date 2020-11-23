<?php
    use common\models\Article;
?>
<div class="list-widget blog-popular-widget m-b-60">
    <h4 class="lw-title">ПОПУЛЯРНІ СТАТТІ</h4>
    <ul class="blog-sm-list v-list">

        <?php foreach ($popular_articles as $article):?>
            <li class="box-blog-sm">
            <a class="box-image" href="<?= Article::getLink($article['id'],$article['seo_url']) ?>">
                <img src="<?= Article::getMainImage($article,480,480)?>" alt="Популярні статті">
            </a>
            <div class="box-content">
                <h3 class="box-title">
                    <a href="<?= Article::getLink($article['id'],$article['seo_url']) ?>"><?= $article['title']?></a>
                </h3>
                <span class="blog-post-time"><?php $article['created_at']?></span>
            </div>
        </li>
        <?php endforeach;?>
    </ul>
</div>