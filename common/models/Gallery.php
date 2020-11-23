<?php

namespace common\models;

use SplFileInfo;
use Yii;

/**
 * This is the model class for table "Gallery".
 *
 * @property int $id
 * @property string $title
 * @property int $category_id
 * @property int $article_id
 * @property string $seo_url
 * @property string $dir_name
 */
class Gallery extends \yii\db\ActiveRecord
{
    public $old_dir_name;
    public $images;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category_id', 'seo_url'], 'required'],
            [['title', 'seo_url', 'dir_name'], 'string'],
            [['category_id', 'article_id'], 'integer'],
            [['old_dir_name'], 'safe'],
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
            'category_id' => 'Category ID',
            'article_id' => 'Article ID',
            'seo_url' => 'Seo Url',
            'dir_name' => 'Direcory Name'
        ];
    }

    public function createFolder($gallery_title)
    {
        Functions::pretty_var_dump('createFolder');
        die();
        $path_to_folder = Yii::getAlias('@backend') . '/web/elfinder/gallery/' . $gallery_title;
        if (!is_dir($path_to_folder)) {
            if (mkdir($path_to_folder)) {
                chmod("$path_to_folder", 0777);
                mkdir($path_to_folder . '/main');
                chmod("$path_to_folder" . '/main', 0777);
            }
        }
    }

    public function updateFolder($old_gallery_title, $new_gallery_title)
    {
        $path_to_folder = Yii::getAlias('@backend') . '/web/elfinder/gallery/';

        return rename($path_to_folder . $old_gallery_title, $path_to_folder . $new_gallery_title);
    }

    public static function removeDirectory($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object)) {
                        self::removeDirectory($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }

    public static function getGalleries()
    {
        return Yii::$app->db->createCommand(
            'SELECT ga.*,c.seo_url as category_seo_url
                  FROM gallery ga 
                  INNER JOIN category c On ga.category_id =c.id 
                  GROUP BY ga.id'
        )
            ->queryAll();
    }

//    public static function getMainImage($dir_name)
//    {
//        $path_to_img = Yii::getAlias( '@backend' ).'/web/elfinder/global/gallery/'.$dir_name."/main";
//        $files1 = scandir($path_to_img);
//
//        foreach ($files1 as $value) {
//            if (!in_array($value, array(".", ".."))
//                && !is_dir($path_to_img . DIRECTORY_SEPARATOR . $value)) {
//                $info = new SplFileInfo($value);
//                if (in_array($info->getExtension(), array("jpg", "png","jpeg"))) {
//
//                    $result[] = $value;
//                }
//            }
//        }
//        if(isset($result) && isset($result[0])){
//            return '/admin/elfinder/global/gallery/'.$dir_name.'/main/'.$result[0];
//        }
//    }

    public static function getImages($gallery)
    {
        $images = Image::findAll(['gallery_id' => $gallery['id']]);


        foreach ($images as $photo) {
            $photos[] = $photo['name'];
        }
//        $path_to_img = Yii::getAlias( '@backend' ).'/web/elfinder/global/gallery/'.$dir_name."/";
//        $files1 = scandir($path_to_img);
//
//        foreach ($files1 as $value) {
//            if (!in_array($value, array(".", ".."))
//                && !is_dir($path_to_img . DIRECTORY_SEPARATOR . $value)) {
//                $info = new SplFileInfo($value);
//                if (in_array($info->getExtension(), array("jpg", "png","jpeg"))) {
//
//                    $result[] = $value;
//                }
//            }
//        }

        return $photos;
    }

    public static function getMainImage($gallery, $w = 500, $h = 500)
    {
        $get = 'w=' . $w . '&h=' . $h;
        return (file_exists(
            Yii::getAlias('@backend') . '/web/elfinder/gallery/' . $gallery['dir_name'] . '/main/main.jpg'
        ))
            ? '/admin/timthumb.php?src=/elfinder/gallery/' . $gallery['dir_name'] . '/main/main.jpg&' . $get
            : '/admin/timthumb.php?src=/elfinder/no-image.png&' . $get;
    }

    public static function getImage($gallery, $image, $w = 500, $h = 500, $wm = true)
    {
        $get = 'w=' . $w . '&h=' . $h . ($wm ? '&wm=1' : '');
//        Functions::pretty_var_dump(file_exists(Yii::getAlias( '@backend' ).'/web/elfinder/gallery/'.$gallery['dir_name'].$image));
//        Functions::pretty_var_dump($gallery['dir_name']);
//        Functions::pretty_var_dump($image);die();
        return (file_exists(Yii::getAlias('@backend') . '/web/elfinder/gallery/' . $gallery['dir_name'] . '/' . $image))
            ? '/admin/timthumb.php?src=/elfinder/gallery/' . $gallery['dir_name'] . '/' . $image . '&' . $get
            : '/admin/timthumb.php?src=/elfinder/no-image.png&' . $get;
    }

    public static function getLink($gallery_id, $gallery_seo_url)
    {
        return "/gallery/single/" . $gallery_seo_url . '-' . $gallery_id;
    }

    public function uploadImages()
    {
        $imageUpload = new ImageUpload();
        $imageUpload->scenario = ImageUpload::GALLERY_UPLOAD_SCENARIO;
        foreach ($this->images as $file) {
            $imageUpload->image = $file;
            $imageUpload->saveImage($this->id);
        }
        return true;
    }
}
