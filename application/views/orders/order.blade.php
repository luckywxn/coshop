<html>
<title>CoShop</title>
<link rel="stylesheet" href="/static/css/lib/iconfont/iconfont.css">
<link rel="stylesheet" href="/static/css/common.css">
<link rel="stylesheet" href="/static/css/index.css">
<link rel="stylesheet" href="/static/css/shoppingtrolley.css">
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/index.js"></script>
<body>

@include('index.header')

<!--内容区-->
<div class="container-bg">
    <div class="container">
        <!-- 确认订单信息-->
        <div class="clear"></div>
        <div class="w100r mtop45">
            <h2>确认订单信息</h2>
            <table id="trolleytab" border="1px" width="1100px" cellspacing="0" cellpadding="0" style="text-align: center">
                <tr>
                    <td>商品信息</td>
                    <td>单价</td>
                    <td>数量</td>
                    <td>小计</td>
                </tr>
                <tbody>
                @foreach($trolleys as $trolley)
                    <tr id="tr{{$trolley['sysno']}}">
                        <td width="500px"><img src="{{$trolley['path']}}/{{$trolley['name']}}" width="80px" style="margin:3px 25px;float:left;vertical-align:middle;"><span style="float: left;">{{$trolley['goodsname']}}({{$trolley['merchant_name']}})</span></td>
                        <td id="price{{$trolley['sysno']}}">{{$trolley['price']}}</td>
                        <td>{{$trolley['number']}}</td>
                        <td id="totalprice{{$trolley['sysno']}}" style="color: red">{{$trolley['totalprice']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- 确认订单信息 end-->
        <div class="clear"></div>
        <div class="jiesuandiv">
            <div class="select-all"></div>
            <div class="float-bar-right">
                <div class="price-sum">
                    <span>合计：</span>
                    <span class="order-price">￥</span>
                    <strong class="price">
                        <em id="J_Total">{{$totalprice}}</em>
                    </strong>
                </div>
                <button class="place_order" onclick="placeOrder()">提交订单</button>
            </div>
        </div>
    </div>
</div>

@include('index.footer')

</body>
</html>
<script>
    //提交订单
    function placeOrder() {

        window.location.href = "/orders/neworder";
    }

</script>