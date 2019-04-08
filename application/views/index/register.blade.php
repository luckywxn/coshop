<html>
<title>消费资本--成就亿万精彩人生</title>
<link rel="stylesheet" href="/static/css/lib/iconfont/iconfont.css">
<link rel="stylesheet" href="/static/css/common.css">
<link rel="stylesheet" href="/static/css/index.css">
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/index.js"></script>
<style type="text/css">
    html, body { height: 100%; overflow: hidden; }
    body {
        font-family: "Verdana", "Tahoma", "Lucida Grande", "Microsoft YaHei", "Hiragino Sans GB", sans-serif;
        background: url('/static/images/loginbg_03.jpg') no-repeat center center fixed;
        background-size: cover;
    }
    .form-control{height:42px;}
    .main_box{position:absolute; top:45%; left:65%; margin:-200px 0 0 -180px; padding:15px 20px; width:150px; height:350px; min-width:320px; background:#FAFAFA; background:rgba(255,255,255,0.5); box-shadow: 1px 2px 8px rgba(255,255,255,0.5); border-radius:6px;}
    .login_msg{height:30px;}
    .input-group >.input-group-addon.code{padding:0;}
    #captcha_img{cursor:pointer;}
    .main_box .logo img{height:35px;}
    @media (min-width: 768px) {
        .main_box {margin-left:-200px; padding:15px 55px; width:350px;}
        .main_box .logo img{height:50px;}
    }
</style>
<body>

@include('index.header')

<div class="container login">
    <div class="main_box">
        <form action="/index/registerJson" id="register_form" method="post" onsubmit="return check(this)">
            <div style="height: 50px;"></div>
            <div class="form-group">
                <img src="/static/img/user.png" width="42px" height="42px">
                <input id="phone" type="text" class="form-control" width="200px" height="25px" name="username" value="" placeholder="登录账号" aria-describedby="sizing-addon-user" style="vertical-align:top">
            </div>

            <div style="height: 20px;"></div>
            <div class="form-group">
                <img src="/static/img/password.png" width="42px" height="42px">
                <input type="password" class="form-control" width="200px" height="42px" name="passwordhash" placeholder="登录密码" aria-describedby="sizing-addon-password" style="vertical-align:top">
            </div>

            <div style="height: 20px;"></div>
            <div class="form-group">
                <input type="text" class="captcha" height="42px" name="captcha" placeholder="验证码" aria-describedby="sizing-addon-password" style="vertical-align:top">
                <input id="sendcode" type="button" style="display: inline-block;width: 68px" value="发送验证码">
            </div>

            <div class="login_msg text-center"><font color="red" id="msg">{{$msg}}</font></div>
            <div style="height: 20px;"></div>
            <div class="text-center">
                <button type="button" onclick="resgister()" class="J_Submit">&nbsp;注&nbsp;册&nbsp;</button>
            </div>
        </form>
    </div>
</div>
@include('index.footer')

</body>
</html>
<script>
    function check(form){
        if(form.username.value==''){
            alert("请输入用户名");
            form.username.focus();
            return false;
        }
        if(form.passwordhash.value==''){
            alert("请输入登录密码");
            form.passwordhash.focus();
            return false;
        }
    }
    var InterValObj;
    var curCount;
    $("#sendcode").click(function (){
        curCount = 90;
        var phone = $("#phone").val();
        if(phone){
            $.ajax({
                url:'index/sendcode',
                data:{ phone:phone},
                type:'POST',
                success:function(options){
                    var parsedJson = jQuery.parseJSON(options);
                    if(parsedJson.resp.respCode=='000000'){
                        $("#sendcode").attr("disabled","disabled");
                        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
                    }else{
                        console.log(parsedJson.resp.respCode);
                    }
                }
            });
        }
    });
    //timer处理函数
    function SetRemainTime() {
        if (curCount == 0) {
            window.clearInterval(InterValObj);//停止计时器
            $("#sendcode").removeAttr("disabled");//启用按钮
            $("#sendcode").val("发送验证码");
        }else {
            curCount--;
            $("#sendcode").val("(" + curCount + ")");
        }
    }

    //注册
    function resgister() {
        $.ajax({
            url:'index/registerJson',
            data: $('#register_form').serialize(),
            dataType: "json",//预期服务器返回的数据类型
            type:'POST',
            success:function(result){
                console.log(result);
                if(result['code']=="200"){
                    alert(result['mes']);
                    window.location = "/index/login";
                }else {
                    $("#msg").html(result['mes']);
                }
            }
        });
    }

</script>