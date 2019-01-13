<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use frontend\widgets\MenuView;

AppAsset::register($this);


?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <?php !isset($this->metaTags['keywords']) && $this->registerMetaTag(['name' => 'keywords', 'content' => yii::$app->feehi->seo_keywords], 'keywords'); ?>
        <?php !isset($this->metaTags['description']) && $this->registerMetaTag(['name' => 'description', 'content' => yii::$app->feehi->seo_description], 'description'); ?>
        <meta charset="<?= yii::$app->charset ?>">
        <?= Html::csrfMetaTags() ?>
        <meta http-equiv="X-UA-Compatible" content="IE=10,IE=9,IE=8">
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <script>
            window._deel = {
                name: '<?=yii::$app->feehi->website_title?>',
                url: '<?=yii::$app->getHomeUrl()?>',
                comment_url: '<?=Url::to(['article/comment'])?>',
                ajaxpager: '',
                commenton: 0,
                roll: [4,]
            }
        </script>
    </head>
    <?php $this->beginBody() ?>

    <body class="home blog">
    <?= $this->render('/widgets/_flash') ?>
    <style>
        #site-nav-wrap {
            float: left;
            min-height: 45px;
        }
        .nav-search {
            margin-top:10px;
            background-color: #d6dccf;
        }
        .nav-search:hover {
            background: #b3b3b3 none repeat scroll 0 0;
        }
        .title {
            position: relative;
            height: 40px;
            padding: 0px 15px 0px 15px;
            border-bottom: 1px solid #eaeaea;
            background: #ffffff;
        }
        body {
            /*background-color: white;*/
            background-image: url(/static/images/background.png);
            background-attachment:fixed;
        }
    </style>
    <?= $this->renderFile('@frontend/views/layouts/header.php')?>
    <div id="search-main">
        <div id="searchbar">
            <form id="searchform" action="<?= Url::to('/search') ?>" method="get">
                <input id="s" type="text" name="q" value="<?= Html::encode(yii::$app->request->get('q')) ?>" required=""
                       placeholder="<?= yii::t('frontend', 'Please input keywords') ?>" >
                <button  id="searchsubmit" type="submit"><?= yii::t('frontend', 'Search') ?></button>
            </form>
        </div>
    </div>

    <section class="container">
        <div class="speedbar"></div>
        <?= $content ?>
    </section>

    <!--<div class="branding branding-black">
        <div class="container_f">
            <h2><?/*= yii::t('frontend', 'Effective,Professional,Conform to SEO') */?></h2>
            <a class="btn btn-lg" href="http://www.feehi.com/page/contact"
               target="_blank"><?/*= yii::t('frontend', 'Contact us') */?></a>
        </div>
    </div>-->

    <?=$this->renderFile("@frontend/views/layouts/footer.php")?>

    <div class="rollto" style="display: none;">
        <button class="btn btn-inverse" data-type="totop" title="back to top"><i class="fa fa-arrow-up"></i></button>
    </div>
    </body>
    <?php $this->endBody() ?>
    <?php
    if (yii::$app->feehi->website_statics_script) {
        echo yii::$app->feehi->website_statics_script;
    }
    ?>
    </html>
<?php $this->endPage() ?>
<script>
    $('.sh').on('click',function () {
    })
</script>
