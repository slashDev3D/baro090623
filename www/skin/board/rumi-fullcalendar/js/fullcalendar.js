document.addEventListener("DOMContentLoaded", function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left : "title",
            center : "prev today next",
            right : fc_display_types
        },
        //height: '100%',
        expandRows: true,
        stickyHeaderDates:false,
        initialDate: new Date(g5_time_ymd),
        initialView: defaultview,
        locale: fc_lang,
        dayMaxEvents: false, // allow "more" link when too many events ( 일일별 스케쥴이 많을 경우 '더보기(+)'로 표시하기 )
        navLinks: true, // can click day/week names to navigate views
        editable: true, // Drag & Drop
        droppable: true,
        weekNumbers: weekNumbers, // 주차표시
        timeZone: 'KST',
        selectable: true,
        eventOverlap: true, // 스케쥴 겹침 허용 (동일날짜 동일시간으로 일정을 중복으로 등록)
        eventSources : [{
            events : function(info, successCallback, failureCallback) {
                $.ajax({
                    url : board_skin_url+"/get-events.php?bo_table="+g5_bo_table+"&sca="+sca,
                    type : "POST",
                    dataType : "json",
                    data : {
                        bo_table : g5_bo_table,
                        sca : $("#sca").val(),
                        start : info.startStr,
                        end : info.endStr,
                        stx : $("#stx").val(),
                        timeZone : 'local'
                    },
                    success : function(data) {
                        if(!bbs_write_url) {
                            $(".rumi-write").remove();
                        }
                        else {
                            $(".rumi-write").prop("title", "일정등록");
                        }
                        successCallback(data);
                    }
                });
            }
        }],
        select: function(info) {
            var d = timeConvet(info);
            if(info.allDay == true && d.start == d.end) {
                return false;
            }
            boardwrite("write", '', d.start, d.end);
        },
        eventClassNames: function(arg) {
            /** 이벤트 로드시 호출 */
            //console.log(arg.);
        },
        columnHeaderText: function(date) {
            console.log(date);
        },
        eventDrop: function(info) { // 달력화면에서 스케쥴 막대전체를 이동시
           
            if(!g5_is_admin && (info.event._def.extendedProps.wr_id != info.event._def.extendedProps.member_id) || !info.event._def.extendedProps.member_id) {
                alert("권한이 없습니다.");
                info.revert();
                return false;
            };

            if(get_ymd(info.event.start) < g5_time_ymd) {
                alert("오늘 날짜 이전으로 일정을 변경할 수 없습니다.");
                info.revert();
                return false;
            }

            var start = info.event.startStr;
            var end = info.event.endStr;
            var wr_id = info.event.id;
            dragEditDateChange(start, end, wr_id);
        },
        eventResize : function(info) { // 달력화면에서 스케쥴  막대의 사이즈를 변경시 (날자구간을 변경) - 종료 이벤트

            // 자신의 일정인지 체크 (관리자 제외)
            if(!g5_is_admin && (info.event._def.extendedProps.wr_id != info.event._def.extendedProps.member_id) ||  !info.event._def.extendedProps.member_id) {
                alert("권한이 없습니다.");
                info.revert();
                return false;
            };

            // 변경전 시작날짜
            var oldStart = new Date(info.oldEvent.start);
            oldStart = oldStart.setMinutes(oldStart.getMinutes() - 540); // 시작날짜는 9시간 빼기
            oldStart = get_ymd(oldStart);

            // 변경전 종료날짜
            var oldEnd = new Date(info.oldEvent.end);
            oldEnd = oldEnd.setMinutes(oldEnd.getMinutes() - 541); // 종료날짜는 9시간 1분 빼기
            oldEnd = get_ymd(oldEnd);

            // 변경후 시작날짜
            var newStart = new Date(info.event.start);
            newStart = newStart.setMinutes(newStart.getMinutes() - 540);
            newStart = get_ymd(newStart);

            // 변경후 종료날짜
            var newEnd = new Date(info.event.end);
            newEnd = newEnd.setMinutes(newEnd.getMinutes() - 541);
            newEnd = get_ymd(newEnd);

            /**
             * 시작날짜를 변경시 : 시작날짜가 오늘 이전이라면 변경 불가
             * - 변경전 종료날짜와 변경후 종료날짜가 같아야 함
             * - 변경전 시작날짜와 변경후 시작날짜가 달라야 함
             **/
            if(oldEnd == newEnd && oldStart != newStart) {

                //변경전 종료날짜가 현재날짜와 같거나 크고, 변경후 시작날짜가 오늘보다 작으면 .
                if(oldStart >= g5_time_ymd && newStart < g5_time_ymd) {
                    alert("[1] 오늘 날짜 이전으로 일정을 변경할 수 없습니다.");
                    info.revert();
                    return false;
                }

                // 변경전 시작날짜가 오늘 이전이라면.
                console.log(info.oldEvent.start);
                console.log(oldStart);
                if(oldStart < g5_time_ymd) {
                    alert("[2] 오늘 날짜 이전의 자료는 변경할 수 없습니다.");
                    info.revert();
                    return false;
                }

            }

            /**
             * 종료날짜 변경 : 종료날짜가 오늘 이전이라면 변경 불가
             * - 변경전 시작날짜와 변경후 시작날짜가 같아야 함.
             * - 변경전 종료날짜와 변경후 종료날짜가 달라야 함.
             */
            if(oldStart == newStart && oldEnd != newEnd) {

                //변경전 종료날짜가 현재날짜와 같거나 크고, 변경후 종료날짜가 오늘보다 작으면 .
                if(oldEnd >= g5_time_ymd && newEnd < g5_time_ymd) {
                    alert("[3] 오늘 날짜 이전으로 일정을 변경할 수 없습니다.");
                    info.revert();
                    return false;
                }

                // 변경전 종료날짜가 오늘 이전자료라면.
                if(oldEnd < g5_time_ymd) {
                    alert("[4] 오늘 날짜 이전의 자료는 변경할 수 없습니다.");
                    info.revert();
                    return false;
                }

            }

            var start = info.event.startStr;
            var end = info.event.endStr;
            var wr_id = info.event.id;
            //console.log(start+' / '+end+' / '+wr_id);
            dragEditDateChange(start, end, wr_id);
        },
        eventClick: function(info) {

            if (info.event.url.indexOf(document.location.hostname) === -1) {
                boardwrite("view", info.event.id, '');
                info.jsEvent.preventDefault(); // don't let the browser navigate
            }
        },
        datesRender: function(info) {
            console.log(info);
            // addSelectedClass: '오늘' 날짜가 없는 달에는 1일이 선택되어 있는 것처럼 배경색 바꾸기.
            //addSelectedClass(info.view.currentStart).then(function (seletedEl) {
            // 배경색 바꾼 후 다른 작업 ...
            //});
        },
        loading: function(bool) {
            $("#loading").toggle(bool);
        }
    });

    calendar.render();

    /* 팝업창 닫을때 실행될 함수 - 일정데이터 불러오기 */
    calendarRefresh = function() {
        calendar.refetchEvents();
    }

    // 관리자버튼 생성
    var btns = "";
    if (g5_is_admin) {
        btns += '<button type="button" class="fc-button fc-button-primary" id="btn-settings"><i class="fa fa-gear" aria-hidden="true"></i></button>';
        btns += '<button type="button" class="fc-button fc-button-primary" id="btn-adminset">A</button>';
    }

    // 글쓰기 버튼
    if(bbs_write_url) {
        btns += '<button type="button" class="fc-button fc-button-primary" id="btn-write"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
    }
    $("#calendar .fc-button-group").append(btns);


    /** 카테고리 */
    if(is_category) {
        var cate ="<li class='category fc-button-primary' data-id=''>전체</li>";
        for(i = 0; i < category.length; i++) {
            cate += "<li class='category fc-button-primary' data-id='"+category[i]+"'>"+category[i]+"</li>";
        }
        $("#bo_cate_ul").append(cate);

        // 카테고리 클릭
        $(".category").click(function() {
            var val = $(this).attr("data-id");
            $("#sca").val(val);
            $(".category").removeClass("category-active");
            $(this).addClass("category-active");
            calendarRefresh();
        });

    }


    // 우측 상단 글쓰기 버튼
    $("#bo_list").on('click', '#btn-write', function() {
        boardwrite("write", '', '', '');
    });

    // 관리자 설정
    $("#bo_list").on('click', '#btn-adminset', function() {
        location.href = bbs_admin_url;
    });

    // 일별 글쓰기 바로가기
    $("#bo_list").on('click', '.rumi-write', function(e) {
        var dt = JSON.parse($(this).attr("data-navlink"));
        boardwrite("write", '', dt.date, dt.date);
    });

    // 스케쥴러 기본 설정
    $("#bo_list").on('click', '#btn-settings', function() {
        fullcalendarSetup();
    });



});