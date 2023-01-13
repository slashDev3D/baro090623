<?php 
include_once('_common.php');
include_once('_head.php');
?>


<Style>

    
    #sub_container {padding-top:0;} 

    #sub_container.business6 .subPg_box {width:90%; max-width:1280px; margin-left:auto; margin-right:auto; position:relative;}
    #sub_container.business6 .subPg_box.w100 {width:100%; max-width:100%;}

    body:not(.ChangeWhite) #sub_nav span.dep1:before,
    body:not(.ChangeWhite) #sub_nav span.dep2:before {background:rgba(139, 139, 139, 0.5);}

    body:not(.ChangeWhite) #sub_menu .sub_menu_con {color:#8b8b8b;}
    body:not(.ChangeWhite) #sub_menu li:before {background-color:rgba(139, 139, 139, 0.5);}
    body:not(.ChangeWhite) #sub_menu li a.on {color:#FFF;}

    body:not(.ChangeWhite) #sub_menu .sub_menu_tit {color:#FFF; border:1px solid #8b8b8b;}

    body:not(.ChangeWhite) #sub_menu .sub_menu_tit.m_on::before,
    body:not(.ChangeWhite) #sub_menu .sub_menu_tit.m_on::after{ background:#8b8b8b; }
    
    @media all and (max-width:768px) {
        #sub_menu .sub_menu_con {background:#222;}
        #sub_menu .sub_menu_con li {border-color:#8b8b8b;}
    }

    body:not(.ChangeWhite) .subPg_tit span {color:#8b8b8b;}
    body:not(.ChangeWhite) .subPg_tit span::before {background:#FFF;}
    body:not(.ChangeWhite) .subPg_tit span::after {background:#8b8b8b;}
    
    body:not(.ChangeWhite) .tbl_st_01:before,
    body:not(.ChangeWhite) .tbl_st_01:after {background:#222;}
    body.ChangeWhite .tbl_st_01:before,
    body.ChangeWhite .tbl_st_01:after {background:#fff;}

    body:not(.ChangeWhite) .tbl_st_01 thead {background:transparent; border-top:2px solid #FFF;font-weight:bold;}
    body:not(.ChangeWhite) .tbl_st_01 tbody th,
    body:not(.ChangeWhite) .tbl_st_01 tbody td {border-color:#8b8b8b; }

    #sub_container.business6 .tbl_st_01 tbody th,
    #sub_container.business6 .tbl_st_01 tbody td {font-weight:600;}
</style>


<div id="smooth-wrapper">
    <div id="smooth-content">

        <div class="subPg_box subPg_box-1">
            <div class="subPg_tit"><span>KoEF</span></div>
            <div class="subPg_con ">
                <div class="busi6_video_box">
                    <video class="busi6_video" poster src="https://player.vimeo.com/progressive_redirect/playback/708906851/rendition/720p/file.mp4?loc=external&signature=7ec7b9ebc742a51c5582e90bf178af25146692412d818ca98d1ea8bd10ea10be" autoplay muted playsinline loop></video>
                </div>

                <div class="busi6_koef_cont">
                    <div class="sub">한국청년기업가정신재단은</div>
                    <div class="tit">
                        <div class="t1"><b>도전</b>과 <b>열정</b>의 <b>청년정신</b>이 통하는 <b>사회실현과</b> <br/><b>기업문화 조성</b>을 위해 앞장서겠습니다.</div>
                    </div>
                    <div class="con">창의 인재발굴과 도전적 성취의 <br class="mo">새로운 지평을 열어드립니다.</div>

                    <ul class="lan">
                        <li>
                            <div class="in">
                                <div class="i">
                                    <p class="lan1">起</p>
                                    <p class="lan2">일으킬 <b>기</b></p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="in">
                                <div class="i">
                                    <p class="lan1">業</p>
                                    <p class="lan2">업 <b>업</b></p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="subPg_box subPg_box-2">
            <div class="subPg_tit"><span>Value</span></div>
            <div class="subPg_con ">

                <div class="busi6_value_cont">
                    <ul class="titBox">
                        <li>
                            <div class="tit">Entrepreneur</div>
                            <div class="sub">새로운 기업을 일으키는 사람</div>
                            <div class="con">세상에 존재하지 않았던 새로운 가치를 창조하는 일</div>
                        </li>

                        <li>
                            <div class="tit">Entrepreneurship</div>
                            <div class="sub">기업가정신</div>
                            <div class="con">도전과 열정, 창의와 혁신으로 無에서 有를 만들어 가는 일</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="subPg_box w100 subPg_box-3">
            <div class="inner busi6_com_tit">
                <p class="s">Contributing institution</p>
                <p class="t">출연기관</p>
            </div>
            <div class="busi6_com_con">

                <div class="swiper busi6_swiper_wrapper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci01.png" class="balck" /><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci01b.png" class="white" /></div>
                        <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci02.png" class="balck" /><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci02b.png" class="white" /></div>
                        <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci03.png" class="balck" /><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci03b.png" class="white" /></div>
                        <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci04.png" class="balck" /><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci04b.png" class="white" /></div>
                        <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci05.png" class="balck" /><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci05b.png" class="white" /></div>
                        <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci06.png" class="balck" /><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci06b.png" class="white" /></div>
                        <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci07.png" class="balck" /><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci07b.png" class="white" /></div>
                        <div class="swiper-slide"><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci08.png" class="balck" /><img src="<?php echo G5_URL?>/common/images/sub/busi6_ci08b.png" class="white" /></div>
                    </div>
                </div>

            </div>
        </div>

        <style>
            .busi6_swiper_wrapper .balck {opacity:0.4;}
            .busi6_swiper_wrapper .white {display:none;}
            body.ChangeWhite .busi6_swiper_wrapper .balck {display:none;}
            body.ChangeWhite .busi6_swiper_wrapper .white {display:inline;}
        </style>


        <div id="subPg_ScrollEvent">
            <div class="subPg_box subPg_box-4" id="subPg_box4">
                <div class="subPg_tit"><span>이사회</span></div>
                <div class="subPg_con ">
                    <ul class="li_dot">
                        <li><b>설립근거 : </b>민법 제 32조 비영리법인 (재단법인)</li>
                        <li><b>설립목적 : </b>청년층의 <span>도전정신, 창의력, 혁신역량 등의 함양을 돕고</span> 나아가 우리나라 기업가정신의 확산을 주도하는 <span>플랫폼 역할</span>을 수행</li>
                        <li><b>임원현황 : </b>총 15명(이사장 1명, 이사 13명, 감사 1명)</li>
                    </ul>

                    <div class="tbl_w100 mt30 mb30">
                        <table class="tbl_st_01">
                            <colgroup>
                                <col width="20%">
                                <col width="12%">
                                <col width="">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>직위</th>
                                    <th>이름</th>
                                    <th>소속</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>이사장</th>
                                    <td>남민우</td>
                                    <td>㈜다산네트웍스 대표이사</td>
                                </tr>

                                <tr>
                                    <th>비상임감사</th>
                                    <td>강문현</td>
                                    <td>前 딜로이트안진회계법인 부대표</td>
                                </tr>

                                <tr>
                                    <th rowspan="3">비상임이사 (당연직)</th>
                                    <td>노용석</td>
                                    <td>중소벤처기업부 창업진흥정책관</td>
                                </tr>
                                <tr>
                                    <td>지성배</td>
                                    <td>(사)한국벤처캐피탈협회 회장</td>
                                </tr>
                                <tr>
                                    <td>강삼권</td>
                                    <td>(사)벤처기업협회 회장</td>
                                </tr>

                                <tr>
                                    <th rowspan="9">비상임이사 (선임직)</th>
                                    <td>황철주</td>
                                    <td>주성엔지니어링(주) 대표이사</td>
                                </tr>
                                <tr>
                                    <td>고영하</td>
                                    <td>(사)한국엔젤투자협회 회장</td>
                                </tr>
                                <tr>
                                    <td>조현정</td>
                                    <td>㈜비트컴퓨터 대표이사</td>
                                </tr>
                                <tr>
                                    <td>이은정</td>
                                    <td>한국맥널티㈜ 대표이사</td>
                                </tr>
                                <tr>
                                    <td>장흥순</td>
                                    <td>블루카이트주식회사 대표이사</td>
                                </tr>
                                <tr>
                                    <td>은경아</td>
                                    <td>㈜세라트 대표이사</td>
                                </tr>
                                <tr>
                                    <td>정준</td>
                                    <td>㈜쏠리드 대표이사</td>
                                </tr>
                                <tr>
                                    <td>김미균</td>
                                    <td>㈜시지온 대표이사</td>
                                </tr>
                                <tr>
                                    <td>박수홍</td>
                                    <td>㈜베이글랩스 대표이사</td>
                                </tr>

                                <tr>
                                    <th>상임이사</th>
                                    <td>김영수</td>
                                    <td>(재)한국청년기업가정신재단 사무총장</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <ul class="li_dot left">
                        <li><b>재단주소 : </b>(06595) 서울 서초구 서초대로45길 16, 202호 (서초동, 브이알빌딩)</li>
                    </ul>
                </div>
                
            </div>



            <div class="subPg_box subPg_box-5" id="subPg_box5">
                <div class="subPg_tit "><span>주요기능</span></div>
                <ul class="subPg_con line pt40 busi6_func_list">
                    <li>
                        <p>🗒</p>
                        <p>기업가정신 활성화를 위한 사업의 기획, 개발 및 운영</p>
                    </li>
                    <li>
                        <p>🧩</p>
                        <p>기업가정신에 대한 연구지원, 실태조사 및 통계 구축·운영</p>
                    </li>
                    <li>
                        <p>💁‍♂️</p>
                        <p>청년 및 예비창업자 등을 대상으로 하는 기업가정신 교육과정과 교재의 개발·보급, 교육사업의 관리·운영 지원</p>
                    </li>
                    <li>
                        <p>🥁</p>
                        <p>기업가정신 모범사례의 발굴·전파 등 기업가정신을 확산하기 위한 분위기 조성</p>
                    </li>
                    <li>
                        <p>🧗‍♀️</p>
                        <p>기업가정신 저해요인의 발굴·해소 및 원활한 재도전 여건 확충</p>
                    </li>
                    <li>
                        <p>🏃‍♂️</p>
                        <p>기업가정신분야의 국내외 교류 및 체험</p>
                    </li>
                    <li>
                        <p>👨‍🏫</p>
                        <p>기업가정신 생태계 조성을 위한 멘토링, 컨설팅</p>
                    </li>
                </ul>
                
            </div>

    </div>

    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/ScrollToPlugin.min.js"></script>
<script>

gsap.registerPlugin(ScrollTrigger);

$(window).resize(function () {
    gsap.to('body', {duration:0.1, backgroundColor: '#222' });
    //var changeColor = gsap.to('body', {duration:0.1, backgroundColor: '#fff' });
    //var changeColor = gsap.to('body', {duration:0.1, backgroundColor: '#fff' });
    
    gsap.set('body', {toggleClass : {className:'black'}})

    ScrollTrigger.create({
        trigger: '#subPg_ScrollEvent',
        pin: false,
        start: () => "top bottom",
        end: () => "top bottom",
        //animation: changeColor,
        scrub: true,
        markers: false,
        //toggleClass : {className : 'transferHd', targets:'body'},
        onEnter: function(self) {
            $("#headerContainer").removeClass("transferHd");
            $("body").addClass("ChangeWhite");
        },
        onLeaveBack: function(self) {
            $("#headerContainer").addClass("transferHd");
            $("body").removeClass("ChangeWhite");
            
        }
    });
}).resize();

// var imgSize = $(".dddd img").size();
// var imgWidth;
// $(".dddd img").load(function () {
//     imgWidth = $(".dddd img:first-child").width();
//     var t = TweenMax.fromTo(".dddd img", 30, {x:`100vw`}, {x:`-${imgSize * (imgWidth + 120)}px`, ease:Linear.easeNone }).repeat(-1);
// });

</script>

<script>
    var CollegeSwiper = new Swiper(".busi6_swiper_wrapper", {
        spaceBetween: 10,
        centeredSlide : true,
        slidesPerView: 1,
        loop : true,
        speed:2000,
        breakpoints: {
            420: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 20,
            },
        },
        autoplay: {
            delay: 1,
            disableOnInteraction: false,
        },
    });

    $(document).ready(function () {
        $("#sub_title").append("<div class='in'></div>");

        setTimeout(() => {
            $("#sub_title").addClass("on");
        }, 100);
    });
</script>


<?php include_once('_tail.php'); ?>