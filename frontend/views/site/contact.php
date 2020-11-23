<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Контакт';
$this->params['breadcrumbs'][] = $this->title;

function errr($errors)
{
    foreach ($errors as $error){
        echo "<div class=\"help-block help-block-error \" style='color: #a94442'> $error </div>";
    }
}
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i>Перемога!</h4>
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>


<!-- section contact-->
<section class="section section-contact bg-white p-t-120 p-b-135">
    <div class="container">
        <div class="section-inner">
            <h3 class="section-heading m-b-90">Напишите нам</h3>

            <form  method="post" action="/site/contact">
                <div class="row co-form-input">
                    <div class="col-lg-6">
                        <div class="input-item">
                            <div class="input-title">
                                <span class="input-label">Ваше имя</span>
                            </div>
                            <input class="au-input au-input-border-light au-input-radius" type="text" id="name" name="ContactForm[name]" value="<?= isset($model['name'])?$model['name']:''?>" >
                            <?php if(isset($model->errors['name'])):?>
                                <?php errr($model->errors['name']); ?>
                            <?php endif;?>
                        </div>
                        <div class="input-item">
                            <div class="input-title">
                                <span class="input-label">Ваш email*</span>
                            </div>
                            <input class="au-input au-input-border-light au-input-radius" type="email" id="email" name="ContactForm[email]" value="<?= isset($model['email'])?$model['email']:''?>" >
                            <?php if(isset($model->errors['email'])):?>
                                <?php errr($model->errors['email']); ?>
                            <?php endif;?>
                        </div>
                        <div class="input-item">
                            <div class="input-title">
                                <span class="input-label">Тема cообщения*</span>
                            </div>
                            <input class="au-input au-input-border-light au-input-radius" type="text" id="subject" name="ContactForm[subject]" value="<?= isset($model['subject'])?$model['subject']:''?>" >
                            <?php if(isset($model->errors['subject'])):?>
                                <?php errr($model->errors['subject']); ?>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-item">
                            <div class="input-title">
                                <span class="input-label">Сообщение*</span>
                            </div>
                            <textarea class="au-input au-input-border-light au-input-radius" style="height: 230px;" id="msg" name="ContactForm[body]" ><?= isset($model['body'])?$model['body']:''?></textarea>
                            <?php if(isset($model->errors['body'])):?>
                                <?php errr($model->errors['body']); ?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <div class="co-form-btn">
                    <input class="au-btn au-btn-radius au-btn-primary" type="submit" value="Отправить">
                </div>
            </form>
        </div>
    </div>
</section>
<!-- end section contact-->
