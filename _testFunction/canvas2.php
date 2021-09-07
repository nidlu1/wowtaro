<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>테스트</title>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    </head>
    <body>
        <h1>마우스 드래깅으로 캔버스에 그림 그리기 및 input 첨부하기</h1>
        <canvas id="myCanvas" style="background-color:aliceblue" width="1200" height="1000"></canvas>
        <hr>
        <input id="draw_text" value="111111">
        <button>첨부하기</button>
        <form enctype="multipart/form-data" method="post">
            <input type="file" id="file" accept="image/jpeg, txt">
        </form>
        <script>
            console.log(">>>>>>>>>>script");
            var canvas, context;
            window.onload = function () {
                console.log(">>>>>>>>>>window.onload");

                canvas = document.getElementById("myCanvas");
                context = canvas.getContext("2d");

                context.lineWidth = 2; // 선 굵기를 2로 설정
                context.strokeStyle = "black";

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

                var img = new Image();
                img.src = "/img/_contract.png";
                img.onload = function () {
                    console.log(">>>>>>>>>>>>>>>img.onload");
                    context.drawImage(img, 0, 0);
                    console.log("<<<<<<<<<<<<<<<img.onload");
                }
                console.log("<<<<<<<<<window.onload");
            }
            var startX = 0, startY = 0; // 드래깅동안, 처음 마우스가 눌러진 좌표
            var drawing = false;
            function draw(curX, curY) {
                // console.log(">>>>>>>>>>draw");
                context.beginPath();
                context.moveTo(startX, startY);
                context.lineTo(curX, curY);
                context.stroke();
                // console.log("<<<<<<<<<<draw");
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
        </script>
    </body>
</html>