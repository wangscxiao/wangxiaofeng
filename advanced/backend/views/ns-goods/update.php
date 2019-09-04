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
        <input type="hidden" name="goods_id" value="<?php echo $date['goods_id']?>" autocomplete="off">
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商品名称</label>
        <div class="layui-input-block">
            <input type="text" name="goods_name" value="<?php echo $date['goods_name']?>" required lay-verify="required" placeholder="商品名称" autocomplete="off"
                   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">店铺ID</label>
        <div class="layui-input-block">
            <input type="text" name="shop_id"  value="<?php echo $date['shop_id']?>"required lay-verify="required" placeholder="店铺ID" autocomplete="off"
                   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">

        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="test1">
                <i class="layui-icon">&#xe67c;</i>上传图片

            </button>
            <div class="layui-upload-list">
                <input type="hidden" name="UploadForm[file]" />
                <img class="layui-upload-img" id="demo1" src="<?php echo $date['goods_pic'];?>" >

                <p id="demoText"></p>
            </div>

        </div>
    </div>
    <input type="hidden" name="goods_pic" id="file">

    <div class="layui-form-item">
        <label class="layui-form-label">商品规格</label>
        <div class="layui-input-block">
            <input type="text" name="goods_spec" value="<?php echo $date['goods_spec'];?>" required lay-verify="required" placeholder="商品规格" autocomplete="off"
                   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input type="text" name="sort"  value="<?php echo $date['sort'];?>" required lay-verify="required" placeholder="排序" autocomplete="off"
                   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">原价</label>
        <div class="layui-input-block">
            <input type="text" name="original_price" value="<?php echo $date['original_price'];?>" required lay-verify="required" placeholder="原价" autocomplete="off"
                   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">现价</label>
        <div class="layui-input-block">
            <input type="text" name="present_price" value="<?php echo $date['present_price'];?>" required lay-verify="required" placeholder="现价" autocomplete="off"
                   class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">父级ID</label>
        <div class="layui-input-block">
            <select name="pid" lay-verify="required">
                <option   {if $date['pid']==0} selected {/if} value="0">请选择父级</option>
                <?php
                foreach($data as $value){

                    echo  "<option value='". $value["id"]." '";
                    if($value['id']==$id){
                        echo "selected";
                    }
                    echo  "> ". $value["category_name"]."</option>";
                    if(!empty($value ["childs"])){
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
        <label class="layui-form-label">商品数量</label>
        <div class="layui-input-block">
            <input type="text" name="number" value="<?php echo $date['number'];?>" required lay-verify="required" placeholder="商品数量" autocomplete="off"
                   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">


        <label class="layui-form-label">商品详情</label>
        <div class="layui-input-block">

            <textarea id="demo" style="display: none;" name="description" value="<?php echo $date['description'];?>"><?php echo $date['description'];?></textarea>
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
            , url: "?r=ns-goods/upload"
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
            jquery.post("http://www.admin.com/?r=ns-goods/update_do", data.field, function (res) {

                if (res.code > 0) {
                    alert(22);
                    window.parent.opener.location.reload();

                } else {
                    alert(res);
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



