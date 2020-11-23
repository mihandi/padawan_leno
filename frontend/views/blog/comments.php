<?php
use common\models\User;
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<div id="comments">
<div class="comment-pane m-b-45">
    <div class="comment-pane-header">
        <h3 class="comment-pane-title"><?= $comments['count']?> Коментарів</h3>
    </div>
    <div class="comment-pane-body">
        <ul class="comment-pane-list">
            <?php if (isset($comments['comments']))foreach ($comments['comments'] as $comment):?>
                <?php
                $user = User::findOne($comment['user_id']);
                $user_image_path = $user->getImage();
                ?>
                <li class="list-item has-comment-children">
                <div class="comment-item">

                    <div class="comment-author-avatar">
                        <a href="<?= ''?>">
                            <img src="<?= $user_image_path?>" alt="<?= $comment['login']?>">
                        </a>
                    </div>
                    <div class="comment-text">
                        <p class="comment-paragraph">
                           <?= $comment['text']?>
                        </p>
                        <div class="comment-info">
                            <a href="#"><?= $comment['login']?> &nbsp;</a>
                            <span>-<?= date('Y-m-d', $comment['created_at'])?>&nbsp;</span>
                            <a class="comment-reply" onclick="sample_click(<?= $comment['id']?>)" >
                                <i class="fa fa-share"></i>Ответить
                            </a>

                        </div>
                    </div>
                    <?php if($comment['user_id'] == Yii::$app->user->id):?>
                        <a class="comment-remove" href="" onclick="removeComment(<?=$article['id']?>,<?= $comment['id']?>)">
                            <i class="fa fa-remove"></i>
                        </a>
                    <?php endif;?>
                </div>
                    <?php foreach ($comment['answers'] as $answer):?>

                    <ul class="comment-pane-list-children">
                    <li class="list-item">
                        <div class="comment-item">
                            <div class="comment-author-avatar">
                                <a href="<?= ''?>">
                                    <img src="<?= $user_image_path?>" alt="<?= $comment['login']?>">
                                </a>
                            </div>
                            <div class="comment-text">
                                <p class="comment-paragraph"><?= $answer['text']?></p>
                                <div class="comment-info">
                                    <a href="<?= ''?>"><?= $answer['login']?> &nbsp;</a>- <?= date('Y-m-d', $answer['created_at'])?> &nbsp;
                                    <a class="comment-reply" onclick="sample_click(<?= $answer['parent_id']?>)" >
                                        <i class="fa fa-share"></i>Ответить за базар
                                    </a>
                                </div>

                            </div>
                            <a class="comment-remove" href="" onclick="removeComment(<?=$article['id']?>,<?= $answer['id']?>)">
                                <i class="fa fa-remove"></i>
                            </a>

                        </div>
                    </li>
                </ul>
                    <?php endforeach; ?>

            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="leave-comment-pane">
    <div class="leave-comment-pane-header">
        <h3 class="leave-comment-pane-title">Залишити коментар</h3>
    </div>
    <div class="leave-comment-pane-body">
        <form class="leave-comment-pane-form" method="post" id="leave_comment">
            <div class="form-group input-item">
                <input type="hidden" name="Comment[parent_id]" id="parent_id" value="">
                <input type="hidden" name="Comment[article_id]"  value="<?= $article['id']?>">
                <input type="hidden" name="Comment[user_id]" value="<?= YII::$app->user->id?>">
                <textarea class="au-input au-input-border au-input-radius" name="Comment[text]" id="comment_form" placeholder="Ваш коментар..."></textarea>
            </div>
            <?php if (Yii::$app->user->isGuest): ?>
                <h3 class="leave-comment-pane-title">Увійдіть щоб залишити коментар</h3>
            <?php else: ?>
                <div class="input-submit">
                    <input class="au-btn au-btn-primary au-btn-pill au-btn-shadow" type="submit"  value="Відправити">
                </div>
            <?php endif;?>

        </form>
    </div>
</div>

<script>
    // A $( document ).ready() block.
    $( document ).ready(function() {
        $("#leave_comment" ).submit(function( event ) {
            event.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: '<?= \common\models\Article::getLink($article['id'],$article['seo_url'])?>',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(html){
                    $('#comments').html(html);
                }
            });
        });
    });
</script>

<script>
    function sample_click(parent_id) {
      var form =  document.getElementById('comment_form');
        document.getElementById('parent_id').value = parent_id;
      form.focus();
    }

</script>
    <script>
        function removeComment(article_id,comment_id) {
            event.preventDefault();
            $.ajax({
                type: 'post',
                url:'<?= \common\models\Article::getLink($article['id'],$article['seo_url'])?>'+'?comment='+comment_id,
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(html){
                    $('#comments').html(html);
                }
            });
        }
    </script>
</div>