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

?>
<style>
    .introduce{
        margin-top: 30px;
    }
    .tag{
        color: #b4b4b4;
    }
    .contents{
        padding-top: 10px;
        padding-bottom: 10px;
    }
    textarea{
        height:160px;
        color: grey;
        background-color: rgba(255,255,255,0.1);
    }
</style>
<aside class="sidebar">
    <!--个人介绍-->
    <div class="introduce">
        <div class="tag">
            <span>个人介绍</span>
        </div>
        <div class="contents">
            <textarea class="col-md-10" disabled  style="border: none"><?=$r->introduce?$r->introduce:'暂时还没留下个人介绍'?></textarea>
        </div>
    </div>

</aside>
