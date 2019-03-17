$(document).ready(function() {
    // 行业指数
    var li = $("#industry-div").find("li").length;
    var liW = $("#industry-div").find("li").outerWidth(true);
    $("#industry-div").css("width", li * liW);
    var t = setInterval("industryAnimate()", 2000);

    $("#industry-div li").hover(function () {
        t = clearInterval(t)
    }, function () {
        t = setInterval("industryAnimate()", 2000);
    })
})

function industryAnimate() {
    $("#industry-div").animate({
        left: "-110px"
    }, 500, function () {
        $("#industry-div").css({left: "0px"}).find("li:first").appendTo("#industry-div");
    })
}
