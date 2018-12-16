<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-06-19 00:21
 */

namespace frontend\widgets;

use yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use yii\helpers\StringHelper;

class ArticleListView extends \yii\widgets\ListView
{

    /**
     * @var string 布局
     */
    public $layout = "{items}\n <div class=\"pagination col-md-6\">{pager}</div>";

    /**
     * @var int 标题截取长度
     */
    public $titleLength = 28;

    /**
     * @var int summary截取长度
     */
    public $summaryLength = 70;

    /**
     * @var int 缩率图宽
     */
    public $thumbWidth = 220;

    /**
     * @var int 缩略图高
     */
    public $thumbHeight = 150;

    public $itemOptions = [
        'tag' => 'article',
        'class' => 'excerpt'
    ];

    public $pagerOptions = [
        'firstPageLabel' => '首页',
        'lastPageLabel' => '尾页',
        'prevPageLabel' => '上一页',
        'nextPageLabel' => '下一页',
        'options' => [
            'class' => '',
        ],
    ];

    /**
     * @var string 模板
     */
    public $template = "<div class='focus'>
                                   <a target='_blank' href='{article_url}'>
                                        <img width='150px'  style='border-radius:3px' class='thumb' src='{img_url}' alt='{title}'></a>
                               </div>
                               <header>
                                   <h2><a target='_blank' href='{article_url}' title='{title}'>{title}</a></h2>
                               </header>
                               <span class='note' >{summary}</span>
                               <p class='auth-span' >
                                   <span class='muted'><i class='layui-icon layui-icon-username'></i>{author}</span>
                                   <span class='muted'><i class='layui-icon layui-icon-read'></i> {scan_count}</span>
                                   <span class='muted'><i class='layui-icon layui-icon-reply-fill'></i> <a target='_blank' href='{comment_url}'>{comment_count}评论</a></span>
                               </p> ";

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->pagerOptions = [
            'firstPageLabel' => yii::t('app', 'first'),
            'lastPageLabel' => yii::t('app', 'last'),
            'prevPageLabel' => yii::t('app', 'previous'),
            'nextPageLabel' => yii::t('app', 'next'),
            'options' => [
                'class' => 'pagination',
            ]
        ];
        if( empty($this->itemView) ) {
            $this->itemView = function ($model, $key, $index) {
                /** @var $model \frontend\models\Article */
                $categoryName = $model->category ? $model->category->name : yii::t('app', 'uncategoried');
                $categoryUrl = Url::to(['article/index', 'cat' => $categoryName]);
                $imgUrl = $model->getThumbUrlBySize($this->thumbWidth, $this->thumbHeight);
                $articleUrl = Url::to(['article/view', 'id' => $model->id]);
                $summary = StringHelper::truncate($model->summary, $this->summaryLength);
                $title = StringHelper::truncate($model->title, $this->titleLength);
                $author = $model->author_name;
                return str_replace([
                    '{article_url}',
                    '{img_url}',
                    '{category_url}',
                    '{title}',
                    '{summary}',
                    '{author}',
                    '{scan_count}',
                    '{comment_count}',
                    '{category}',
                    '{comment_url}'
                ], [
                    $articleUrl,
                    $imgUrl,
                    $categoryUrl,
                    $title,
                    $summary,
                    $author,
                    $model->scan_count * Yii::$app->params['base_read_time'],
                    $model->comment_count,
                    $categoryName,
                    $articleUrl . "#comments"
                ], $this->template);
            };
        }
    }

    /**
     * @inheritdoc
     */
    public function renderPager()
    {
        $pagination = $this->dataProvider->getPagination();
        if ($pagination === false || $this->dataProvider->getCount() <= 0) {
            return '';
        }
        /* @var $class LinkPager */
        $pager = $this->pager;
        $class = ArrayHelper::remove($pager, 'class', LinkPager::className());
        $pager['pagination'] = $pagination;
        $pager['view'] = $this->getView();
        $pager = array_merge($pager, $this->pagerOptions);
        return $class::widget($pager);
    }

}
