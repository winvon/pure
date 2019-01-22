<?php
use frontend\widgets\ArticleListView;
use common\models\Article;
use common\models\Order;
?>
<style>
    .meta-block {
        display: inline-block;
        border-right: solid 1px gainsboro;
        width: 12%;
        padding-left: 10px;
    }

    .info-author {
        font-size: 12px;
        color: grey;
    }

    .info-number {
        font-size: 15px;
        color: #878787;
    }
    .excerpt {
        background-color: rgba(255,255,255,0.1);
    }
</style>
<div class="content-wrap" style="height: 900px">
    <div style="margin-bottom: 20px;">
        <div class="row" style="">
            <div class="col-md-1">
                <?php $r = \backend\models\User::findOne([$author_id]) ?>
                <img class=" img-circle"
                     data-original="<?= yii::$app->getRequest()->getBaseUrl() . $r['avatar'] ?>"
                     src="<?= yii::$app->getRequest()->getBaseUrl() . $r['avatar'] ?>"
                     width="80"
                >
            </div>
            <div class="col-md-6 ">
                <h2 style="margin-bottom: 10px"><?= $r->nickname ? $r->nickname : $r->username ?></h2>
                <div>
                    <a href="" class="">
                        <div class="meta-block ">
                            <span class="info-number"><?= Article::find()->where(['author_id' => $author_id])->count() ?></span><br>
                            <span class="info-author">文章<i class="fa fa-file-word-o"></i></span>
                        </div>
                    </a>
                    <a href=<?=\yii\helpers\Url::to(['order/index','author_id'=>$author_id])?> class="">
                        <div class="meta-block" style="border: none">
                            <span class="info-number"><?=  Order::find()
                                    ->where(['admin_id' => $author_id])
                                    ->andWhere(['admin_id'=>$author_id])
                                    ->andWhere(['status'=>Order::STATUS_WAIT_ORDER])
                                    ->count() ?></span><br>
                            <span class="info-author">可预约<i class="fa fa-heart-o"></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <?= ArticleListView::widget([
            'dataProvider' => $dataProvider,
        ]) ?>
    </div>
</div>
<?= $this->render('/widgets/_author_bar',['r'=>$r]) ?>
<script>
    layui.use('element', function () {
        var element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

        //监听导航点击
        element.on('nav(demo)', function (elem) {
            //console.log(elem)
            layer.msg(elem.text());
        });
    });
</script>
