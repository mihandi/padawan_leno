<div class="list-widget cates-widget m-b-60">
    <h4 class="lw-title">КАТЕГОРІЇ</h4>
    <ul class="lw-list v-list">
        <?php foreach ($categories as $category):?>
            <li>
                <a href="<?= \common\models\Category::getLink($category['id'],$category['seo_url'])?>"><?= $category['title']?></a>
            </li>
        <?php endforeach; ?>

    </ul>
</div>
