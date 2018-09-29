<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>注册页</title>
    <link rel="stylesheet" type="text/css" href="/style/admin/layui/css/layui.css">
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/style/admin/layui/layui.js"></script>
    <link rel="stylesheet" href="/style/admin/style.css">
</head>
<body>
 
<div class="login-main">
    <header class="layui-elip" style="width: 82%">注册页</header>
 
    <!-- 表单选项 -->
    <form class="layui-form">
        <div class="layui-input-inline">
            <!-- 用户名 -->
            <div class="layui-inline" style="width: 85%">
                <input type="text" id="username" name="username" required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
            </div>
            <!-- 对号 -->
            <div class="layui-inline">
                <i class="layui-icon" id="ri" style="color: green;font-weight: bolder;" hidden></i>
            </div>
            <!-- 错号 -->
            <div class="layui-inline">
                <i class="layui-icon" id="wr" style="color: red; font-weight: bolder;" hidden>ဆ</i>
            </div>
        </div>
            <!-- 密码 -->
        <div class="layui-input-inline">
            <div class="layui-inline" style="width: 85%">
                <input type="password" id="pwd" name="password" required  lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
            <!-- 对号 -->
            <div class="layui-inline">
                <i class="layui-icon" id="pri" style="color: green;font-weight: bolder;" hidden></i>
            </div>
            <!-- 错号 -->
            <div class="layui-inline">
                <i class="layui-icon" id="pwr" style="color: red; font-weight: bolder;" hidden>ဆ</i>
            </div>
        </div>
            <!-- 确认密码 -->
        <div class="layui-input-inline">
            <div class="layui-inline" style="width: 85%">
                <input type="password" id="repwd" name="repassword" required  lay-verify="required" placeholder="请确认密码" autocomplete="off" class="layui-input">
            </div>
            <!-- 对号 -->
            <div class="layui-inline">
                <i class="layui-icon" id="rpri" style="color: green;font-weight: bolder;" hidden></i>
            </div>
            <!-- 错号 -->
            <div class="layui-inline">
                <i class="layui-icon" id="rpwr" style="color: red; font-weight: bolder;" hidden>ဆ</i>
            </div>
        </div>
 
 
        <div class="layui-input-inline login-btn" style="width: 85%">
            <button type="submit" lay-submit lay-filter="sub" class="layui-btn">注册</button>
        </div>
        <hr style="width: 85%" />
        <p style="width: 85%"><a href="login" class="fl">已有账号？立即登录</a><a href="javascript:;" class="fr">忘记密码？</a></p>
    </form>
</div>
<script type="text/javascript">
    layui.use(['form','jquery','layer'], function () {
        var form   = layui.form;
        var $      = layui.jquery;
        var layer  = layui.layer;
        //添加表单失焦事件
        //验证表单
        $('#username').blur(function() {
            var username = $(this).val();
 
            //alert(user);
            $.ajax({
                url:'register',
                type:'post',
                dataType:'json',
                data:{username:username,"_token":"{{csrf_token()}}"},
                //验证用户名是否可用
                success:function(res){
                  console.log(res.errcode)
                    if (res.errcode==0) {
                        $('#ri').removeAttr('hidden');
                        $('#wr').attr('hidden','hidden');
                    } else {
                        $('#wr').removeAttr('hidden');
                        $('#ri').attr('hidden','hidden');
                        layer.msg(res.errmsg)    
                    }
                }
            })
 
        });
 
        // you code ...
        // 为密码添加正则验证
        $('#pwd').blur(function() {
                var reg = /^[\w]{6,12}$/;
                if(!($('#pwd').val().match(reg))){
                    //layer.msg('请输入合法密码');
                    $('#pwr').removeAttr('hidden');
                    $('#pri').attr('hidden','hidden');
                    layer.msg('请输入合法密码');
                }else {
                    $('#pri').removeAttr('hidden');
                    $('#pwr').attr('hidden','hidden');
                }
        });
 
        //验证两次密码是否一致
        $('#rpwd').blur(function() {
                if($('#pwd').val() != $('#rpwd').val()){
                    $('#rpwr').removeAttr('hidden');
                    $('#rpri').attr('hidden','hidden');
                    layer.msg('两次输入密码不一致!');
                }else {
                    $('#rpri').removeAttr('hidden');
                    $('#rpwr').attr('hidden','hidden');
                };
        });
 
        //
        //添加表单监听事件,提交注册信息
        form.on('submit(sub)', function() {
            $.ajax({
                url:'register',
                type:'post',
                dataType:'json',
                data:{
                    username:$('#username').val(),
                    password:$('#pwd').val(),
                    '_token':"{{csrf_token()}}",
                    is_sub:1
                },
                success:function(res){
                    if (res.errcode == 0) {
                        layer.msg('注册成功');
                    }else {
                        layer.msg('注册失败');
                    }
                }
            })
            //防止页面跳转
            return false;
        });
 
    });
</script>
</body>
</html>