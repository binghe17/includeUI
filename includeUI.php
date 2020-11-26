<?php 
header('Content-Type: application/javascript; charset=UTF-8');
date_default_timezone_set('Asia/Seoul');
$dirPath = dirname($_SERVER['REQUEST_URI']) .'/';
// var_dump( $dirPath);

//-------------절차1: 임의의 사아트에서 확장기능이 필요한 위치에 아래 코드를 삽입한다.(스크랩트는 완전경로를 사용)

//or 방식1
// <div id="includeUIBox"></div><script src="includeUI.php"></script>

//or 방식2
// <script src="includeUI.php"></script>


//-------------절차2: 확장기능의 소스를 수정한다. (한번의 삽입으로 삽입위치의 코드 수정없이 서버에서 확장기능에 대해 통일 관리할수 있다.)
//수정
$echoHTML = <<<HTML
    <div style="border:1px solid #333;">
        <div id="demo1">테스트 위젯</div>
        <span>{$dirPath}</span>
        <style>
            #demo1 {background:#ccc;}
        </style>
        <script>
            $('#demo1').parent().append('111111')
            // loadJs('https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js', function(){ 
            //     // $.cookie('popupAD_M', '1', { expires: 1, path: '/' }); 
            //     console.log($.cookie()); 
            // });
        </script>
    </div>
HTML;

//-------------(여러개 일때 ID이름 includeUIBox을 다른것을 수정한다.)

echo <<<JS
    function includeUIFun(domId, type='html'){ if($(domId).length > 0) $(domId)[type](`{$echoHTML}`); } //주의: 현재행의 주석은 꼭 /**/로 사용해야 합니다.(echoHTML은 여러행일수 있음)
    if(typeof includeUIFun == 'function'){
        let runFun = function(){//-----------------수정부분(시작)
            includeUIFun('#includeUIBox');
            // includeUIFun('body','append');
        }//----------------------------------------끝
        if(typeof jQuery == 'undefined'){
            if(typeof loadJs == 'undefined') function loadJs(url, callback){ let s = window.document.createElement("script"); s.src = url; window.document.head.appendChild(s); s.onload =function(){ if(typeof callback === 'function') callback(url); } }
            loadJs('https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js', runFun);
            // let s = window.document.createElement("script"); s.src = 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js'; window.document.head.appendChild(s); s.onload = runFun;
        } else runFun();
    }
JS;

