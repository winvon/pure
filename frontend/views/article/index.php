<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $type string
 */

use common\models\Options;
use frontend\models\Article;
use frontend\widgets\ArticleListView;
use frontend\widgets\ScrollPicView;
use common\widgets\JsBlock;
use frontend\assets\IndexAsset;
use yii\data\ArrayDataProvider;

IndexAsset::register($this);
$this->title = yii::$app->feehi->website_title;
?>
<style>
    .excerpt {
        border-left: none;
        border-right: none;
    }
    .excerpt:hover {
        border-left: none;
        border-right: none;
    }
    .title {
        border-left: none;
        border-right: none;
        border-top: none;
    }
    .widget {
        border-left: none;
        border-right: none;
        border-bottom: none;
        -webkit-border-radius: 0;
    }
    .content article:first-of-type {
        border-radius:  0;
    }
    .d_textbanner a {
        border: 0;
        border-radius: 0;
    }

</style>
<div class="content-wrap">
    <div class="content">
        <div class="slick_bor">
            <?= ScrollPicView::widget([
                'banners' => Options::getBannersByType('index'),
            ]) ?>
            <div class="ws_shadow"></div>
        </div>
        <header class="archive-header"><h1><?=$type?></h1></header>
        <?= ArticleListView::widget([
            'dataProvider' => $dataProvider,
        ]) ?>
    </div>
</div>
<?= $this->render('/widgets/_sidebar')?>
<?php JsBlock::begin() ?>
<script>
    $(function () {
        var mx = document.body.clientWidth;
        $(".slick").responsiveSlides({
            auto: true,
            pager: true,
            nav: true,
            speed: 700,
            timeout: 7000,
            maxwidth: mx,
            namespace: "centered-btns"
        });
    });
</script>
<?php JsBlock::end() ?>
