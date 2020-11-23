<?php

namespace common\models;

use SplFileInfo;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\data\SqlDataProvider;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $image
 * @property int $viewed
 * @property int $user_id
 * @property int $status
 * @property int $category_id
 * @property int $created_at
 * @property int $updated_at
 * @property string $seo_url
 *
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    public $images;

    const PAGE_SIZE = 4;

    const META_TITLE = 'Необмежені можливості';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'content', 'user_id', 'seo_url', 'image'], 'required'],
            [['title', 'description', 'content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'number']
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'seo_url' => 'Seo Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */


    public function saveImage($filename)
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public static function getMainImage($article, $w = 500, $h = 500, $wm = true)
    {
        $get = '&w=' . $w . '&h=' . $h . ($wm ? '&wm=1' : '');
        return Yii::getAlias('@backendBaseUrl') . (($article['image'] && file_exists(
                    Yii::getAlias(
                        '@backend'
                    ) . '/web/elfinder/global/article_' . $article['id'] . '/' . $article['image']
                ))
                ? '/timthumb.php?src=/elfinder/global/article_' . $article['id'] . '/' . $article['image'] . $get
                : '/timthumb.php?src=/elfinder/no-image.png' . $get);
    }

    public static function getImage($article_id, $image_name, $w = null, $h = null, $wm = true)
    {
        if (isset($w, $h)) {
            $get = '&w=' . $w . '&h=' . $h . ($wm ? '&wm=1' : '');
        } else {
            if (file_exists(
                Yii::getAlias('@backend') . '/web/elfinder/global/article_' . $article_id . '/' . $image_name
            )) {
                $size = getimagesize(
                    Yii::getAlias('@backend') . '/web/elfinder/global/article_' . $article_id . '/' . $image_name
                );
                $get = '&w=' . $size[0] . '&h=' . $size[1] . ($wm ? '&wm=1' : '');
            } else {
                $get = '';
            }
        }
        return Yii::getAlias(
                '@backendBaseUrl'
            ) . '/timthumb.php?src=/elfinder/global/article_' . $article_id . '/' . $image_name . $get;
    }

    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->scenario = ImageUpload::ARTICLE_UPLOAD_SCENARIO;
        $imageUploadModel->deleteCurrentImage($this->image, $this->id);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public static function getCategories()
    {
        $res = array();
        $categories = Yii::$app->db->createCommand(
            'SELECT * FROM category Limit 4'
        )
            ->queryAll();

        foreach ($categories as $category) {
            $category['count'] = Article::find()->where(['category_id' => $category['id']])->count();
            $res[] = $category;
        }

        return $res;
    }

    public function saveCategory($category_id)
    {
        $category = Category::findOne($category_id);
        if ($category != null) {
            $this->link('category', $category);
            return true;
        }
    }


    //FRONTEND

    public static function getArticles($page_size = 4)
    {
        $count = Yii::$app->db->createCommand(
            'SELECT COUNT(a.id) as count
                  FROM article a 
                  INNER JOIN category c On a.category_id = c.id 
                  INNER JOIN user u On u.id = a.user_id 
                  Left Join comment cm On cm.article_id = a.id'
        )
            ->queryOne();

        $article['pagination'] = new Pagination(['totalCount' => $count['count'], 'pageSize' => $page_size]);

        $article['article'] = Yii::$app->db->createCommand(
            'SELECT u.login,a.id,a.title,a.image,a.description,a.created_at,a.seo_url,c.id as \'category_id\',c.title as \'category\',COUNT(cm.id) as \'comment_count\'
                  FROM article a 
                  INNER JOIN category c On a.category_id = c.id 
                  INNER JOIN user u On u.id = a.user_id 
                  Left Join comment cm On cm.article_id = a.id
                  GROUP BY a.id LIMIT :offset, :limit'
        )
            ->bindValue('offset', $article['pagination']->offset)
            ->bindValue('limit', $article['pagination']->limit)
            ->queryAll();

        return $article;
    }

    public static function getPrevNext($article)
    {
        $res['prev'] = Yii::$app->db->createCommand(
            "SELECT id,title FROM article WHERE created_at <:time
            ORDER BY created_at DESC LIMIT 1"
        )
            ->bindValue('time', $article['created_at'])
            ->queryOne();

        $res['next'] = Yii::$app->db->createCommand(
            "SELECT id,title FROM article WHERE created_at >:time
            ORDER BY created_at ASC LIMIT 1"
        )
            ->bindValue('time', $article['created_at'])
            ->queryOne();

        return $res;
    }

    public static function getSingle($article_id)
    {
        $article['article'] = Yii::$app->db->createCommand(
            'SELECT a.id,u.login,a.title,a.content,a.image,a.description,a.viewed,a.seo_url,a.created_at,u.id as \'user_id\',c.id as \'category_id\',
                  c.title as \'category\',COUNT(cm.id) as \'comment_count\' FROM article a 
                  INNER JOIN category c On a.category_id = c.id 
                  INNER JOIN user u On u.id = a.user_id
                  Left Join comment cm On cm.article_id = a.id
                  WHERE a.id=:article_id
                  GROUP BY a.id'
        )
            ->bindValue('article_id', $article_id)
            ->queryOne();

        if (!$article['article']) {
            return false;
        }
        $article['np'] = Article::getPrevNext($article['article']);

        $articleObj = new Article();
        $article['comments'] = $articleObj->getArticleComments($article_id);

        return $article;
    }

    public static function getArticlesByCategories($category_id)
    {
        $count = Yii::$app->db->createCommand(
            'SELECT COUNT(id) as count FROM article 
                  WHERE category_id=:category_id'
        )
            ->bindValue('category_id', $category_id)
            ->queryOne();

        $article['pagination'] = new Pagination(['totalCount' => $count['count'], 'pageSize' => 4]);

        $article['article'] = Yii::$app->db->createCommand(
            'SELECT a.id,u.login,a.title,a.image,a.description,a.created_at,a.seo_url,c.id as \'category_id\',
                  c.title as \'category\',COUNT(cm.id) as \'comment_count\' FROM article a 
                  INNER JOIN category c On a.category_id = c.id 
                  INNER JOIN user u On u.id = a.user_id
                  Left Join comment cm On cm.article_id = a.id
                  WHERE a.category_id=:category_id
                  GROUP BY a.id LIMIT :offset, :limit'
        )
            ->bindValue('category_id', $category_id)
            ->bindValue('offset', $article['pagination']->offset)
            ->bindValue('limit', $article['pagination']->limit)
            ->queryAll();

        return $article;
    }

    public static function getPopular($limit = 3)
    {
        return Yii::$app->db->createCommand(
            'SELECT count(cm.id) as \'comments_count\',a.id,a.image,a.title,a.viewed,a.description,a.created_at,u.login,a.seo_url, c.id as \'category_id\',c.title as \'category_title\' FROM article a
                  Inner join user u On u.id = a.user_id
                  left join comment cm On cm.article_id = a.id 
                  Left Join category c On c.id = a.category_id
                  Where a.image is not NULL   
                  GROUP BY a.id
                  ORDER BY a.viewed DESC Limit  :limit'
        )
            ->bindValue('limit', $limit)
            ->queryAll();
    }

    public static function getRecent($limit = 4)
    {
        return Yii::$app->db->createCommand(
            'SELECT count(cm.id) as \'comments_count\',a.id,a.image,a.title,a.viewed,a.seo_url,a.description FROM article a
                  LEFT join comment cm On cm.article_id = a.id 
                  GROUP By a.id
                  ORDER BY a.created_at DESC Limit :limit'
        )
            ->bindValue('limit', $limit)
            ->queryAll();
    }

    public static function getGallery()
    {
        $result = [];
        $id = (int)Yii::$app->request->get('article_id');
        $dir = Yii::getAlias('@backend') . '/web/elfinder/global/article_' . $id;

        if (file_exists($dir)) {
            $files1 = scandir($dir);

            foreach ($files1 as $value) {
                if (!in_array($value, array(".", ".."))
                    && !is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $info = new SplFileInfo($value);
                    if (in_array($info->getExtension(), array("jpg", "png", "jpeg"))) {
                        $result[] = $value;
                    }
                }
            }

            return $result;
        }
    }

    public function getArticleComments($id)
    {
        $result['count'] = Comment::find()->where(['article_id' => $id])->count();
        $pagination = new Pagination(['totalCount' => $result['count'], 'pageSize' => 6]);

        $comments['comments'] = Yii::$app->db->createCommand(
            'SELECT c.user_id,c.id,c.text,c.created_at,c.user_id,u.login,u.created_at as "user_created_at" FROM `comment` c
                Inner join user as u On c.user_id = u.id
                where c.article_id =:article_id and ISNULL(c.parent_id)
                LIMIT :offset, :limit'
        )
            ->bindValue('article_id', $id)
            ->bindValue('offset', $pagination->offset)
            ->bindValue('limit', $pagination->limit)
            ->queryAll();

        foreach ($comments['comments'] as $comment) {
            $comment['answers'] = Yii::$app->db->createCommand(
                'SELECT c.parent_id,c.id,c.user_id,c.text,c.created_at,c.user_id,u.login,u.created_at as "user_created_at" FROM `comment` c
                Inner join user as u On c.user_id = u.id
                where c.article_id =:article_id and c.parent_id=:parent_id'
            )
                ->bindValue('article_id', $id)
                ->bindValue('parent_id', $comment['id'])
                ->queryAll();
            $result['comments'][] = $comment;
        }

        $result['pagination'] = $pagination;

        return $result;
    }

    public static function getAuthor($user_id)
    {
        return Yii::$app->db->createCommand(
            'SELECT login from user where id =:user_id'
        )
            ->bindValue('user_id', $user_id)
            ->queryOne();
    }

    public static function viewedCounter($article_id, $viewed)
    {
        return $comments['comments'] = Yii::$app->db->createCommand(
            'UPDATE article
                      SET viewed=:viewed
                      WHERE id=:article_id'
        )
            ->bindValue('viewed', $viewed + 1)
            ->bindValue('article_id', $article_id)
            ->execute();
    }

    public static function searchFr()
    {
        $search_line = yii::$app->request->get('search');

        $articles = Yii::$app->db->createCommand(
            'SELECT u.login,a.id,a.seo_url FROM article a
                  INNER JOIN category c On a.category_id = c.id
                  Inner join user u On u.id = a.user_id
                  Left Join comment cm On cm.article_id = a.id
                  WHERE a.title LIKE :search
                  OR a.description LIKE :search OR a.content LIKE :search
                  OR c.title LIKE :search
                  GROUP BY a.id'
        )
            ->bindValue('search', '%' . $search_line . '%');

        $count = $articles->query()->count();
        $result['pagination'] = new Pagination(['totalCount' => $count, 'pageSize' => 2]);

        $result['articles'] = Yii::$app->db->createCommand(
            'SELECT u.login,a.id,a.title,a.image,a.seo_url,a.description,a.created_at,c.id as \'category_id\',c.title as \'category\',COUNT(cm.id) as \'comment_count\' FROM article a
                  INNER JOIN category c On a.category_id = c.id
                  Inner join user u On u.id = a.user_id
                  Left Join comment cm On cm.article_id = a.id
                  WHERE a.title LIKE :search
                  OR a.description LIKE :search OR a.content LIKE :search
                  OR c.title LIKE :search
                  GROUP BY a.id LIMIT :offset, :limit'
        )
            ->bindValue('search', '%' . $search_line . '%')
            ->bindValue('offset', $result['pagination']->offset)
            ->bindValue('limit', $result['pagination']->limit)
            ->queryAll();

        return $result;
    }

    public static function getArchive()
    {
        return Yii::$app->db->createCommand(
            "SELECT month(FROM_UNIXTIME(created_at,\"%Y-%m-%d\")) as month,COUNT(id) as count
                    FROM `article` 
                     WHERE month(FROM_UNIXTIME(created_at,\"%Y-%m-%d\"))  in (1,2,3,4,5,6,7,8,9,10,11,12)
                     AND YEAR(FROM_UNIXTIME(created_at,\"%Y-%m-%d\")) in (2018,1970)
                     GROUP by month
                     ORDER by month Desc
            "
        )->queryAll();
    }

    public static function getArticlesByMonthYear($month, $year)
    {
        $count = Yii::$app->db->createCommand(
            'SELECT COUNT(id) as count FROM article
                     WHERE month(FROM_UNIXTIME(created_at,"%Y-%m-%d"))=:month_number
                     AND YEAR(FROM_UNIXTIME(created_at,"%Y-%m-%d")) =:year_number
                     GROUP by id'
        )
            ->bindValue('month_number', $month)
            ->bindValue('year_number', $year)
            ->queryOne();

        $article['pagination'] = new Pagination(['totalCount' => $count['count'], 'pageSize' => Article::PAGE_SIZE]);

        $article['articles'] = Yii::$app->db->createCommand(
            "SELECT month(FROM_UNIXTIME(a.created_at,\"%Y-%m-%d\")) as month,COUNT(a.id) as count,
                            u.login,a.id,a.title,a.image,a.description,a.created_at,a.seo_url,c.id as 'category_id',
                            c.title as 'category',COUNT(cm.id) as 'comment_count' 
                  FROM article a
                  INNER JOIN category c On a.category_id = c.id
                  Inner join user u On u.id = a.user_id
                  Left Join comment cm On cm.article_id = a.id
                     WHERE month(FROM_UNIXTIME(a.created_at,\"%Y-%m-%d\")) =:month_number
                     AND YEAR(FROM_UNIXTIME(a.created_at,\"%Y-%m-%d\")) =:year_number
                     GROUP by id LIMIT :offset, :limit"
        )
            ->bindValue('month_number', $month)
            ->bindValue('year_number', $year)
            ->bindValue('offset', $article['pagination']->offset)
            ->bindValue('limit', $article['pagination']->limit)
            ->queryAll();

        return $article;
    }

    public static function getLink($article_id, $article_seo_url)
    {
        return "/blog/article/" . $article_seo_url . '-' . $article_id;
    }

    public function uploadImages()
    {
        $imageUpload = new ImageUpload();
        $imageUpload->scenario = ImageUpload::ARTICLE_UPLOAD_SCENARIO;

        $imageUpload->image = $this->image;
        $imageUpload->saveImage($this->id, true);

        foreach ($this->images as $file) {
            $imageUpload->image = $file;
            $imageUpload->saveImage($this->id);
        }
        return true;
    }

}