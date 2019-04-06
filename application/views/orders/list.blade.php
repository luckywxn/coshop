<html>
<title>CoShop</title>
<link rel="stylesheet" href="/static/css/lib/iconfont/iconfont.css">
<link rel="stylesheet" href="/static/css/common.css">
<link rel="stylesheet" href="/static/css/index.css">
<link rel="stylesheet" href="/static/css/orders.css">
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/index.js"></script>
<body>

@include('index.header')

<!--内容区-->
<div class="container">
    <!-- 订单列表-->
    <div class="clear"></div>
    <div class="w100r mtop45">
        <div class="personalcare" style="height: 600px">
            <table class="bought-table-mod__table___3u4gN">
                <tr>
                    <td width="400px">宝贝</td>
                    <td width="150px">单价</td>
                    <td width="150px">数量</td>
                    <td width="200px">实付款</td>
                    <td width="200px">交易状态</td>
                    <td width="200px">操作</td>
                </tr>
            </table>
            <div class="clear"></div>
            @foreach($orders as $order)
            <table class="bought-wrapper-mod__table___3xFFM" cellpadding="0" cellspacing="0">
                <tbody class="bought-wrapper-mod__head___2vnqo">
                <tr >
                    <td width="400px"><input type="checkbox">{{$order['created_at']}}&nbsp;&nbsp;订单号：{{$order['order_no']}}</td>
                    <td width="150px"></td>
                    <td width="150px"></td>
                    <td width="200px" style="color: red;">￥{{$order['totalprice']}}</td>
                    <td width="200px">{{$order['order_status']}}</td>
                    <td width="200px" style="text-align: center">@if($order['order_status']=="待付款") <button class="pay_order" onclick="payOrder('{{$order['order_no']}}','{{$order['totalprice']}}')">立即付款</button> @endif</td>
                </tr>
                </tbody>
                <tbody>
                @foreach($order['detail'] as $item)
                <tr>
                    <td>
                        <img src="{{$item['path'].'/'.$item['name'] }}" width="80px" style="margin:3px 25px;float:left;vertical-align:middle;">
                        <span style="float: left;">{{$item['goodsname']}}({{$item['merchant_name']}})</span>
                    </td>
                    <td>{{$item['price']}}</td>
                    <td>{{$item['number']}}</td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <br>
            @endforeach
            <form id="orderPay" style="display: none" action="/orders/payorder" method="POST">
                <input id="WIDout_trade_no" type="text" name="WIDout_trade_no" value="">
                <input id="WIDsubject" type="text" name="WIDsubject" value="">
                <input id="WIDtotal_amount" type="text" name="WIDtotal_amount" value="">
                <input id="WIDbody" type="text" name="WIDbody" value="">
            </form>
        </div>
    </div>
    <!-- 订单列表 end-->
</div>

@include('index.footer')

</body>
</html>

<script>
    function payOrder(val1,val2){
        $("#WIDout_trade_no").val(val1);
        $("#WIDsubject").val(val1);
        $("#WIDtotal_amount").val(val2);
        $("#WIDbody").val("");
        $("#orderPay").submit();
    }

</script>