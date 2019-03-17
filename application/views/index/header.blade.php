<div class="header-top">
    <div class="container">
        <div class="header-top-left"><i class="iconfont icon-phone"></i>&nbsp;亲，欢迎来到Small&nbsp;<a href="/">首页</a> </div>
        <div class="header-top-right">
            <span>
                @if($user)
                    <a href="###" rel="nofollow">{{$user['nickname']}}</a>
                    <a href="/index/logout" rel="nofollow">退出</a>
                @else
                <a href="/index/login" rel="nofollow">请登录</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="###" rel="nofollow">免费注册</a>
                @endif
            </span>
            <span><a href="/orders/list" rel="nofollow">我的订单</a></span>
            <span><a href="/shoppingtrolley/list" rel="nofollow">购物车</a></span>
            <span><a href="#" rel="nofollow">帮助中心</a></span>
        </div>
    </div>
</div>

<div class="header-bg">
    <div class="container">
        <div class="logo"><a href="index.html"><img src="/static/img/logo.png" alt=""></a></div>
        <div class="header-box">
            <div class="w100r pull-left">
                <div class="header-volume">
                    <dl>
                        <dt>本年成交量</dt>
                        <dd>888亿</dd>
                    </dl>
                    <dl>
                        <dt>本月成交量</dt>
                        <dd>66亿</dd>
                    </dl>
                </div>
                <div class="header-search">
                    <dl>
                        <dt><input type="text" class="form-control" placeholder="搜索 商家/商品"></dt>
                        <dd><button type="button"><i class="iconfont icon-fangdajing"></i></button></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>