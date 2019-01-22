<?php
use yii\helpers\Url;
use backend\models\Article;
use backend\models\User;
?>

<style>
    .recommend {
        text-align: center;
    }

    .container {
        width: 960px;
    }

    .recommend .collection-wrap, .recommend .wrap {
        height: 290px;
        margin-top: 80px;
        padding: 0 20px;
        border: 1px solid #e6e6e6;
        border-radius: 4px;
        background-color: hsla(0, 0%, 71%, .1);
        transition: .2s ease;
        -webkit-transition: .2s ease;
        -moz-transition: .2s ease;
        -o-transition: .2s ease;
        -ms-transition: .2s ease;
    }

    .recommend .wrap .avatar, .recommend .wrap .avatar-collection {
        width: 80px;
        height: 80px;
        margin: -40px 0 10px;
        display: inline-block;
        border: 1px solid #ddd;
        background-color: #fff;
        border-radius: 50px;
    }

    .wrap:hover {
        box-shadow: #8d8d8d 0 0 10px;
    }

    .meta {
        float: left;
        margin-top: -29px;
        padding-right: 10px;
        font-size: 12px;
        color: #969696;
        background-color: #f8f8f8;
    }

    .recommend .wrap .description {
        margin: 0 auto 10px;
        max-width: 180px;
        height: 70px;
    }

    .recommend .collection-wrap .recent-update, .recommend .wrap .recent-update {
        min-height: 75px;
    }

    .recommend .collection-wrap .new, .recommend .wrap .new {
        font-size: 13px;
        line-height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: block;
    }

    .recommend .wrap h4 {
        font-size: 21px;
        font-weight: 700;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .follow {
        border-color: #34c00b;
        border-radius: 15px;
    }

    .recommend .btn-danger {
        width: 38.2%;
        padding: 10px 0;
        margin: 40px 0;
        font-size: 15px;
        border-radius: 20px;
        background-color: #a5a5a5;
        border: none;
    }

    .recommend .btn-danger:hover {
        background-color: #8b8b8b;
    }

    .banner {
        background-image: url(/static/images/_banner.jpg);
        opacity:0.50;
        width: 930px;
        height: 97px;
        margin-top: 40px;
        border-radius: 4px;
    }

    .help {
        color: grey;
        margin-right: 20px;
        margin-top: 60px;
        float: right;
    }

    .meta {
        background-color: rgba(255,255,255,0.3)
    }

</style>

<div class="container recommend">
    <div class="banner">
<!--        <a target="_blank" class="help" href="">-->
<!--            如何成为疗愈师-->
<!--        </a>-->
    </div>

    <div class="row author-list">
        <?php $us = User::find()->where(['type' => 1])->andWhere(['status'=>User::STATUS_ACTIVE])->limit(24)->all();
        foreach ($us as $u) {
            ?>
            <div class="col-xs-4">
                <div class="wrap">
                    <a target="_blank" href=<?= Url::to(['author/view', 'author_id' => $u->id]) ?>>
                        <img class="avatar"
                             src="<?= $u->avatar ?>"
                             alt="180">
                        <h4 class="name">
                            <?= $u->username ?>
                            <i class="iconfont ic-man"></i>
                        </h4>
                        <p class="description">
                            <?php if (strlen($u->introduce) > 90) {
                                echo mb_convert_encoding(substr($u->introduce, 0, 90) . "...", "UTF-8");
                            } else {
                                echo mb_convert_encoding($u->introduce, "UTF-8");
                            } ?>
                        </p>
                    </a>
                    <!--                    <a class="btn btn-success follow"><i class="layui-icon layui-icon-add-1"-->
                    <!--                                                         style="font-size: 13px"></i><span>关注</span>-->
                    <!--                    </a>-->
                    <hr>
                    <a target="_blank" href=<?=Url::to(['order/index','author_id'=>$u->id])?> class="meta btn btn-success">预约</a>
                    <div class="recent-update">
                        <?php $as = Article::find()
                            ->where(['type' => Article::ARTICLE])
                            ->andWhere(['author_id' => $u->id])
                            ->andWhere(['status' => Article::ARTICLE_PUBLISHED])
                            ->orderBy('created_at DESC')
                            ->limit(3)
                            ->all();
                        foreach ($as as $a) {
                            ?>
                            <a class="new" target="_blank" href="/view/<?= $a->id ?>"><?= $a->title ?></a>
                        <?php }; ?>
                    </div>
                </div>
            </div>
        <?php }; ?>
    </div>
    <button class="btn btn-danger load-more-btn" value=<?= $u->id ?>  href="#">加载更多</button>
</div>
<script>
    $('.load-more-btn').on('click', function () {
        $.get('<?=Url::to(['author/get-more-list'])?>', {author_id: $('.load-more-btn').val()}, function (data) {
            $.each(data, function (i, n) {
                ht = "<div class=col-xs-4>" +
                    "<div class=wrap>" +
                    "<a target=_blank  href=author/view?author_id=" + n.author_id + ">" +
                    "<img class=avatar  src=" + n.avatar + " alt=180>" +
                    "<h4 class=name>" + n.username + "<i class=iconfont ic-man></i></h4>" +
                    "<p class=description>" + n.introduce + "</p></a> <hr><div class=meta>最近更新</div>";
                ht1 = '';
                $.each(n.a, function (i, n) {
                    ht += "<a class=new target=_blank href=/view/" + n.id + ">" + n.title + "</a>"
                });
                ht = ht + ht1 + "</div></div></div>";
                $(".author-list").append(ht);
            });
        });

    });
</script>