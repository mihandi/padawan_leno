<?php

use common\models\Article;
use common\models\Category;
use common\models\User;
use yii\db\Migration;

/**
 * Class m201103_003041_add_category_articles_data
 */
class m201103_003041_add_category_articles_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user_id = 1;
        for ($i = 1; $i < 30; $i ++) {
            $newUser = new User();
            $newUser->username = 'user_' . $i;
            $newUser->setPassword('root');
            $newUser->email = 'root@gmail.com' . $i;
            $newUser->generateAuthKey();
            $newUser->generateEmailVerificationToken();
            $newUser->status = User::STATUS_ACTIVE;
            $newUser->save();

            if (!empty($user_id) && rand(0,1)) {
                $user_id = $newUser->id;
            }

            $newCategory = new Category();
            $newCategory->id = $i;
            $newCategory->name = 'category_' . $i;
            $newCategory->status = Category::STATUS_ACTIVE;
            $newCategory->save();

            $newArticle = new Article();
            $newArticle->title = 'title_'.$i;
            $newArticle->user_id = $user_id;
            $newArticle->description = 'description';
            $newArticle->content = 'Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt, ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.';
            $newArticle->status = Article::STATUS_ACTIVE;
            $newArticle->category_id = rand(1, $i);
            $newArticle->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201103_003041_add_category_articles_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201103_003041_add_Category_articles_data cannot be reverted.\n";

        return false;
    }
    */
}
