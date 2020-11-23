<?php $i=0;
use  \common\models\Article;
/*?>
    <div class="mix col-lg-3 col-md-3 col-sm-5">
        <?php foreach($gallery as $photo): ++$i;?>
                <?php if ($i < 5): ?>
                    <div class="item">
                        <a href="<?= '/elfinder/global/article_'.$article['id'].'/'.$photo?>" data-fancybox="gallery" class="image">
                            <img src="<?= '/elfinder/global/article_'.$article['id'].'/'.$photo?>" alt="..." class="img-fluid">
                        </a>
                    </div>
                <?php else: ?>
                    <a href="<?= '/elfinder/global/article_'.$article['id'].'/'.$photo?>" data-fancybox="gallery" class="image"></a>
                <?php endif;?>
        <?php endforeach; ?>
    </div>
 */?>

<section class="gallery no-padding">
    <div class="row">
        <?php if(isset($gallery) && !empty($gallery)) :?>
            <?php foreach($gallery as $photo): ++$i;?>
                <?php if ($i < 8): ?>
                    <div class="mix col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <div class="item">
                            <a href="<?= Article::getImage($article['id'],$photo); ?>" data-fancybox="gallery" class="image">
                                <img src="<?= Article::getImage($article['id'],$photo,300,300); ?>"  class="img-fluid">

                                <div class="overlay d-flex align-items-center justify-content-center">
                                    <i class="icon-search"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php else:?>
                <div class="mix col-lg-3 col-md-3 col-sm-3" style="display: none">
                    <div class="item">
                        <a href="<?= '/elfinder/global/article_'.$article['id'].'/'.$photo?>" data-fancybox="gallery" class="image">
                            <img src="<?= Yii::getAlias('@backendBaseUrl').'/elfinder/global/article_'.$article['id'].'/'.$photo?>"  class="img-fluid">

                            <div class="overlay d-flex align-items-center justify-content-center">
                                <i class="icon-search"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endif;?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
