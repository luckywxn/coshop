<html>
<title>CoShop</title>
<link rel="stylesheet" href="/static/css/lib/iconfont/iconfont.css">
<link rel="stylesheet" href="/static/css/common.css">
<link rel="stylesheet" href="/static/css/goods.css">
<link rel="stylesheet" href="/static/css/index.css">
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/index.js"></script>
<body>

@include('index.header')

<!--内容区-->
<div class="container-bg">
    <div class="container">
        <input type="hidden" id="member_no" name="member_no" value="{{$user['member_no']}}">
        <!-- 商品详情-->
        <div class="clear"></div>
        <div class="w100r mtop45">
            <div class="personalcare">
                <div class="index-title"><h5>商品详情</h5></div>
                <div class="w100r">
                    <div class="recommend-bor">
                        <img src="{{$path}}/{{$name}}">
                        <p class="tm-action">
                            <a class="favorite" onclick="favoritegood()"><i class="icon-pingjia"></i><span>收藏商品</span></a>
                            <a class="favShop" onclick="favoriteMerchant()"><span>收藏店铺</span></a>
                        </p>
                    </div>

                    <div style="margin: 20px 100px;float: left" >
                        <input type="hidden" id="goods_sysno" value="{{$sysno}}">
                        <input type="hidden" id="merchant_sysno" value="{{$merchant_sysno}}">
                        <p style="font-size: 20px">{{$goodsname}}</p>
                        <br>
                        <p style="font-size: 16px;color: red">￥{{$price}}</p>
                        <br>
                        <p style="font-size: 12px">数量：
                            <input type="button" style="width: 15px" value="-" onclick="subnum()">
                            <input type="text" id="detailgood" size="2" value="1" style="text-align: center">
                            <input type="button" style="width: 15px" value="+" onclick="addnum()">
                        </p>
                        <br>
                        <button>立即购买</button>&nbsp;&nbsp;<button onclick="addtrolley()">加入购物车</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- 商品详情 end-->
    </div>
</div>

@include('index.footer')

</body>
</html>
<script>
    //购物车数量增加
    function addnum(){
        $("#detailgood").val(parseInt($("#detailgood").val())+1);
    }
    //购物车数量减少
    function subnum(){
        if(parseInt($("#detailgood").val())>1) {
            $("#detailgood").val(parseInt($("#detailgood").val()) - 1);
        }
    }
    //添加商品到购物车
    function addtrolley(){
        var member_no =  $("#member_no").val();
        if(!member_no){
            alert("请先登录");
            return false;
        }
        var goods_sysno = $("#goods_sysno").val();
        var num = parseInt($("#detailgood").val());
        $.ajax({
            type:"POST",
            url: "/goods/addtrolley",
            data: {member_no:member_no,goods_sysno:goods_sysno,num:num},
            dataType: "json",
            success: function(option){
                alert(option.mes)
            }
        })
    }
    //收藏商品
    function favoritegood() {
        var member_no =  $("#member_no").val();
        if(!member_no){
            alert("请先登录");
            return false;
        }
        var collect_type = 1;
        var collect_sysno = $("#goods_sysno").val();
        $.ajax({
            type:"POST",
            url: "/favorite/addfavorite",
            data: {member_no:member_no,collect_type:collect_type,collect_sysno:collect_sysno},
            dataType: "json",
            success: function(option){
                alert(option.mes)
            }
        })
    }
    //收藏店铺
    function favoriteMerchant() {
        var member_no =  $("#member_no").val();
        if(!member_no){
            alert("请先登录");
            return false;
        }
        var collect_type = 2;
        var collect_sysno = $("#merchant_sysno").val();
        $.ajax({
            type:"POST",
            url: "/favorite/addfavorite",
            data: {member_no:member_no,collect_type:collect_type,collect_sysno:collect_sysno},
            dataType: "json",
            success: function(option){
                alert(option.mes)
            }
        })
    }


</script>