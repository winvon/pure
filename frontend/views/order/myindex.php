<?php

use yii\helpers\Url;
use common\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = 'Orders';
?>
<style>
    .toCompany {
        padding-top: 20px;
        padding-left: 30px;
        padding-right: 30px;
    }

    .cont {
        background-color: lightgray;
    }
</style>
<div class="row" style="height:900px">
    <div class="col-sm-12">
        <h3>我的预约</h3>
        <table id="demo" lay-filter="test"></table>
    </div>
</div>

<div id="pay-inline">
    <div class="row">
        <div class="toCompany">
            <div class="methodname">
                对公账号
            </div>
            <div class="cont">
                户&nbsp;&nbsp;&nbsp;名:&nbsp;杭州云片网络科技有限公司<br>
                开户行:&nbsp;招商银行股份有限公司杭州城西支行<br>
                账&nbsp;&nbsp;&nbsp;号:&nbsp;571907256210702
            </div>
            <div class="layui-upload" style="margin-top: 20px">
                <div class="layui-form-item">
                    <label style="float: left;padding-top: 9px;padding-right: 9px">打款金额:</label>
                    <div class="layui-input-inline">
                        <input style="width: 190px" type="number" id="pay" name="pay" lay-verify="required"
                               placeholder="请输入转账金额￥(元)" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <button type="button" class="layui-btn" id="test1">上传支付截图</button>
                <div class="layui-upload-list">
                    <img height="160px" width="160px" class="layui-upload-img" id="demo1">
                    <p id="demoText"></p>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    function delPic(file) {
        $.post('<?=Url::to(['public/del-pic'])?>', {path: file})
    }

    layui.use('upload', function () {
        var $ = layui.jquery
            , upload = layui.upload;

        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            , url: '<?=Url::to(['public/upload'])?>'
            , before: function (obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function (index, file, result) {
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            , done: function (res) {
                console.log(res.code);
                //如果上传失败
                if (res.code > 0) {
                    layer.msg('上传失败');
                }
                if (res.code == 0) {
                    if (typeof path != "undefined") {
                        delPic(path);
                    }
                    path = res.data.src;
                }
                //上传成功
            }
            , error: function () {
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function () {
                    uploadInst.upload();
                });
            }
        });
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
            , url: '<?=Url::to(['order/my-list'])?>' //数据接口
            , page: true //开启分页,
            , where: {
                user_id:<?=Yii::$app->user->identity->id?>
            }
            , cols: [[ //表头
                {field: 'admin_name', title: '疗愈师', width: '10%', align: 'center'}
                , {field: 'admin_telephone', title: '电话', width: '12%', align: 'center'}
                , {field: 'admin_telephone', title: '微信', width: '10%', align: 'center'}
                , {field: 'day', title: '日期', width: '10%', align: 'center'}
                , {field: 'start_time', title: '开始时间', width: '8%', align: 'center'}
                , {field: 'end_time', title: '结束时间', width: '8%', align: 'center'}
                , {
                    field: 'price', title: '价格', width: '10%', align: 'center', templet: function (data) {
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
                , {
                    field: 'pay', title: '已支付', width: '12%', align: 'center', templet: function (data) {
                        if (data.price == '0.00') {
                            return '-';
                        }
                        return '<a class="layui-btn layui-btn-primary layui-btn-xs" data-type="auto" title="查看支付记录" lay-event="pay-info" style="margin-left: 10px">' + data.pay + '￥</a>';
                    }
                }
                , {
                    field: 'pay_status', title: '支付', width: '10%', align: 'center', templet: function (data) {
                        switch (data.pay_status) {
                            case <?=Order::PAY_STATUS_PAY?>:
                            case <?=Order::PAY_STATUS_PAYING?>:
                                if (data.price == '0.00') {
                                    return '-';
                                } else {
                                    return '<a class="layui-btn   layui-btn-xs" lay-event="pay-inline" title="线下支付" style="">线下</a>' +
                                        '<a class="layui-btn   layui-btn-xs" lay-event="pay" title="微信支付" style="margin-left: 10px">微信</a>'
                                }
                                ;
                                break;
                            case <?=Order::PAY_STATUS_PAYED?>:
                                return '已支付';
                                break;
                        }
                    }
                }
                , {
                    title: '备注', align: 'center', templet: function (data) {
                        switch (data.status) {
                            case <?= Order::STATUS_WAIT_ORDER?>:
                            case <?= Order::STATUS_ORDER?>:
                                if (data.price == '0.00') {
                                    return '<span style="font-size: 12px">已预约</span>' +
                                        '<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="cancel" style="margin-left: 10px">取消</a>';
                                } else {
                                    if (data.pay_status ==<?= Order::PAY_STATUS_PAY?>) {
                                        return '<span style="font-size: 12px">已预约</span>' +
                                            '<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="cancel" style="margin-left: 10px">取消</a>';
                                    } else {
                                        return '<span style="font-size: 12px">已预约</span>'
                                    }
                                }
                                break;
                            case <?= Order::STATUS_FINISH?>:
                                return '<span style="font-size: 12px">已完成</span>';
                                break;
                        }
                    }
                }
            ]]
        });


        table.on('tool(test)', function (obj) {
            var data = obj.data;
            switch (obj.event) {

                case 'pay-info':

                    var content = '';
                    $.ajaxSetup({
                        async: false //取消异步
                    });
                    $.get('<?=Url::to(['pay/get-pay-info'])?>', {'order_id': data.id}, function (data) {
                       var content0='';
                        data.forEach(function (value,i) {
                            content0+="<tr><th>"+value.pay_money+"</th><th>"+value.pay_type+"</th><th><img style='height: 20px'   src="+value.pay_img+"></th><th>"+value.status+"</th><th>"+value.created_at+"</th></tr>"
                        });
                       content= "<table class='table'>" +
                       "<tr><th>支付金额</th><th>支付方式</th><th>支付凭证</th><th>支付状态</th><th>提交时间</th></tr>" +
                           content0+
                       "</table>"
                    });

                    var type = 'auto';
                    layer.open({
                        type: 1
//                        , time: 10000
                        , time: 0
                        , area: 'auto'
                        , maxWidth: '600px'
                        , title: '支付记录'
                        , offset: type //具体配置参考：http://www.layui.com/doc/modules/layer.html#offset
                        , id: 'layerDemo' + type //防止重复弹出
                        , content: content
                        , btn: '关闭'
                        , btnAlign: 'c' //按钮居中
                        , shade: 0 //不显示遮罩
                        , yes: function () {
                            layer.closeAll();
                        }
                    });
                    break;
                case 'cancel':
                    layer.msg('点击<span style="color:red">确定</span>,取消本次预约', {
                        icon: 2,
                        time: 0 //20s后自动关闭
                        , btn: ['取消', '<span style="color:red">确定</span>']
                        , yes: function (index, layero) {
                            layer.close(index)
                        }
                        , btn2: function (index, layero) {
                            $.get('<?=Url::to(['order/cancel'])?>', {id: data.id}, function () {
                                layer.msg('已取消');
                                table.reload('testReload')
                            });
                            layer.close(index)
                        }
                    });
                    break;
                case 'finish-pay':
                    layer.msg('点击<span style="color:red">确定</span>,取消本次预约', {
                        icon: 2,
                        time: 0 //20s后自动关闭
                        , btn: ['取消', '<span style="color:red">确定</span>']
                        , yes: function (index, layero) {
                            layer.close(index)
                        }
                        , btn2: function (index, layero) {
                            $.get('<?=Url::to(['order/cancel'])?>', {id: data.id}, function () {
                                layer.msg('已取消');
                                table.reload('testReload')
                            });
                            layer.close(index)
                        }
                    });
                    break;
                case 'pay-inline':
                    var index = layer.open({
                            type: 1,
                            title: '线下支付',
                            shade: false,
                            area: ['330px', '400px'],
                            maxmin: false,
                            content: $('#pay-inline'),
                            btn: ['确定', '取消'],
                            zIndex: layer.zIndex, //重点1
                            success: function (layero) {
                                layer.setTop(layero); //重点2
                            },
                            yes: function () {
                                if (parseInt($('#pay').val()) > 0) {
                                } else {
                                    alert('请输入打款金额');
                                    return;
                                }
                                if (typeof path == "undefined") {
                                    alert('请上传支付凭证');
                                } else {
                                    $.post('<?=Url::to(['pay/pay-inline'])?>', {
                                        _csrf: "<?=Yii::$app->request->getCsrfToken()?>",
                                        id: data.id,
                                        pay: $('#pay').val(),
                                        img: path
                                    }, function (data) {
                                        if (data === true) {
                                            layer.msg('上传成功，待后台确认')
                                        } else {
                                            layer.msg('上传失败')
                                        }
                                        layer.close(index);
                                    });
                                }
                            },
                            btn2: function () {
                                if (typeof path != "undefined") {
                                    delPic(path);
                                }
                            },
                            cancel: function () {
                                if (typeof path != "undefined") {
                                    delPic(path);
                                }
                            }
                        }
                        )
                    ;
                    break;
            }
            ;
        });
    });
</script>