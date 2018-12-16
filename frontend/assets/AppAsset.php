<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace frontend\assets;

class AppAsset extends \yii\web\AssetBundle
{

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $css = [

        'static/css/bootstrap.min.css',
        'static/css/font-awesome.min93e3.css?v=4.4.0',
        'static/css/style.css',
        'static/plugins/toastr/toastr.min.css',
        'static/select2/dist/css/select2.min.css',
        'static/layui/css/layui.css',
    ];

    public $js = [
        'static/js/jquery.min.js',
        'static/js/index.js',
        'static/plugins/toastr/toastr.min.js',
        'static/layui/layui.js',
        'static/layer/layer.min.js',
        'static/select2/dist/js/select2.js',
        'static/select2/dist/js/i18n/zh-CN.js',
        "static/fwf/js/select2.js",
    ];

}
