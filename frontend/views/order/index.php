<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = 'Orders';
$isGuest = Yii::$app->user->isGuest ? true : 'false';
//var_dump($isGuest);die();
?>
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px;
    }

    .select2-container .select2-selection--single {
        height: 38px;
    }
</style>
<div class="row" style="height:900px">
    <div class="col-sm-12">
        <div class="demoTable">
            <div class="layui-input-inline " style="width: 130px;">
                <select class="form-control" id="admin_id">
                </select>
            </div>
            <div class="layui-input-inline " style="width: 130px;">
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="start_time" placeholder="选择日期">
                </div>
            </div>
            <button class="layui-btn" data-type="reload"><?= Yii::t("app", "Search") ?></button>
            <button class="layui-btn layui-btn-primary" data-type="reset"><?= Yii::t("app", "Reset") ?>
            </button>
        </div>
        <table id="demo" lay-filter="test"></table>
    </div>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="order">预约</a>
</script>

<script>
    $.ajaxSetup({
        async: false //取消异步
    });

    $('#admin_id').select2({
        ajax: {
            url: '<?=Url::to(['author/get-author'])?>',
            dataType: 'json',
            method: 'post',
            delay: 250,
            cache: true,
            data: function (params) {
                return {
                    username: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 2) < data.total_count
                    }
                };
            },
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        language: "zh-CN",
        placeholder: '选择预约疗愈师',
        minimumResultsForSearch: 1,
    });

    layui.use('laydate', function () {
        var laydate = layui.laydate;
        laydate.render({
            elem: '#start_time'
            , format: 'yyyy-MM-dd'
        });
    });

    layui.use('table', function () {
        var table = layui.table;
        //第一个实例
        table.render({
            elem: '#demo'
            , id: 'testReload'
            , limit: 30
            , limits: [60, 120]
            , url: '<?=Url::to(['order/list'])?>' //数据接口
            , page: true //开启分页
            , cols: [[ //表头
                {field: 'admin_name', title: '疗愈师', width: '18%', align: 'center'}
                , {field: 'day', title: '日期', width: '18%', align: 'center'}
                , {field: 'start_time', title: '开始时间', width: '18%', align: 'center'}
                , {field: 'end_time', title: '结束时间', width: '18%', align: 'center'}
                , {
                    field: 'price', title: '价格', width: '18%', align: 'center', templet: function (data) {
                        switch (data.price) {
                            case null:
                                return '随喜';
                                break;
                            case '0.00':
                                return '免费公益';
                                break;
                            default :
                                return data.price + '￥';
                                break;
                        }
                    }
                }
                , {title: '备注', align: 'center', toolbar: '#barDemo'}
            ]]
        });

        //按钮操作
        var active = {
            reload: function () {//搜索
                //执行重载
                table.reload('testReload', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    },
                    where: {
                        admin_id: $("#admin_id").val(),
                        start_time: $("#start_time").val(),
                    }
                });
            }
            , reset: function () {
                window.location.reload();
            }
        };
        layui.$('.demoTable .layui-btn').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });

        table.on('tool(test)', function (obj) {
            var data = obj.data;
            switch (obj.event) {
                case 'order':
                    if (true ==<?=$isGuest?>) {
                        layer.open({
                            content: '请先登陆！'
                            , yes: function (index, layero) {
                                window.location.href = '<?=Url::to(['site/login'])?>';
                                //do something
                                layer.close(index); //如果设定了yes回调，需进行手工关闭
                            }
                        });
                        break;
                    }
                    var string1 = '预约成功后，会将疗愈师的联系方式<br>发送至您的手机，请注意查收';
                    Math.random() * (100000)
                    var num = Math.random() * 100000 + 0;
                    num = parseInt(num, 10);
                    var string = '本次预约价格为:' + num + "￥<br>";
                    //配置一个透明的询问框
                    if (data.price == null) {
                        var str = string + string1
                    } else {
                        var str = string1;
                    }
                    layer.msg(str, {
                        time: 0 //20s后自动关闭
                        , btn: ['取消', '确定']
                        , yes: function (index, layero) {
                            layer.close(index)
                        }
                        , btn2: function (index, layero) {
                            if (data.price==null){
                                data.price=num
                            }
                            $.post('<?=Url::to(['order/order'])?>', {id: data.id, price: data.price,_csrf:'<?=Yii::$app->request->getCsrfToken()?>'}, function (data) {
                                if (data == true) {
                                    layer.msg('恭喜,预约成功.可到<span style="color: yellow">我的预约</span>查看 ');
                                } else {
                                    layer.msg('sorry,已被预约,预约失败');
                                }
                                table.reload('testReload');
                                layer.close(index)
                            });
                        }
                    });
                    break;
            }
            ;
        });
    });
</script>