<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\Category;
use common\models\Functions;
use yii\web\Controller;
use yii\db\Query;
use Yii;

class SitemapController extends Controller
{

    public function actionIndex()
    {
        if (!$xml_sitemap = Yii::$app->cache->get('sitemap')) {  // проверяем есть ли закэшированная версия sitemap
            $urls = array();

            // Выбираем категории сайта
            $categories = Category::find()->all();
            foreach ($categories as $category) {
                $urls[] = array(
                    Yii::$app->urlManager->createUrl(['/blog/category/' . $category->seo_url . '-' . $category->id])
                    // создаем ссылки на выбранные категории
                ,
                    'daily'
                    // вероятная частота изменения категории
                );
            }

            $articles = Article::find()->all();
            foreach ($articles as $article) {
                $urls[] = array(
                    Yii::$app->urlManager->createUrl(['/blog/article/' . $article->seo_url . '-' . $article->id])
                ,
                    'daily'
                );
            }

            $xml_sitemap = $this->renderPartial(
                'index',
                array( // записываем view на переменную для последующего кэширования
                    'host' => Yii::$app->request->hostInfo,         // текущий домен сайта
                    'urls' => $urls,                                // с генерированные ссылки для sitemap
                )
            );
            Yii::$app->cache->set(
                'sitemap',
                $xml_sitemap,
                3600 * 12
            ); // кэшируем результат, чтобы не нагружать сервер и не выполнять код при каждом запросе карты сайта.
        }
        header('Content-Type: application/xml'); // тоже самое, формат отдачи контента

//        Yii::$app->response->format = \yii\web\Response::FORMAT_XML; // устанавливаем формат отдачи контента
        echo $xml_sitemap;
        exit;
    }
}