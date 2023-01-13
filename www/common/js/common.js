$(document).ready(function() {

    $(".hd_mo_menu").click(function () {
        if($("#headerContainer").hasClass("open")){
            $("#headerContainer, #GnbContainer").removeClass("open");
            //$.unlockBody();
        }else{
            $("#headerContainer, #GnbContainer").addClass("open");
            //$.lockBody();
        }
    });


    $(".hd_menu li").on("mouseenter", function() {
        if(!$("#headerContainer").hasClass("open")){
            $("#headerContainer, #GnbContainer").addClass("open");
            //$.unlockBody();
        }
    });
    $("#GnbContainer").on("mouseleave", function() {
        if($("#headerContainer").hasClass("open")){
            $("#headerContainer, #GnbContainer").removeClass("open");
        }
    });

    // prevent body scroll
    var $docEl = $('html, body'),
    $scrollTop;


    $.lockBody = function() {
        if(window.pageYOffset) {
            $scrollTop = window.pageYOffset;
        }
        $docEl.css({
            height: "100%",
            overflow: "hidden"
        });
    }
    
    $.unlockBody = function() {
        $docEl.css({
            height: "",
            overflow: ""
        });

        window.scrollTo(0, $scrollTop);
        window.setTimeout(function () {
            $scrollTop = null;
        }, 0);
    }




    //

    $(window).resize(function(){
        var width = parseInt($(this).width()); //parseint는 정수로 하기 위함
        if(width <= 768){
            $('#sub_menu .sub_menu_con').css({'display':'none'});
        }else{
            $('#sub_menu .sub_menu_con').css({'display':'flex'});
            $('#sub_menu .sub_menu_tit').removeClass('m_on');
        }
    }).resize();

    $('#sub_menu .sub_menu_tit').click(function(){
        if($(this).hasClass('m_on')){
            $(this).removeClass('m_on');
            $(this).siblings("ul.sub_menu_con").slideUp();
        } else {
            $(this).addClass('m_on');
            $(this).siblings("ul.sub_menu_con").slideDown();
        }
    });


    

});

function popClose (classN) {
    $("."+classN).hide();
}
