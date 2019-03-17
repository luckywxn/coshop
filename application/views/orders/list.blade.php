<html>
<title>消费资本--成就亿万精彩人生</title>
<link rel="stylesheet" href="/static/css/lib/iconfont/iconfont.css">
<link rel="stylesheet" href="/static/css/common.css">
<link rel="stylesheet" href="/static/css/index.css">
<link rel="stylesheet" href="/static/css/orders.css">
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/index.js"></script>
<body>

@include('index.header')

<!--内容区-->
<div class="container-bg">
    <div class="container">
        <!-- 商品详情-->
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
                    </tr>
                </table>
                <div class="clear"></div>
                @foreach($orders as $order)
                <table class="bought-wrapper-mod__table___3xFFM" cellpadding="0" cellspacing="0">
                    <tbody class="bought-wrapper-mod__head___2vnqo">
                    <tr >
                        <td width="400px"><input type="checkbox">{{$order['created_at']}}&nbsp;&nbsp;订单号：{{$order['ordersno']}}</td>
                        <td width="150px"></td>
                        <td width="150px"></td>
                        <td width="200px" style="color: red;">￥{{$order['totalprice']}}</td>
                        <td width="200px">{{$order['orderstatus']}}</td>
                    </tr>
                    </tbody>
                    <tbody>
                    @foreach($order['detail'] as $item)
                    <tr>
                        <td><img src="{{$item['path'].'/'.$item['name'] }}" width="80px" style="vertical-align:middle;"
>{{$item['goodsname']}}</td>
                        <td>{{$item['price']}}</td>
                        <td>{{$item['number']}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @endforeach

            </div>
        </div>
        <!-- 商品详情 end-->
    </div>
</div>

@include('index.footer')

</body>
</html>

<script>
    function addnum(val){
        $("#num"+val).val(parseInt($("#num"+val).val())+1);
        var num = parseInt($("#num"+val).val());
        $("#totalprice"+val).html(parseInt($("#price"+val).html())*num);

        $.ajax({
            type:"POST",
            url: "/shoppingtrolley/updatenum",
            data: {id:val,num:num},
            dataType: "json",
            success: function(option){
                console.log(option.mes);
            }
        })
    }

    function subnum(val){
        if(parseInt($("#num"+val).val())>1){
            $("#num"+val).val(parseInt($("#num"+val).val())-1);
            var num = parseInt($("#num"+val).val());
            $("#totalprice"+val).html(parseInt($("#price"+val).html())*num);

            $.ajax({
                type:"POST",
                url: "/shoppingtrolley/updatenum",
                data: {id:val,num:num},
                dataType: "json",
                success: function(option){
                    console.log(option.mes);
                }
            })
        }
    }

    function deltrolley(val){
        var index = $("#tr"+val)[0].rowIndex;
        $("#trolleytab tr:eq("+index+")").remove()

        var num = parseInt($("#num"+val).val());
        $.ajax({
            type:"POST",
            url: "/shoppingtrolley/updatenum",
            data: {id:val,num:num,isdel:1},
            dataType: "json",
            success: function(option){
                console.log(option.mes);
            }
        })
    }
</script>