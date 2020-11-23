<?php

use yii\db\Migration;

/**
 * Class m201123_180718_add_gallery_table
 */
class m201123_180718_add_gallery_table extends Migration
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
                'title' => $this->string(),
                'category_id' => $this->integer(),
                'article_id' => $this->integer()->null(),
                'seo_url' => $this->string(),
                'dir_name' => $this->string(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('gallery');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201123_180718_add_gallery_table cannot be reverted.\n";

        return false;
    }
    */
}
