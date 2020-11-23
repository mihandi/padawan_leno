<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $login;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
//            ['email','email'],
            ['password', 'validatePassword'] //собственная функция для валидации пароля
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function getUser()
    {
        return User::findOne(['email' => $this->login]) ? User::findOne(['email' => $this->login]) : User::findOne(
            ['login' => $this->login]
        );
    }

    public function getAdmin()
    {
        return User::findOne(['email' => $this->login, 'status' => [USER::USER_MODER, USER::USER_ADMIN]])
            ? User::findOne(['email' => $this->login, 'status' => [USER::USER_MODER, USER::USER_ADMIN]])
            : User::findOne(['login' => $this->login, 'status' => [USER::USER_MODER, USER::USER_ADMIN]]);
    }

    public function loginAdmin()
    {
        if ($this->validate() && $this->getAdmin()) {
            return Yii::$app->user->login($this->getAdmin());
        }

        return false;
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        }

        return false;
    }

}
