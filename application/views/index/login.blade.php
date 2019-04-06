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
        <form action="/index/UserLogin" id="login_form" method="post" onsubmit="return check(this)">
            <div style="height: 50px;"></div>
            <div class="form-group">
                <img src="/static/img/user.png" width="42px" height="42px">
                <input type="text" class="form-control" width="200px" height="25px" name="username" value="" placeholder="登录账号" aria-describedby="sizing-addon-user" style="vertical-align:top">
            </div>
            <div style="height: 20px;"></div>
            <div class="form-group">
                <img src="/static/img/password.png" width="42px" height="42px">
                <input type="password" class="form-control" width="200px" height="42px" name="passwordhash" placeholder="登录密码" aria-describedby="sizing-addon-password" style="vertical-align:top">
            </div>

            <div class="login_msg text-center"><font color="red">{{$msg}}</font></div>
            <div style="height: 20px;"></div>
            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg btnlogin">&nbsp;登&nbsp;录&nbsp;</button>
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
</script>