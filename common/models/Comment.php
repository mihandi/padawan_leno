<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $article_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Article $article
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string', 'max' => 1000],
            [
                ['article_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Article::className(),
                'targetAttribute' => ['article_id' => 'id']
            ],
            ['parent_id', 'number'],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_id' => 'id']
            ],
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
            'text' => 'Text',
            'user_id' => 'User ID',
            'article_id' => 'Article ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function deleteArticleComments($article_id)
    {
        return Yii::$app->db->createCommand(
            'delete  FROM `comment` 
                where article_id = :article_id'
        )
            ->bindValue('article_id', $article_id)
            ->execute();
    }

    public static function deleteComment($comment_id)
    {
        return Yii::$app->db->createCommand(
            'delete  FROM `comment` 
                where id = :comment_id or parent_id = :comment_id'
        )
            ->bindValue('comment_id', $comment_id)
            ->execute();
    }
}
