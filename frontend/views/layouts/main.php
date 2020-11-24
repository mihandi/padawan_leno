<?php

/* @var $this \yii\web\View */

/* @var $content string */

use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

$admins = User::getAdmins();
AppAsset::register($this);
?>
<?php
$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/images/logos.ico">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php
    $this->head() ?>
</head>
<body>
<?php
$this->beginBody() ?>

<div class="wrap">
    <header class="header">
        <!-- header desktop-->
        <div class="header-primary header-fixed d-lg-block d-none sticky">
            <div class="container-fluid">
                <div class="section-inner header-bar">
                    <div class="header-bar-logo">
                        <a class="logo-link" href="/">
                            <img class="logo-light" src="/nm.png" width="45">
                            <span style="color: #FF7C87;">НЕОБМЕЖЕНI МОЖЛИВОСТI</span>
                        </a>
                    </div>
                    <div class="header-bar-menu">
                        <nav class="navbar-primary">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="/">ГОЛОВНА</a>
                                </li>
                                <li class="nav-item
<!--                                 has-drop-->
                                 ">
                                    <a class="nav-link" href="/blog/index">СТАТТІ</a>
                                    <!--                                    <ul class="drop-menu left">-->
                                    <!--                                        <li class="drop-item">-->
                                    <!--                                            <a class="drop-link" href="/blog/index?var=2">ВАРИАНТ 2</a>-->
                                    <!--                                        </li>-->
                                    <!---->
                                    <!--                                    </ul>-->
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/gallery/">ГАЛЕРЕЯ</a>
                                </li>
                                <?php
                                if (in_array(yii::$app->user->id, $admins)): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= Yii::getAlias('@backendBaseUrl') ?>">Admin
                                            Panel</a>
                                    </li>
                                <?php
                                endif; ?>
                                <?php
                                if (Yii::$app->user->isGuest): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="modal" data-target="#LoginModal"
                                           href="/site/login">УВІЙТИ</a>
                                    </li>

                                <?php
                                else: ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/site/personal">МІЙ ПРОФІЛЬ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/site/logout">ВИЙТИ</a>
                                    </li>
                                <?php
                                endif; ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="header-bar-featured d-none d-xl-block">
                        <a class="au-btn au-btn-radius au-btn-primary" href="/site/contact">НАПИСАТИ НАМ</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end header desktop-->
        <?php
        ?>
        <!-- header mobile-->
        <div class="header-mobile header-fixed d-lg-none">
            <div class="container-fluid">
                <div class="header-bar">
                    <div class="header-bar-logo">
                        <a class="logo-link" href="/">
                            <img class="logo-light" src="/nm.png" width="45">
                            <span style="color: #FF7C87;">НЕОБМЕЖЕНI МОЖЛИВОСТI</span>
                        </a>
                    </div>
                    <div class="header-bar-menu">
                        <button class="handler-slidebar hamburger" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="header-slidebar header-slidebar-primary closed">
                <div class="header-slidebar-inner">
                    <div class="box-author">
                        <a href="/">
                            <div class="author-image">
                                <img src="/nm.png" alt="Необмежені можливості">
                            </div>
                            <h3 class="author-name">Необмежені можливості</h3>
                        </a>
                    </div>
                    <nav class="navbar-vertical navbar-vertical-white">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="/">ГОЛОВНА</a>

                            </li>
                            <li class="nav-item
<!--                             has-drop-->
                             ">
                                <a class="nav-link" href="/blog/index">СТАТТІ</a>
                                <!--                                <ul class="drop-menu left">-->
                                <!--                                    <li class="drop-item">-->
                                <!--                                        <a class="drop-link" href="/blog/index?var=2">ВАРИАНТ 2</a>-->
                                <!--                                    </li>-->
                                <!--                                </ul>-->
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/gallery/">ГАЛЕРЕЯ</a>
                            </li>
                            <?php
                            if (in_array(yii::$app->user->id, $admins)): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= Yii::getAlias('@backendBaseUrl') ?>">Admin Panel</a>
                                </li>
                            <?php
                            endif; ?>
                            <?php
                            if (Yii::$app->user->isGuest): ?>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="modal" data-target="#LoginModal"
                                       href="#">УВІЙТИ</a>
                                </li>

                            <?php
                            else: ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/site/personal">МІЙ ПРОФІЛЬ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/site/logout">ВИЙТИ</a>
                                </li>
                            <?php
                            endif; ?>
                        </ul>
                    </nav>
                    <?php
                    //TODO  modify mobile footer?>
                    <div class="slidebar-footer">
                        <ul class="socials h-list">
                            <li class="social-item">
                                <a class="fa fa-envelope" href="#" data-toggle="tooltip" title="Email"></a>
                            </li>
                            <li class="social-item">
                                <a class="fa fa-instagram" target="_blank"
                                   href="https://www.instagram.com/neobmezheni_mozhlyvosti/" data-toggle="tooltip"
                                   title="Instagram"></a>
                            </li>
                            <li class="social-item">
                                <a class="fa fa-facebook" target="_blank"
                                   href="https://www.facebook.com/neobmezheni.mozhlyvosti/" data-toggle="tooltip"
                                   title="Facebook"></a>
                            </li>
                        </ul>
                        <p class="fo-copy"> Mika 2018</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end header mobile-->

    </header>

    <?= $content ?>
</div>

<footer class="footer footer-primary bg-dark-2 p-t-30 p-b-30">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 fo-left">
                <p class="fo-copy">Mika 2018</p>
            </div>
            <div class="col-md-6 fo-right">
                <ul class="socials h-list">
                    <li class="social-item">
                        <a class="fa fa-envelope" href="#" data-toggle="tooltip" title="Email"></a>
                    </li>
                    <li class="social-item">
                        <a class="fa fa-instagram" target="_blank"
                           href="https://www.instagram.com/neobmezheni_mozhlyvosti/" data-toggle="tooltip"
                           title="Instagram"></a>
                    </li>
                    <li class="social-item">
                        <a class="fa fa-facebook" target="_blank"
                           href="https://www.facebook.com/neobmezheni.mozhlyvosti/" data-toggle="tooltip"
                           title="Facebook"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<?php
require_once('../views/site/modal_template.php'); ?>


<?php
$this->endBody() ?>
</body>
</html>
<?php
$this->endPage() ?>
