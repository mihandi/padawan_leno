<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Image".
 *
 * @property int $id
 * @property int $gallery_id
 * @property string $name
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['gallery_id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gallery_id' => 'Gallery ID',
            'name' => 'Name',
        ];
    }
}
