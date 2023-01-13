/*
* 명    칭 : rumiPopup (한글명칭:루미팝업)
* 제 작 일 : 2019년 01월 31일
* 제 작 자 : 조정영(루미집사)
* 이 메 일 : cjy7627@naver.com
* 홈페이지 : https://www.suu.kr
* 라이센스 : FREE
* 자유롭게 수정 및 배포 가능합니다.
**/
var rumiPopup = (function(){
    var arr = {
        width : 800,
        height : 600,
        fadeIn : true,
        fadeinTime : 500,
        url : "#",
        title : "rumiPopup",
        buttonView : true,
        reloadBtn : true,
        button : function() {},
        open : function() {},
        close : function() {}
    }

    var el = {};
    var currentScroll=0;
    var top_height = '';
    var _this = this;

    this.init = function() {

        // 레이어팝업창으로 사용할 요소 생성. (레이어 팝업후 부모페이지 클릭 방지하기 위해 div#rumipopup_sub를 화면크기로 생성한다.)
        var divTag = "<div id='rumipopup_sub'>"
                        + "<div id='rumipopup'>"
                            + "<div id='rumiHead'>"
                                + "<div class='rumiTitle'></div>"
                                + "<span class='rumiClose' onclick='rumiPopup.close();'><span class='material-symbols-outlined'>close</span></span>"
                            + "</div>"
                            + "<iframe name='rumiIframe' id='rumiIframe' class='rumiIframe' src='' width='100%'></iframe>"
                            + "<div class='rumiButton'></div>"
                            + "<span class='rumiReload'><button type='button' class='rumi_btn' onclick='rumiPopup.iframeReload();'><i class='fa fa-refresh' aria-hidden='true'></i> 새로고침</button></span>" // 새로고침 버튼
                        + "</div>"
                    + "</div>";

        $("body").append(divTag);

        // 셀렉터 - 플러그인에서 사용될 전역변수 (고정값.)
        el.Pop_sub = $("#rumipopup_sub");
        el.Popup   = $("#rumipopup");
        el.Title   = $("#rumipopup > #rumiHead > .rumiTitle");
        el.Iframe  = $("#rumiIframe");
        el.iframe  = $(".rumiIframe");
        el.Button  = $("div.rumiButton");
        el.noFrame = $("#rumipopup .noIframe");
        el.FName   = "rumiIframe";
    }

    var popup = function(option) {

        if(option && typeof option == "object") {
            arr = $.extend(arr, option);
        };

        _this.init();

        if(arr.width <= 100) {
            var W = arr.width+"%";
            var margin_left = (parseInt(arr.width/2)*-1)+"%";
        }
        else {
            var W = arr.width+"px";
            var margin_left = (parseInt(arr.width/2)*-1)+"px";
        }

        if(arr.height <= 100) {
            var H = arr.height+"%";
            var window_H = parseInt(window.innerHeight);
            var margin_top = (parseInt((window_H * (arr.height/100))/2) * -1);
        }
        else {
            var H = arr.height+"px";
            var margin_top = (parseInt(arr.height/2)*-1)+"px";
        }

        if(g5_is_mobile) {
            margin_left = "0px";
            margin_top = "0px";
            el.Popup.css({"left":"0px", "top":"0px"});
            H = window.innerHeight+"px";
        }

        // RJE - 팝업가로사이즈 수정
        // el.Popup.css({ "width" : W, "height" : H, "margin-left" : margin_left, "margin-top" : margin_top });

        // 외부문서를 불러올경우 항상 Iframe 방식을 사용.
        if(arr.iframe==true || arr.url) {
            el.Iframe.attr("src",arr.url);
        }
        else {
            el.Iframe.hide();
            el.noIframe.show();
        }
        el.Title.html(""+arr.title); //상단 타이틀

        el.Button.empty(); // 버튼 초기화
        //el.Pop_sub.show(); // 팝업이후 부모페이지 클릭 방지 레이어.
        popup_kind(arr.fadeIn); // 팝업 모션(fadeIn 또는 즉시.)

        if(arr.print == true) {
            print();
        }

        if(arr.button && arr.buttonView == true) {
            buttons(arr.button);
        }

        if(arr.open) {
            arr.open();
        }

        if(arr.reloadBtn == false) {
            document.querySelector('.rumiReload').style.display = 'none';
        }
        else {
            document.querySelector('.rumiReload').style.display = 'block';
        }

        if(arr.buttonView == false) {
            document.querySelector('.rumiButton').style.display = 'none';
            document.querySelector('.rumiIframe').style.padding = '0px 0px 60px 20px';
        }
        else {
            document.querySelector('.rumiButton').style.display = 'block';
        }

        if(g5_is_mobile) {
            document.querySelector('.rumiIframe').style.padding = '0px 5px 90px 10px';
        }
    }

    var popup_kind = function(v) {

        top_height = $(document).scrollTop();
        $('html').css({'height' : '100%', 'left' : '0px', 'top' : - top_height+"px"});
        $('html').addClass("rumi_html_fixed"); //스크롤 락

        if(v == true) {
            setTimeout(function(){
                el.Popup.fadeIn(arr.fadeinTime);
            },100);
        }
        else {
            setTimeout(function(){
                el.Popup.show();
            },100);
        };
    };

    var close = function(a,b) {

        arr.close(); // 팝업창 닫기전에 사용자 함수 실행

        $('html').css({'height' : '', 'left' : '', 'top' : ''});
        $('html').removeClass("rumi_html_fixed"); //스크롤 락 해제
        $(window).scrollTop(top_height);

        try{
            el.Pop_sub.remove();
        } catch(e) {
            alert("Error!!")
        }
    }

    var iframeReload = function() {
        document.getElementById(el.FName).contentDocument.location.reload(true);
    }

    var print = function(e) {}

    // 레이어 팝업 하단에 사용자 버튼 생성.
    var buttons = function(btn) {
        $.each(btn, function(index, item){
            el.Button.append("<button type='button' class='rumi_btn'>"+index+"</button>");
            $(".rumiButton button:contains('"+index+"')").click(item);
        });
    }

    return {
        popup : popup,
        close : close,
        iframeReload : iframeReload,
        start : init
    }

}());
