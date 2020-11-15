<?php

use frontend\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;

// You can use the registerAssetBundle function if you'd like
//$this->registerAssetBundle('app');
AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <title><?php echo Html::encode($this->title); ?></title>
        <meta property='og:site_name' content='<?php echo Html::encode($this->title); ?>' />
        <meta property='og:title' content='<?php echo Html::encode($this->title); ?>' />
        <meta property='og:description' content='<?php echo Html::encode($this->title); ?>' />

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <link href='http://fonts.googleapis.com/css?family=Dancing+Script:400,700' rel='stylesheet' type='text/css' />
        <link href='http://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css' />
        <link href='http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' rel='stylesheet' type='text/css' />
        <?php $this->head(); ?>
    </head>
    <body class='wsite-theme-light tall-header-page wsite-page-index weeblypage-index'>
    <?php $this->beginBody(); ?>
    <div id="wrap">
        <div id="header-container">
            <table id="header">
                <tr>
                    <td id="logo">
                        <span class='wsite-logo'><a href='/'>
                                <span id="wsite-title"><?php echo Html::encode(\Yii::$app->name); ?></span></a>
                        </span>
                    </td>
                    <td id="header-right">
                        <table>
                            <tr>
                                <td class="phone-number"></td>
                                <td class="social"></td>
                                <td class="search"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <div id="topnav">
                <div id="nav-right">
                    <div id="nav-inner">
                        <?php
                        NavBar::begin([
                                          'brandLabel' => Yii::$app->name,
                                          'brandUrl' => Yii::$app->homeUrl,
                                          'options' => [
                                              'class' => 'nav',
                                          ],
                                      ]);
                        $menuItems = [
                            ['label' => 'Home', 'url' => Url::to(['/site/index'])],
                            ['label' => 'About', 'url' => Url::to(['/site/about'])],
                            ['label' => 'Contact', 'url' => Url::to(['/site/contact'])],
                            ['label' => 'Admin', 'url' => Yii::getAlias('@backendBaseUrl'), 'linkOptions' => ['target' => '_blank']],
                            ['label' => 'phpMyAdmin', 'url' => Yii::getAlias('@phpmyadmin'), 'linkOptions' => ['target' => '_blank']],

                        ];
                        if (Yii::$app->user->isGuest) {
                            $menuItems[] = ['label' => 'Signup', 'url' => Url::to(['/site/signup'])];
                            $menuItems[] = ['label' => 'Login', 'url' => Url::to(['/site/login'])];
                        } else {
                            $menuItems[] = '<li>'
                                . Html::beginForm(Url::to(['/site/logout']), 'post')
                                . Html::submitButton(
                                    'Logout (' . Yii::$app->user->identity->username . ')',
                                    ['class' => 'btn btn-link logout']
                                )
                                . Html::endForm()
                                . '</li>';
                        }
                        echo Nav::widget([
                                             'options' => ['class' => 'nav'],
                                             'items' => $menuItems,
                                         ]);
                        NavBar::end();
                        ?>
                        <div style="clear:both"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="main">
            <div id="banner">
                <div class="wsite-header"></div>
            </div>
            <div id="content"><div id='wsite-content' class='wsite-not-footer'>
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
        <div id="footer"><?php echo Html::encode(\Yii::$app->name); ?>
        </div>
    </div>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>