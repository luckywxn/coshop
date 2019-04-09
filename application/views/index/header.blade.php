<div class="header-top">
    <div class="container">
        <div class="header-top-left"><i class="iconfont icon-phone"></i>&nbsp;亲，欢迎来到CoShop&nbsp;<a href="/">首页</a> </div>
        <div class="header-top-right">
            <span>
                @if($user)
                    <a href="###" rel="nofollow">{{$user['user_name']}}</a>
                    <a href="/index/logout" rel="nofollow">退出</a>
                @else
                <a href="/index/login" rel="nofollow">请登录</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="/index/register" rel="nofollow">免费注册</a>
                @endif
            </span>
            <span><a href="/orders/list" rel="nofollow">我的订单</a></span>
            <span><a href="/shoppingtrolley/list" rel="nofollow">购物车</a></span>
            <span><a href="#" rel="nofollow">收藏夹</a></span>
            <span><a href="#" rel="nofollow">帮助中心</a></span>
        </div>
    </div>
</div>

<div class="header-bg">
    <div class="container">
        <div class="logo"><a href="index.html"><img src="/static/img/logo.png" alt=""></a></div>
        <div class="header-box">
            <div class="w100r pull-left">
                <div class="header-search">
                    <form action="/goods/goodsList" method="POST">
                        <dl>
                            <dt><input type="text" class="form-control" name="goodsname" placeholder="搜索 商品"></dt>
                            <dd><button type="submit"><i class="iconfont icon-fangdajing"></i></button></dd>
                        </dl>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>