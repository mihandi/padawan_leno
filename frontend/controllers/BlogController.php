<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\Category;
use common\models\Comment;
use common\models\Functions;
use Yii;

use yii\db\Exception;
use yii\web\Controller;


/**
 * Site controller
 */
class BlogController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $data = Article::getArticles();

        return $this->render(
            'blog_grid',
            [
                'pagination' => $data['pagination'],
                'articles' => $data['article'],
                'popular_articles' => Article::getPopular(),
                'categories' => Article::getCategories(),
                'months' => Article::getArchive()
            ]
        );
    }

    public function actionArticle()
    {
        $article_id = (int)$_GET['article_id'];

        if (Yii::$app->request->isAjax) {
            if (Yii::$app->user->isGuest) {
                return $this->goBack();
            }
            if (Yii::$app->request->get('comment')) {
                $id = yii::$app->request->get('comment');
                $comment = Comment::findOne($id);
                if ($comment->user_id != Yii::$app->user->id) {
                    return $this->goBack();
                }
                Comment::deleteComment($id);

                $data = Article::getSingle($article_id);

                return $this->renderAjax(
                    '/blog/comments',
                    [
                        'article' => $data['article'],
                        'comments' => $data['comments']
                    ]
                );
            } else {
                $commentPost = new Comment();
                if ($commentPost->load(Yii::$app->request->post()) && $commentPost->validate()) {
                    $commentPost->save();
                } else {
                    var_dump($commentPost->errors);
                    die();
                }
                $data = Article::getSingle($article_id);

                return $this->renderAjax(
                    '/blog/comments',
                    [
                        'article' => $data['article'],
                        'comments' => $data['comments'],
                        'commentPost' => $commentPost,
                    ]
                );
            }
        }

        $data = Article::getSingle($article_id);
        if (empty($data)) {
            $this->set404();
        }
        Article::viewedCounter($data['article']['id'], $data['article']['viewed']);

        return $this->render(
            'blog_single',
            [
                'article' => $data['article'],
                'nextprev' => $data['np'],
                'categories' => Article::getCategories(),
                'comments' => $data['comments'],
                'popular_articles' => Article::getPopular(),
                'gallery' => Article::getGallery(),
                'months' => Article::getArchive(),
            ]
        );
    }

    public function actionCategory()
    {
        if ($category_id = yii::$app->request->get('category_id')) {
            $data = Article::getArticlesByCategories($category_id);

            if (!empty($data['article'])) {
                return $this->render(
                    'blog_grid',
                    [
                        'pagination' => $data['pagination'],
                        'articles' => $data['article'],
                        'popular_articles' => Article::getPopular(),
                        'categories' => Article::getCategories(),
                        'months' => Article::getArchive(),
                        'meta_category' => Category::findOne(['id' => $category_id])->title
                    ]
                );
            } else {
                $this->set404();
            }
        } else {
            $this->set404();
        }
    }

    public function actionSearch()
    {
        $search_result = Article::searchFr();

        return $this->render(
            'blog_grid',
            [
                'pagination' => $search_result['pagination'],
                'articles' => $search_result['articles'],
                'popular_articles' => Article::getPopular(),
                'categories' => Article::getCategories(),
                'months' => Article::getArchive()

            ]
        );
    }

    public function actionArchive($month)
    {
        $year = 2018;
        $search_result = Article::getArticlesByMonthYear($month, $year);

        return $this->render(
            'blog_grid',
            [
                'pagination' => $search_result['pagination'],
                'articles' => $search_result['articles'],
                'popular_articles' => Article::getPopular(),
                'categories' => Article::getCategories(),
                'months' => Article::getArchive()

            ]
        );
    }


    private function set404()
    {
        $this->redirect('/site/error');
    }
}
