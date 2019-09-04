<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>



<link rel="stylesheet" href="/layui/css/layui.css">
<!-- 内容主体区域 -->

<form class="layui-form" action="" enctype="multipart/form-data" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label">分类名称</label>
        <div class="layui-input-block">
            <input type="text" name="category_name" required lay-verify="required" placeholder="分类名称" autocomplete="off"
                   class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">级别</label>
        <div class="layui-input-block">
            <select name="city" lay-verify="required">
                <option value=""></option>
                <option value="1">一级</option>
                <option value="2">二级</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">父级ID</label>
        <div class="layui-input-block">
            <select name="pid" lay-verify="required">
                <option value="0">0</option>
                <?php
                    foreach($data as $value){
                        echo  "<option value='". $value["id"]." '> ". $value["category_name"]."</option>";
                        if(!empty($value["childs"])){
                            foreach ($value["childs"] as $value2){
                                echo  "<option value='". $value2["id"]."'>&nbsp;&nbsp;". $value2["category_name"]."</option>";
                            }
                        }
                    }
                ?>

            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input type="text" name="sort" required lay-verify="required" placeholder="排序" autocomplete="off"
                   class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo" id="test9">立即提交</button>
        </div>
    </div>
</form>

</div>


<script src="/layui/layui.js"></script>

<script>
    layui.use('laydate', function () {
        var laydate = layui.laydate;
        laydate.render({
            elem: '#test'
        });
    });

</script>
<script>
    //Demo

    layui.use(['form', 'upload', 'jquery', 'layedit'], function () {
        var upload = layui.upload;
        var form = layui.form;
        var jquery = layui.jquery;
        var layedit = layui.layedit;
        var desc = layedit.build('demo');
        //普通图片上传
        upload.render({
            elem: '#test1'
            , url: "?r=pic/upload"
            , auto: true
            , before: function (obj) {

                //预读本地文件示例，不支持ie8
                obj.preview(function (index, file, result) {
                    jquery('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            , done: function (res, index, upload) {

                if (res.code < 0) {
                    alert(res.message);
                } else {
                    jquery('#file').attr('value', res.data);
                }
            }
        });


        //监听提交
        form.on('submit(formDemo)', function (data) {

            data.field.desc = layedit.getContent(desc);
            jquery.post("http://www.admin.com/?r=category/add_do", data.field, function (res) {
                alert(res);
                if (res.code < 0) {
                    window.parent.opener.location.reload();

                } else {

                    //弹出框  关闭后刷新，停留在当前页
                    window.parent.location.reload();

                }

                //location.href = "http://www.admin.com/?r=pic/list";

            });
            return false;
        });

    });


</script>

<style>
    .layui-upload-img {
        width: 100px;
        height: 100px;
    }
</style>



