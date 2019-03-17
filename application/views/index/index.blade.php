<html>
<title>消费资本--成就亿万精彩人生</title>
<link rel="stylesheet" href="/static/css/lib/iconfont/iconfont.css">
<link rel="stylesheet" href="/static/css/common.css">
<link rel="stylesheet" href="/static/css/index.css">
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/index.js"></script>
<body>

@include('index.header')

<!--行业指数-->
<div class="industry">
    <div class="container">
        <h5><img src="/static/img/industry_text.png" alt=""></h5>
        <div class="industry-box">
            <ul id="industry-div">
                <li class="icon-green">
                    <dl>
                        <dt><span ><b>5800</b></span></dt>
                        <dd>维生素C片</dd>
                    </dl>
                </li>
                <li class="icon-red">
                    <dl>
                        <dt><span ><b>6000</b></span></dt>
                        <dd>天然B族维生素片</dd>
                    </dl>
                </li>
                <li class="icon-green">
                    <dl>
                        <dt><span ><b>5800</b></span></dt>
                        <dd>维生素C片</dd>
                    </dl>
                </li>
                <li class="icon-red">
                    <dl>
                        <dt><span ><b>6000</b></span></dt>
                        <dd>天然B族维生素片</dd>
                    </dl>
                </li>
                <li class="icon-green">
                    <dl>
                        <dt><span ><b>5800</b></span></dt>
                        <dd>维生素C片</dd>
                    </dl>
                </li>
                <li class="icon-red">
                    <dl>
                        <dt><span ><b>6000</b></span></dt>
                        <dd>天然B族维生素片</dd>
                    </dl>
                </li>
                <li class="icon-green">
                    <dl>
                        <dt><span ><b>5800</b></span></dt>
                        <dd>维生素C片</dd>
                    </dl>
                </li>
                <li class="icon-red">
                    <dl>
                        <dt><span ><b>6000</b></span></dt>
                        <dd>天然B族维生素片</dd>
                    </dl>
                </li>
                <li class="icon-green">
                    <dl>
                        <dt><span ><b>5800</b></span></dt>
                        <dd>维生素C片</dd>
                    </dl>
                </li>
                <li class="icon-red">
                    <dl>
                        <dt><span ><b>6000</b></span></dt>
                        <dd>天然B族维生素片</dd>
                    </dl>
                </li>

            </ul>
        </div>
    </div>
</div>
<!--行业指数 end-->
<!--内容区-->
<div class="container-bg">
    <div class="container">
        <div class="w100r">
            <!--推荐商品 -->
            <div class="recommend">
                <div class="index-title"><h5>推荐商品</h5></div>
                <div class="w100r">
                    @foreach($Goods as $item)
                        <div class="recommend-bor">
                            <a href="#">
                                <img src="{{$item['path']}}/{{$item['name']}}">
                                <ul>
                                    <li title="">{{$item['goodsname']}}</li>
                                    <li title=""><span style="color: red;font-size: 16px"> ￥{{$item['price']}}</span></li>
                                    <li title="">供应商 | {{$item['companyname']}}</li>
                                </ul>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <!--推荐商品 end-->
            <!--热门指数-->
            {{--<div class="hot">--}}
                {{--<div class="index-title"><h5>热门指数</h5></div>--}}
                {{--<div class="hot-box highcharts">--}}
                    {{--<ul>--}}
                        {{--<li class="active">笨乙烯</li>--}}
                        {{--<li>乙二醇</li>--}}
                        {{--<li>甲醇</li>--}}
                        {{--<li>二甘醇</li>--}}
                    {{--</ul>--}}
                    {{--<div id="svgcharts"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <!-- 热门指数 end-->
        </div>
        <!-- 个人护理-->
        <div class="clear"></div>
        <div class="w100r mtop45">
            <div class="personalcare">
                <div class="index-title"><h5>个人护理</h5></div>
                <div class="w100r">
                    @foreach($Personalgoods as $item)
                        <div class="recommend-bor">
                            <a href="/goods/index/id/{{$item['sysno']}}">
                                <img src="{{$item['path']}}/{{$item['name']}}">
                                <ul>
                                    <li title="">{{$item['goodsname']}}</li>
                                    <li title=""><span style="color: red;font-size: 16px"> ￥{{$item['price']}}</span></li>
                                    <li title="">供应商 | {{$item['companyname']}}</li>
                                </ul>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- 个人护理 end-->

        <!-- 家居护理-->
        <div class="clear"></div>
        <div class="w100r mtop45">
            <div class="personalcare">
                <div class="index-title"><h5>家居护理</h5></div>
                <div class="w100r">
                    @foreach($HomeCaregoods as $item)
                        <div class="recommend-bor">
                            <a href="#">
                                <img src="{{$item['path']}}/{{$item['name']}}">
                                <ul>
                                    <li title="">{{$item['goodsname']}}</li>
                                    <li title=""><span style="color: red;font-size: 16px"> ￥{{$item['price']}}</span></li>
                                    <li title="">供应商 | {{$item['companyname']}}</li>
                                </ul>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- 家居护理 end-->
    </div>
</div>

@include('index.footer')

</body>
</html>