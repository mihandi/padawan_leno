<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 * @property string $seo_url
 */
class Category extends \yii\db\ActiveRecord
{
    const META_TITLE = 'Необмежені можливості:';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
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
            'seo_url' => 'Seo Url'
        ];
    }

    public static function getLink($category_id, $category_seo_url)
    {
        return "/blog/category/" . $category_seo_url . '-' . $category_id;
    }
}
