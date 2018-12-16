<?php
use frontend\widgets\MenuView;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<header id="masthead"  class="site-header">
    <div id="nav-header" class="">

        <div style="float: left;margin-top: 13px;margin-left: 20px">
            <a href="<?= yii::$app->getHomeUrl() ?>"><img style="width: 139px"
                        src="<?= yii::$app->getRequest()->getBaseUrl() ?>/static/images/logo.png"
                        alt="<?= yii::$app->feehi->website_title ?>"></a>
        </div>
        <div style="float: left">
            <div id="top-menu">
                <div id="site-nav-wrap">
                    <nav id="site-nav" class="main-nav">
                        <div style="margin-left: 30px">
                            <?= MenuView::widget() ?>
                            <i class="layui-icon layui-icon-search nav-search" title="搜索文章，分类"></i>
                        </div>
                    </nav>
                </div>

                <div id="top-menu_1" style="float: right;">
                    <?php
                    if (yii::$app->user->isGuest) {
                        ?>
                        <div style="margin-top: 15px" >
                        <a href="<?= Url::to(['site/login']) ?>" class="signin-loader" style="margin-right:20px;">
                            <button class="layui-btn layui-btn-radius layui-btn-primary"><?= yii::t('frontend', 'Log in') ?></button>
                        </a>
                        <a href="<?= Url::to(['site/signup']) ?>" class="signup-loader">
                            <button class="layui-btn layui-btn-radius layui-btn-primary"><?= yii::t('frontend', 'Sign up') ?>
                            </button>
                        </a></div>
                    <?php } else { ?>
                        <ul class="nav navbar-nav navbar-right" >
                            <li class="dropdown" style="color: ">
                                <a style="font-size: 25px;margin-top: 15px" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?= Html::encode(yii::$app->user->identity->username) ?>
                                    <span class="caret" style="color: #878787"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">个人中心</a></li>
                                    <li><a href='<?=Url::to(['order/my-index'])?>'>我的预约</a></li>
                                    <li><a href='<?=Url::to(['site/update-password'])?>'>修改密码</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= Url::to(['site/logout']) ?>"
                                           class="signup-loader">
                                            <?= yii::t('frontend', 'Log out') ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div style="float: right">
        </div>
    </div>
</header>