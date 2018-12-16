<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-06-21 14:26
 */

use common\models\meta\ArticleMetaTag;
use yii\helpers\Url;
use frontend\models\Comment;
use frontend\models\FriendlyLink;
use common\models\Notice;
use common\models\Article;
use common\models\Order;

?>
<style>
    li {
        color: #777;
    }

    .d_comment .avatar {
        float: left;
        width: 40px;
        margin: 10px 10px 10px 0;
        border-radius: 50%;
    }

    .find-more {
        position: absolute;
        vertical-align: middle;
        text-align: center;
        margin-top: 11px;
        right: 0;
        font-size: 13px;
        color: #787878;
    }

    div, ul, li {
        margin: 0;
        padding: 0
    }

    /*先初始化一下默认样式*/
    .notice {

        height: 35px; /*固定公告栏显示区域的高度*/
        padding: 0 10px;
        overflow: hidden;
    }

    .notice ul li {
        list-style: none;
        line-height: 35px;
        /*以下为了单行显示，超出隐藏*/
        display: block;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
</style>
<aside class="sidebar">
    <div class="widget d_textbanner notice" style="height: 150px;max-height: 150px;">
        <strong><span><?= yii::t('frontend', '公告') ?></span></strong>
        <ul>

            <?php
            $ns = Notice::find()->where(['>=', 'deadline_at', time()])->all();
            foreach ($ns as $n) {
                ?>
                <li><?= $n->title ?></li>
            <?php } ?>
        </ul>
    </div>

    <!--标签区-->
    <div class="widget d_tag">
        <div class="title">
            <h2>
                <sapn class="title_span"><?= yii::t('frontend', 'Tags') ?></sapn>
            </h2>
        </div>
        <div class="d_tags">
            <?php
            $tagsModel = new ArticleMetaTag();
            foreach ($tagsModel->getHotestTags() as $k => $v) {
                echo "<a title='' href='" . Url::to(['search/tag', 'tag' => $k]) . "' data-original-title='{$v}" . yii::t('frontend', ' Topics') . "'>{$k} ({$v})</a>";
            }
            ?>
        </div>
    </div>
    <!--疗愈师-->
    <div class="widget widget_text">
        <div class="title">
            <h2 style="float: left">
                <sapn class="title_span"><?= yii::t('frontend', '推荐疗愈师') ?></sapn>
            </h2>
            <a href=<?= Url::to(['author/index']) ?> target="_blank" class="find-more">查看全部<i
                        class="layui-icon layui-icon-next" style="font-size: 13px"></i></a>
        </div>
        <div class="textwidget">
            <div class="d_tags_1">
                <ul>
                    <?php
                    $db = Yii::$app->db;
                    $sql = 'select * from ab_admin_user WHERE `type`=1  ORDER by rand() limit 5';
                    $rs = $db->createCommand($sql)->queryAll();
                    foreach ($rs as $r) {
                        ?>
                        <li style="margin:5px auto;height: 60px">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href=author/view?author_id=<?= $r['id'] ?> style="height: 52px;width: 50px">
                                        <img data-original="<?= yii::$app->getRequest()->getBaseUrl() . $r['avatar'] ?>"
                                             class="avatar" height="48"
                                             width="48" src=""
                                             style="display: block;  border: 1px solid #ddd;border-radius: 50%;height:48px">
                                    </a>
                                </div>

                                <div class="col-md-8">


                                    <h3><?= $r['nickname'] ? $r['nickname'] : $r['username']; ?>
                                    </h3>

                                    <span class="info-author">服务了<i class="fa fa-heart" aria-hidden="true"
                                                                    style="color: #ff251c"></i>&ensp;</span>
                                    <span class="info-number"><?= Order::find()->where(['admin_id' => $r['id']])
                                            ->andWhere(['status' => Order::STATUS_ORDER])
                                            ->count() ?></span>&ensp;&ensp;&ensp;
                                    <span class="info-author">文章<i class="fa fa-file-word-o"></i>&ensp;</span>
                                    <span class="info-number"><?= Article::find()->where(['author_id' => $r['id']])->count() ?></span>

                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</aside>
<script>
    function noticeUp(obj, top, time) {
        $(obj).animate({
            marginTop: top
        }, time, function () {
            $(this).css({marginTop: "0"}).find(":first").appendTo(this);
        })
    }
    $(function () {
        <?php if(count($ns) > 4){?>
        setInterval("noticeUp('.notice ul','-35px',500)", 2000);
        <?php }?>
        // 调用 公告滚动函数
    });
</script>