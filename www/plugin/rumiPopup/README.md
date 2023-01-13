# rumiPopup
- Modal Window Plugin
- jQuery Dialog를 보고 따라 만든 플러그인입니다.
- 팝업이 되면 배경은 클릭을 할 수 없으며, 스크롤도 잠김니다.
- 팝업이 해제되면 배경 클릭과 스크롤도 정상적으로 작동됩니다.
- 초보가 만든 것이기 때문에 감안하고 사용하세요.


### DEMO
[http://www.suu.kr/DEMO/rumipopup/rumiPopup.php](http://www.suu.kr/DEMO/rumipopup/rumiPopup.php)


### 아래와 같이 작성합니다.

```html
<script src="http://.../jquery.rumiPopup.js"></script>
<link rel="stylesheet" href="http://.../rumiPopup.css">
```


### GUNUBOARD 5.3 ~ 5.4 에서 사용시

- `/plugin/rumipopup/`폴더에 파일을 복사합니다.
- 적용하고자 하는 파일에 아래 코드를 삽입합니다.

```php
add_stylesheet('<link rel="stylesheet" href="'.G5_PLUGIN_URL.'/rumipopup/rumiPopup.css?ver='.G5_CSS_VER.'">', 0);
add_javascript('<script src="'.G5_PLUGIN_URL.'/rumipopup/jquery.rumiPopup.js?ver='.G5_CSS_VER.'"></script>', 0);
```


### 기본코드
```javascript
rumiPopup.popup({
    width : 800, // 팝업창 가로크기
    height : 600, // 팝업창 세로크기
    fadeIn : true, // 팝업시 fadeIn 
    fadeinTime : 500, // fadein 지연시간
    url : g5_url+"/DEMO/rumipopup/popup_01.php", // 불러올 문서 URL
    title : "기본팝업창", // 팝업창 제목
    buttonView : true, // 하단 사용자 버튼 (true - 표시, false - 숨김)
    reloadBtn : true, // 새로 고침 버튼 (true - 표시, false - 숨김)
    button : { /* 사용자 버튼 추가 */
        "전송" : function(){
            $("#rumiIframe").contents().find("#btn_submit").trigger("click");
        },
        "닫기" : function(){
            rumiPopup.close(); // 팝업창 닫기
        },
    },
    open : function(){
        /* 팝업창이 열리면서 실행됩니다. */
        $("div.rumiButton button:contains('닫기')").css({"background":"#555"});
        $("div.rumiButton button:contains('삭제')").css({"background":"#555"}).hide();
    },
    close : function() {
        /* 팝업창이 닫힐때 실행됩니다. */
    }
});
```


### 옵션

| 옵션 | 초기값 | 설명 |
|:---:|:---:|:---|
| width |	800	| 100까지는 "%", 101부터는 "px"입니다.|
| height |	600	| 100까지는 "%", 101부터는 "px"입니다.|
| fadeIn |	true	| 팝업창이 열릴때 FADE 효과를 적용합니다. ( "true" or "false" )|
| fadeTime |	500	| FADE 효과의 지속 시간입니다. (1000 = 1초)|
| url |	#	| 팝업창에서 보여줄 페이지의 URL 입니다.|
| title |	rumiPopup	| 팝업창의 제목이며, 좌측 상단에 표시됩니다.|
| buttonView |	true	| 사용자 버튼을 숨기거나 보여줍니다. ( "true" or "false" )|
| reloadBtn |	true	| 새로고침 버튼을 숨기거나 보여줍니다. ( "true" or "false" )|
| button |	| function() {}	사용자 정의 버튼|
| open |	| function() {}	팝업창이 열릴때 실행되는 함수|
| close |	| function() {}	팝업창이 닫히면서 실행되는 함수|
