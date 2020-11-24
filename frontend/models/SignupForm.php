<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $login;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [
                'email',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => 'This email address has already been taken.'
            ],

            ['login', 'trim'],
            ['login', 'required'],
            ['login', 'string', 'max' => 100],
            [
                'login',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => 'This login  has already been taken.'
            ],

            ['password', 'required'],
            ['password', 'string', 'min' => 4],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        $user = new User();
        $user->login = addslashes($this->login);
        $user->email = addslashes($this->email);
        $user->setPassword($this->password);

        return $user->save() ? $user : null;
    }


}
