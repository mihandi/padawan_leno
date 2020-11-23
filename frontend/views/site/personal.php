<?php

/* @var $this yii\web\View */


use budyaga\cropper\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Личный кабинет';

$user_image = $user->getImage();

$user->image = $user_image;
$route = Url::toRoute("/site/set-image");

?>
<?php /*
<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-4">
            <div class="row" id="user-logo">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center" id="user">
                                <img src="<?= $user_image ?>" style="width: 250px; height: 250px" id="img">
                                <div>
                                    <form id="ajax_form" enctype="multipart/form-data" method="post">
                                        <p>
                                            <input type="file" name="User[photo]" id="ajax_input">
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" id="submit"  class="btn btn-default btn-sm">Сохранить</button>
                                            </div>
                                        </div>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <main class="posts-listing col-lg-4">
            <div class="container">
                <div class="row">

                </div>
            </div>
        </main>

    </div>
</div>
                        <div class="col-lg-5 col-md-4">
                            <form class="form-horizontal"  action="/site/personal" method="POST">
                                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken()?>">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Логин</label>
                                        <div class="col-sm-8">
                                            <input type="hidden"  name="User[id]" value="<?= (int)$user['id']?>">
                                            <input type="text" class="form-control" placeholder="Логин" name="User[login]" value="<?=$user['login']?>">
                                            <?php if(isset($user->errors['login'])):?>
                                                <?php err($user->errors['login']); ?>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-8">
                                            <input type="email" class="form-control" placeholder="Email" name="User[email]" value="<?=$user['email']?>">
                                            <?php if(isset($user->errors['email'])):?>
                                                <?php err($user->errors['email']); ?>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-sm-2 control-label">Имя</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" placeholder="Имя" name="User[first_name]" value="<?= isset($user['first_name'])?$user['first_name']:''?>">
                                            <?php if(isset($user->errors['first_name'])):?>
                                                <?php err($user->errors['first_name']); ?>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-sm-2 control-label">Фамилия</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" placeholder="Фамилия" name="User[last_name]" value="<?= isset($user['last_name'])?$user['last_name']:''?>">
                                            <?php if(isset($user->errors['last_name'])):?>
                                                <?php err($user->errors['last_name']); ?>
                                            <?php endif;?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-default btn-sm">Сохранить</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

*/
?>


<main class="page-two-col bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <?php $form = ActiveForm::begin(['id' => 'form-profile']); ?>
                <div class="row">
                        <div class="col-lg-6 col-md-6 ">
                            <?php echo $form->field($user, 'image')->widget(Widget::className(), [
                                'uploadUrl' => $route,
                                'width' => 300,
                                'height' => 300,
                            ]) ?>
                        </div>
                    <div class="col-lg-6 col-md-6 ">
                        <?= $form->field($user, 'login')->textInput() ?>
                        <?= $form->field($user, 'email')->textInput() ?>
                        <?= $form->field($user, 'first_name')->textInput() ?>
                        <?= $form->field($user, 'last_name')->textInput() ?>
                    </div>
                </div>
                <div class="form-group" align="center">
                    <?= Html::submitButton('Відправити', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-lg-3">
                <aside class="page-col-two p-t-100">
                    <?php require_once ('../views/blog/search_bar.php');?>
                    <!-- Widget [Categories Widget]-->
                    <?php require_once ('../views/blog/categories.php');?>
                    <!-- Widget [Latest Posts Widget]        -->
                    <?php require_once ('../views/blog/latest_posts.php');?>

                    <?php require_once ('../views/archive.php');?>

                    <?php require_once ('../views/contacts.php');?>
                </aside>
            </div>
        </div>
    </div>
</main>



<!--<script src="https://code.jquery.com/jquery-1.9.1.js"></script>-->

