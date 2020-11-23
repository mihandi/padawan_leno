<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\Category;
use common\models\Functions;
use common\models\Gallery;
use yii\web\Controller;

class GalleryController extends Controller
{
    public function actionIndex()
    {
        $categories = Category::find()->all();

        $galleries = Gallery::getGalleries();
        shuffle($galleries);


        return $this->render(
            'index',
            [
                'galleries' => $galleries,
                'categories' => $categories,
                'popular_articles' => Article::getPopular(),
                'months' => Article::getArchive(),
            ]
        );
    }

    public function actionSingle()
    {
        $gallery_id = (int)$_GET['gallery_id'];

//        $this->layout = 'test.php';
        $gallery = Gallery::findOne($gallery_id);
        $photos = Gallery::getImages($gallery);

        return $this->render(
            'single',
            [
                'photos' => $photos,
                'gallery' => $gallery,
                'categories' => Article::getCategories(),
                'popular_articles' => Article::getPopular(),
                'months' => Article::getArchive(),
            ]
        );
    }
}