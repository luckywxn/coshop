<html>
<title>消费资本--成就亿万精彩人生</title>
<link rel="stylesheet" href="/static/css/lib/iconfont/iconfont.css">
<link rel="stylesheet" href="/static/css/common.css">
<link rel="stylesheet" href="/static/css/index.css">
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/index.js"></script>
<body>

@include('index.header')

<div class="container login">
    <div class="main_box">
        <form action="/index/UserLogin" id="login_form" method="post" onsubmit="return check(this)">
            <div style="height: 50px;"></div>
            <div class="form-group">
                <img src="/static/img/user.png" width="25px" height="25px">
                <input type="text" class="form-control" height="25px" name="username" value="" placeholder="登录账号" aria-describedby="sizing-addon-user" style="vertical-align:top">
            </div>
            <div style="height: 20px;"></div>
            <div class="form-group">
                <img src="/static/img/password.png" width="25px" height="25px">
                <input type="password" class="form-control" height="25px" name="passwordhash" placeholder="登录密码" aria-describedby="sizing-addon-password" style="vertical-align:top">
            </div>

            <div class="login_msg text-center"><font color="red">{{$msg}}</font></div>
            <div style="height: 20px;"></div>
            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg btnlogin">&nbsp;登&nbsp;录&nbsp;</button>
                <button type="reset" class="btn btn-default btn-lg btnlogins">&nbsp;重&nbsp;置&nbsp;</button>
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