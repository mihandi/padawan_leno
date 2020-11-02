<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m201102_191146_add_default_users
 */
class m201102_191146_add_default_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $admin = new User();
        $admin->username = 'root';
        $admin->setPassword('root');
        $admin->email = 'root@gmail.com';
        $admin->generateAuthKey();
        $admin->generateEmailVerificationToken();
        $admin->status = User::STATUS_ACTIVE;
        $admin->save();

        for ($i = 0; $i < 20; $i ++) {
            $newUser = new User();
            $newUser->username = 'user_'. $i;
            $newUser->setPassword('root');
            $newUser->email = 'root@gmail.com'. $i;
            $newUser->generateAuthKey();
            $newUser->generateEmailVerificationToken();
            $newUser->status = User::STATUS_ACTIVE;
            $newUser->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201102_191146_add_default_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201102_191146_add_default_users cannot be reverted.\n";

        return false;
    }
    */
}
