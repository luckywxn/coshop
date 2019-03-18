<html>
<title>CoShop</title>
<link rel="stylesheet" href="/static/css/lib/iconfont/iconfont.css">
<link rel="stylesheet" href="/static/css/common.css">
<link rel="stylesheet" href="/static/css/index.css">
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/index.js"></script>
<body>

@include('index.header')

<!--内容区-->
<div class="container-bg">
    <div class="container">
        <div class="w100r">
            <!--推荐商品 -->
            <div class="recommend">
                <div class="index-title"><h5>推荐商品</h5></div>
                <div class="w100r">
                    @foreach($recommendGoods as $item)
                        <div class="recommend-bor">
                            <a href="/goods/index/id/{{$item['sysno']}}">
                                <img src="{{$item['path']}}/{{$item['name']}}">
                                <ul>
                                    <li title="">{{$item['goodsname']}}</li>
                                    <li title=""><span style="color: red;font-size: 16px"> ￥{{$item['price']}}</span></li>
                                    <li title="">商户名称 | {{$item['merchant_name']}}</li>
                                </ul>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- 热销商品-->
        <div class="clear"></div>
        <div class="w100r mtop45">
            <div class="personalcare">
                <div class="index-title"><h5>热销商品</h5></div>
                <div class="w100r">
                    @foreach($hotGoods as $item)
                        <div class="recommend-bor">
                            <a href="/goods/index/id/{{$item['sysno']}}">
                                <img src="{{$item['path']}}/{{$item['name']}}">
                                <ul>
                                    <li title="">{{$item['goodsname']}}</li>
                                    <li title=""><span style="color: red;font-size: 16px"> ￥{{$item['price']}}</span></li>
                                    <li title="">商户名称 | {{$item['merchant_name']}}</li>
                                </ul>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- 热销商品 end-->
    </div>
</div>

@include('index.footer')

</body>
</html>