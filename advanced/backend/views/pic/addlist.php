<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layout 后台大布局 - Layui</title>
    <link rel="stylesheet" href="/layui/css/layui.css">
</head>


<!-- 内容主体区域 -->

<form class="layui-form" action="" enctype="multipart/form-data" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label">图片名称</label>
        <div class="layui-input-block">
            <input type="text" name="title" required lay-verify="required" placeholder="图片名称" autocomplete="off"
                   class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">url链接</label>
        <div class="layui-input-block">
            <input type="text" name="url" required lay-verify="required" placeholder="链接名称" autocomplete="off"
                   class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">

        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="test1">
                <i class="layui-icon">&#xe67c;</i>上传图片

            </button>
            <div class="layui-upload-list">
                <input type="hidden" name="UploadForm[file]" value=""/>
                <img class="layui-upload-img" id="demo1">

                <p id="demoText"></p>
            </div>

        </div>
    </div>
    <input type="hidden" name="pic" id="file">

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
            jquery.post("http://www.admin.com/?r=pic/add_do", data.field, function (res) {
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



