<html>
<title>消费资本--成就亿万精彩人生</title>
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
        <!-- 商品详情-->
        <div class="clear"></div>
        <div class="w100r mtop45">
            <div class="personalcare">
                <table id="trolleytab" border="1px" width="1100px" cellspacing="0" cellpadding="0" style="text-align: center">
                    <tr>
                        <td><input type="checkbox" onclick="selectAll()">全选</td>
                        <td>商品信息</td>
                        <td>单价</td>
                        <td>数量</td>
                        <td>金额</td>
                        <td>操作</td>
                    </tr>
                    <tbody>
                    @foreach($trolleys as $trolley)
                    <tr id="tr{{$trolley['sysno']}}">
                        <td width="80px"><input type="checkbox"></td>
                        <td width="500px"><img src="{{$trolley['path']}}/{{$trolley['name']}}" width="80px" style="vertical-align:middle;">{{$trolley['goodsname']}}({{$trolley['companyname']}})</td>
                        <td id="price{{$trolley['sysno']}}">{{$trolley['price']}}</td>
                        <td>
                            <input type="button" style="width: 15px" value="-" onclick="subnum({{$trolley['sysno']}})">
                            <input type="text" style="text-align: center" size="2" id="num{{$trolley['sysno']}}" value="{{$trolley['number']}}">
                            <input type="button" style="width: 15px" value="+" onclick="addnum({{$trolley['sysno']}})"></td>
                        <td id="totalprice{{$trolley['sysno']}}" style="color: red">{{$trolley['price']*$trolley['number']}}</td>
                        <td><input type="button" value="删除" onclick="deltrolley({{$trolley['sysno']}})"></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
        <!-- 商品详情 end-->
        <div class="clear"></div>
        <div class="jiesuandiv">
            <div class="select-all"></div>
            <div class="float-bar-right">

                <div class="amount-sum">
                    {{--<span>已选商品</span>--}}
                    {{--<em id="J_SelectedItemsCount">0</em>--}}
                    {{--<span>件</span>--}}
                </div>
                <div class="price-sum">
                    <span>合计（不含运费）：</span>
                    <strong class="price">
                        <em id="J_Total">0.00</em>
                    </strong>
                </div>
                <button class="jiesuan">结算</button>
            </div>
        </div>
    </div>
</div>

@include('index.footer')

</body>
</html>
<script>
    //全选、全不选
    function selectAll() {
        if ($("input[type='checkbox']").get(0).checked) {
            $("input[type='checkbox']").prop("checked","checked");
            var data = [];
            var totalprice = 0;
            $("#trolleytab tbody tr").each(function(trindex,tritem){//遍历每一行
               if(trindex!=0){
                   $(tritem).find('td').each(function(tdindex,tditem) {
                       if (tdindex==4) {
                           data[trindex] = tditem.innerHTML;
                       }
                   });
               }else{
                   data[trindex] = 0;
               }
            });
            for(var i=0;i<data.length;i++){
                totalprice += parseFloat(data[i]);
            }
            $("#J_Total").html(totalprice);
        } else {
            $("input[type='checkbox']").prop("checked","");
            $("#J_Total").html("0.00");
        }
    }

    $("input[type='checkbox']").click(function (){
        var data = [];
        var totalprice = 0;
        $("input[type='checkbox']").each(function(option){//遍历每一行
            if(option!=0){
                if( $("input[type='checkbox']").get(option).checked){
                    $("#trolleytab tbody tr").each(function(trindex,tritem){//遍历每一行
                        if(trindex==option){
                            $(tritem).find('td').each(function(tdindex,tditem) {
                                if (tdindex==4) {
                                    data[trindex] = tditem.innerHTML;
                                }
                            });
                        }else{
                            data[trindex] = 0;
                        }
                    });
                    for(var i=0;i<data.length;i++){
                        totalprice += parseFloat(data[i]);
                    }
                    $("#J_Total").html(totalprice);
                }
            }
        })
    })

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