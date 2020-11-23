<?php

use yii\db\Migration;

/**
 * Class m201122_073625_add_default_data
 */
class m201122_073625_add_default_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'article',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
                'gallery_id' => $this->integer()->null(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201122_073625_add_default_data cannot be reverted.\n";

        return false;
    }
    */
}
