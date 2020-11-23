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
    public $first_name;
    public $last_name;


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


            ['first_name', 'trim'],
//            ['first_name', 'required'],
            ['first_name', 'string', 'max' => 50],

            ['last_name', 'trim'],
//            ['last_name', 'required'],
            ['last_name', 'string', 'max' => 50],

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
        $user->first_name = addslashes($this->first_name);
        $user->last_name = addslashes($this->last_name);
        $user->setPassword($this->password);

        return $user->save() ? $user : null;
    }


}
