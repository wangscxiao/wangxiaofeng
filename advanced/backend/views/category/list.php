<?php

use yii\helpers\Html;
use backend\assets\AppAsset;

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layout 后台大布局 - Layui</title>
    <link rel="stylesheet" href="/layui/css/layui.css">
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">layui 后台布局</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">控制台</a></li>
            <li class="layui-nav-item"><a href="">商品管理</a></li>
            <li class="layui-nav-item"><a href="">用户</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">邮件管理</a></dd>
                    <dd><a href="">消息管理</a></dd>
                    <dd><a href="">授权管理</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    贤心
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="">退了</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="test">

                <li class="layui-nav-item">
                    <a href="javascript:;">列表</a>
                    <dl class="layui-nav-child">
                        <dd><a href="http://www.admin.com/?r=pic/list">轮播图列表</a></dd>
                        <dd><a href="http://www.admin.com/?r=category/list">分类表</a></dd>
                        <dd><a href="http://www.admin.com/?r=ns-goods/list">商品列表</a></dd>
                        <dd><a href="http://localhost/mvc/index.php/admin/Essay/essaylist">文章列表</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="">2</a></li>
                <li class="layui-nav-item"><a href="">3</a></li>
            </ul>
        </div>
    </div>

    <div class="layui-body">

        <div style="padding: 15px;">
            <script type="text/html" id="barDemo">


                <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            </script>
            <table id="demo" lay-filter="test"></table>
        </div>

    </div>
    <script src="/layui/layui.js"></script>

    <script>

    </script>
    <script>
        //JavaScript代码区域
        layui.use(['laydate', 'jquery', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element', 'slider'], function () {
            var laydate = layui.laydate; //日期
            var laypage = layui.laypage;//分页
            var layer = layui.layer;//弹层
            var table = layui.table;//表格
            var carousel = layui.carousel;//轮播
            var upload = layui.upload;//上传
            var element = layui.element;//元素操作
            var slider = layui.slider;
            var jquery = layui.jquery;//滑块


            table.render({

                //执行一个 table 实例
                elem: '#demo'
                , height: 420
                , page: true //开启分页
                , toolbar: 'default' //开启工具栏，此处显示默认图标，可以自定义模板，详见文档
                , totalRow: true //开启合计行
                , url: "http://www.admin.com/?r=category/list_do" //数据接口
                , page: true //开启分页
                , cols: [[ //表头
                    {type: 'checkbox', fixed: 'left'}
                    , {field: 'id', title: 'ID', width: 80, sort: true, fixed: 'left'}
                    , {field: 'category_name', title: '分类名称', width: 110, edit: 'text', sort: true}
                    , {field: 'pid', title: '父级ID', width: 80}
                    , {field: 'level', title: '等级别', width: 110}
                    , {field: 'sort', title: '排序', width: 110}

                    , {fixed: 'right', title: '操作', width: 165, align: 'center', toolbar: '#barDemo'}

                ]]

            });

            table.on('edit(test)', function (obj) {
                var value = obj.value //得到修改后的值
                    , data = obj.data//得到所在行的所有键
                    , field = obj.field;//得到字段
                jquery.ajax({
                    url: "{:url('admin/News/update_two')}",
                    data: {id: data.id, field: field, value: value},
                    type: "post",
                    success: function (res) {
                        if (res == 1) {
                            layer.msg('[ID:' + data.id + ']' + field + '字段更改为:' + value);
                        } else {
                            layer.msg('[ID:' + data.id + ']' + field + '字段更该失败');
                        }
                    }
                });
            });

            table.on('toolbar(test)', function (obj) {
                var checkStatus = table.checkStatus(obj.config.id)
                    , data = checkStatus.data; //获取选中的数据
                console.log(data);
                var ids = [];
                for (let index in data) {
                    ids[index] = data[index]['id'];

                }


                switch (obj.event) {
                    case 'add':
                        layer.open({
                            type: 2,
                            content: "http://www.admin.com/?r=category/add_list", //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
                            area: ['600px', '500px'],
                            scrollbar: true,

                            cancel: function (index, layero) {
                                if (confirm('确定要关闭么')) {
                                    //只有当点击confirm框的确定时，该层才会关闭

                                    layer.close(index)
                                }
                                return false;
                            }

                        });

                        break;


                    case 'update':
                        if (data.length === 0) {
                            layer.msg('请选择一行');
                        } else if (data.length > 1) {
                            layer.msg('只能同时编辑一个');
                        } else {
                            layer.open({
                                type: 2,
                                content: "{:url('admin/News/update')}?id=" + checkStatus.data[0].id, //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
                                area: ['700px', '600px'],
                                cancel: function (index, layero) {
                                    if (confirm('确定要关闭么')) { //只有当点击confirm框的确定时，该层才会关闭
                                        layer.close(index)
                                    }
                                    return false;
                                }
                            });
                            // layer.alert('编辑 [id]：'+ checkStatus.data[0].id);
                        }
                        break;
                    case 'delete':
                        if (data.length === 0) {
                            layer.msg('请选择一行');
                        } else {
                            layer.confirm('真的删除行', function (index) {
                                //批删前台显示效果？？？？？？？？？？？
                                //obj.parens('tr').remove();
                                jquery.ajax({
                                    url: "{:url('admin/News/delete')}",    //换成自己的url
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        id: ids
                                    },
                                    success: function (e) {
                                        layer.msg(e.msg);
                                        window.location.reload();
                                    },
                                    error: function (e) {
                                        layer.msg(e);
                                    }
                                })
                            });
                        }
                        break;
                }
                ;
            });
            table.on('tool(test)', function (obj) {
                //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    , layEvent = obj.event; //获得 lay-event 对应的值
                if (layEvent === 'detail') {
                    layer.msg('查看操作');
                } else if (layEvent === 'del') {
                    layer.confirm('真的删除么', function (index) {
                        jquery.ajax({
                            url: "http://www.admin.com/?r=category/delete",
                            type: "POST",
                            //获取到obj对象里面data里的id作为删除条件
                            data: {id: data.id},
                            success: function (msg) {
                                if (msg == 200) {
                                    //删除这一行
                                    obj.del();
                                    //关闭弹窗
                                    layer.msg('删除成功', {icon: 1});
                                    layer.close(index);
                                } else {
                                    layer.msg('删除失败', {icon: 2});
                                }
                            }
                        });
                        return false;
                        /* obj.del(); //删除对应行（tr）的DOM结构
                         layer.close(index);*/
                        //向服务端发送删除指令
                    });
                } else if (obj.event === 'edit') {
                    // alert(data.id);
                    layer.open({
                        type: 2,
                        content: "http://www.admin.com/?r=category/update/&id=" + data.id, //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
                        area: ['800px', '600px'],

                        cancel: function (index, layero) {
                            if (confirm('确定要关闭么')) { //只有当点击confirm框的确定时，该层才会关闭
                                layer.close(index)
                            }
                            return false;
                        }
                    });
                } else if (obj.event === 'add') {
                    layer.open({
                        type: 2,
                        content: "{:url('admin/News/add')}?id=" + data.id, //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
                        area: ['800px', '600px'],
                        cancel: function (index, layero) {
                            if (confirm('确定要关闭么')) { //只有当点击confirm框的确定时，该层才会关闭
                                layer.close(index)
                            }
                            return false;
                        }
                    });
                }
            });

        });


    </script>
</body>
</html>