<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>테스트</title>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    </head>
    <body>
        <h1>마우스 드래깅으로 캔버스에 그림 그리기 및 input 첨부하기</h1>
        <input id="draw_text" value="920622-1xxxxxx">
        <input id="draw_text2" value="110-334-718891">
        <input id="draw_text3" value="강서구방화동로 12길 25">
        <input id="draw_text4" value="한승">
        <hr>
        <canvas id="myCanvas" style="background-color:aliceblue" width="600" height="800"></canvas>
        <button>첨부하기</button>
<!--        <form enctype="multipart/form-data" method="post">
            <input type="file" id="file" accept="image/jpeg, txt">
        </form>-->
        <script>
            console.log(">>>>>>>>>>script");
            var canvas, context;

            document.getElementById("draw_text").addEventListener("keyup", function () {
                console.log(">>>>>>>>>>draw_text");
                canvas = document.getElementById("myCanvas");
                context = canvas.getContext("2d");

                var img = new Image();
                img.width = 500;
                img.height = 500;
                img.src = "/img/_contract05.jpg";

                img.onload = function () {
                    console.log(">>>>>>>>>>>>>>>img.onload1");
                    context.drawImage(img, 0, 0);
                    context.fillText(text, 167, 210);
                    context.fillText(text2, 153, 225);
                    context.fillText(text3, 153, 240);
                    context.fillText(text4, 153, 260);
                    console.log("<<<<<<<<<<<<<<<img.onload1");
                }
                
                context.clearRect(0, 0, canvas.width, canvas.height);
                context.font = "10pt BM YEONSUNG OTF";
                let text = document.getElementById("draw_text").value;
                let text2 = document.getElementById("draw_text2").value;
                let text3 = document.getElementById("draw_text3").value;
                let text4 = document.getElementById("draw_text4").value;
                
                console.log("<<<<<<<<<<draw_text");
            });

            document.getElementById("draw_text").dispatchEvent(new Event("keyup"));

            window.onload = function () {
                console.log(">>>>>>>>>>window.onload");

                canvas = document.getElementById("myCanvas");
                context = canvas.getContext("2d");

                context.lineWidth = 2; // 선 굵기를 2로 설정
                context.strokeStyle = "black";

                var img = new Image();
//                img.src = "/img/_contract.png";
                img.onload = function () {
                    console.log(">>>>>>>>>>>>>>>img.onload2");
//                    context.drawImage(img, 0, 0);
                    console.log("<<<<<<<<<<<<<<<img.onload2");
                }

                // 마우스 리스너 등록. e는 MouseEvent 객체
                canvas.addEventListener("mousemove", function (e) {
                    move(e)
                }, false);
                canvas.addEventListener("mousedown", function (e) {
                    down(e)
                }, false);
                canvas.addEventListener("mouseup", function (e) {
                    up(e)
                }, false);
                canvas.addEventListener("mouseout", function (e) {
                    out(e)
                }, false);

                console.log("<<<<<<<<<window.onload");
            }
            var startX = 0, startY = 0; // 드래깅동안, 처음 마우스가 눌러진 좌표
            var drawing = false;
            function draw(curX, curY) {
//                 console.log(">>>>>>>>>>draw");
                context.beginPath();
                context.moveTo(startX, startY);
                context.lineTo(curX, curY);
                context.stroke();
//                 console.log(curX+"."+curY);
//                 console.log("<<<<<<<<<<draw");
            }
            function down(e) {
                // console.log(">>>>>>>>>>down");
                startX = e.offsetX;
                startY = e.offsetY;
                drawing = true;
                // console.log("<<<<<<<<<<down");
            }
            function up(e) {
                // console.log(">>>>>>>>>>up");
                drawing = false;
                // console.log("<<<<<<<<<<up");
            }
            function move(e) {
                // console.log(">>>>>>>>>>move");
                if (!drawing) {
                    // console.log(">>>>>>>>>>move.if");
                    // console.log("<<<<<<<<<<move.if");
                    return; // 마우스가 눌러지지 않았으면 리턴
                }
                var curX = e.offsetX, curY = e.offsetY;
                draw(curX, curY);
                startX = curX;
                startY = curY;
                // console.log("<<<<<<<<<<move");
            }
            function out(e) {
                // console.log(">>>>>>>>>>out");
                drawing = false;
                // console.log("<<<<<<<<<<out");
            }
            console.log("<<<<<<<<<<script");
        </script>
    </body>
</html>