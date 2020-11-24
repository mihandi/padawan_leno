<?php

namespace common\models;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $password
 * @property string $email
 * @property string $login
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{

    const USER_ADMIN = 10;
    const USER_MODER = 5;
    const USER = 1;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            ['id', 'number'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],

            ['login', 'trim'],
            ['login', 'required'],
            ['login', 'string', 'max' => 100],
            [
                'login',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => 'This login  has already been taken.'
            ],

//
//            ['first_name', 'trim'],
//            ['first_name', 'string', 'max' => 50],
//
//            ['first_name', 'trim'],
//            ['last_name', 'string', 'max' => 50],
        ];
    }

    public function setPassword($password)
    {
        $this->password = addslashes($password);
//        $this->password = sha1($password);
    }

    public function validatePassword($password)
    {
//        return $this->password === sha1($password);
        return $this->password === ($password);
    }

    //=============================================

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getAuthKey()
    {
    }

    public function validateAuthKey($authKey)
    {
    }

    public function saveImage($filename)
    {
        $this->image = $filename;

        return $this->save(false);
    }

    public function getImage()
    {
        $date = date_create();
        return ($this->image) ? Yii::getAlias(
                '@backendBaseUrl'
            ) . '/elfinder/users/user_' . $this->id . '/' . $this->image . '?' . date_timestamp_get(
                $date
            ) : '/no-image.png';
    }

    public static function getAdmins()
    {
        $admins = self::find()->select('id')->where(['status' => [5, 10]])->all();

        foreach ($admins as $admin) {
            $ids[] = $admin->id;
        }

        return $ids;
    }
}
		