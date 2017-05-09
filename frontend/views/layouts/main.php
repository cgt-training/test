<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<section class="header-nav">
  <nav class="navbar navbar-default">
    <div class="container">
      
        <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/img/logo.png', ['class'=>'logo-img']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'my-navbar navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/']],
        ['label' => 'Company', 'url' => ['/company']],
        ['label' => 'Branch', 'url' => ['/branch']],
        ['label' => 'Department', 'url' => ['/department']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup'],'class'=>'btn btn-log-in'];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login'],'class'=>'btn btn-register'];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav navbar-right navbar-right-top-margin'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?><!-- /.navbar-collapse -->
      <!-- </div> -->  <!-- row -->
    </div><!-- /.container -->
  </nav> <!-- navbar navbar-default -->
</section>  <!-- header-nav -->
<section class="banner-img">
  <div class="container">
    <div class="row">
      <div class="banner-content">
        <div class="col-md-8 col-sm-7 col-xs-12 banner-left-main">
            <div class="banner-left-get-serious">
                Get serious about social
            </div>
            <div class="banner-left-start-free">
                Join the 10+ million professionals who trust Ready For Social.
                Get started for free.
            </div>
            <div class="banner-left-btn-social">
                <button type="submit" class="btn btn-sign-up-social">Sign up with 
                    Social Network</button>
            </div>
             <div class="banner-left-btn-login">
                <button type="submit" class="btn btn-banner-log-in">Login</button>
            </div>
        </div>  <!-- banner-left-main -->
        <div class="col-md-4 col-sm-5 col-xs-12 banner-right-main">
            <?= Html::img('@web/img/bannergrpimg.png', ['class'=>'img-responsive grp-image']) ?>
        </div>  <!-- banner-right-main -->
      </div>  <!-- banner-content -->
    </div>  <!-- row -->
  </div>  <!-- container -->
</section>  <!-- banner-img -->
<section class="connect-with-social">
  <div class="col-md-6 col-sm-6 col-xs-12 connect-with-social-twitter">
    <div class="connect-with-social-twitter-main">
      <div class="connect-with-social-twitter-connect">
          Connect with <span><?= Html::img('@web/img/twitter.png') ?></span>  
      </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-6 col-xs-12 connect-with-social-in">
     <div class="connect-with-social-twitter-main">
      <div class="connect-with-social-twitter-connect">
          Connect with <span><?= Html::img('@web/img/in.png') ?></span>  
      </div>
    </div>
  </div>
</section>
<div class="container">
 <?= $content ?>
</div>
<section class="quick-links-section">
        <div class="container">
            <div class="row">
            <div class="quick-links-content">
                <div class="col-md-4 col-sm-4 col-xs-12 quick-links-left-main">
                    <div class="quick-links-left-padding">
                        <div class="quick-links-left-logo">
                            <?= Html::img('@web/img/logo.png', ['class'=>'quick-links-left-logo-img']) ?>
                        </div>
                        <div class="quick-links-left-middle">
                            Aenean molestie sed urna non consectetur. Sed eu arcu 
                            dolor. Nam lobortis sem dui, non pellentesque metus euismod
                            eu. Nulla a libero at nisi tristique vehicula.
                        </div>
                        <div class="quick-links-left-link">
                            readyforsocial@info.com
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12 quick-links-right-main">
                    
                        <div class="col-md-8 col-sm-8 col-xs-12 quick-links-right-menu-main">
                            <div class="quick-links-right-menu-inner">
                                <div class="quick-links-right-menu-heading">
                                    QUICK LINKS
                                </div>
                                <div class="quick-links-right-menu-ul-main">
                                    <div class="col-md-4 col-sm-4 col-xs-12 quick-links-right-menu-ul-first">
                                        <ul>
                                            <li><a href="#">Home</a></li>
                                            <li><a href="#">Features</a></li>
                                            <li><a href="#">Plan</a></li>
                                            <li><a href="#">About</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 quick-links-right-menu-ul-second">
                                        <ul>
                                            <li><a href="#">Register</a></li>
                                            <li><a href="#">Login</a></li>
                                            <li><a href="#">Contact</a></li>
                                            <li><a href="#">Blog</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 quick-links-right-menu-ul-third">
                                        <ul>
                                            <li><a href="#">Terms & Conditions</a></li>
                                            <li><a href="#">Privacy Policy</a></li>
                                            <li><a href="#">FAQ's</a></li>
                                        </ul>
                                    </div>
                                </div>  <!-- quick-links-right-menu-ul-main -->
                            </div>  <!-- quick-links-right-main-inner -->
                        </div>  <!-- quick-links-right-menu-main -->
                        <div class="col-md-4 col-sm-4 col-xs-12 quick-links-right-social">
                            <div class="quick-links-right-social-images">
                                <div class="col-md-4 col-sm-4 col-xs-4 social-images-fb-circle">
                                    <?= Html::img('@web/img/fb_circle.png') ?>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4 social-images-twitt-circle">
                                    <?= Html::img('@web/img/twitter_circle.png') ?>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4 social-images-in-circle">
                                    <?= Html::img('@web/img/in_circle.png') ?>
                                </div>
                            </div>
                        </div>
                </div>
            </div>  <!-- quick-links-content -->
        </div>  <!-- row -->
        </div>
</section>
<section class="footer-section">
    <div class="footer-div">
        Copyright 2016 by Ready For Social
    </div>
</section>


<!-- <footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer> -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
