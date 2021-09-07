//            console.log(">>>>>>>>>>script");
//필드
            var canvas, context;
            //캔버스 객체
            canvas = document.getElementById("myCanvas");
            context = canvas.getContext("2d");
            
            //캔버스 글씨
            context.font = "10pt BM YEONSUNG OTF";   
            
            //캔버스 그림
            var img = new Image();
            img.src = "/img/_contract05.jpg";

            //캔버스 드래그
            var startX = 0, startY = 0; // 드래깅동안, 처음 마우스가 눌러진 좌표
            var drawing = false;
            
//함수    
            //캔버스 객체 생성
            function create_canvas(){
//                console.log(">>>>>>>>>>create_canvas");
                var img = new Image();
                img.src = "/img/_contract05.jpg";
                let text = document.getElementById("draw_text").value;
                let text2 = document.getElementById("draw_text2").value;
                let text3 = document.getElementById("draw_text3").value;
                let text4 = document.getElementById("draw_text4").value;      

                img.onload = function () {
//                    console.log(">>>>>>>>>>>>>>>img.onload");
                    context.drawImage(img, 0, 0);
                    context.fillText(text, 167, 210);
                    context.fillText(text2, 153, 225);
                    context.fillText(text3, 153, 240);
                    context.fillText(text4, 153, 260);
//                    console.log("<<<<<<<<<<<<<<<img.onload");
                }
//                console.log("<<<<<<<<<<create_canvas");                
                
            }
            
            //드래그
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
//이벤트 리스너
            document.getElementById("draw_text").addEventListener("keyup", create_canvas(canvas,img));
            
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
//            console.log("<<<<<<<<<<script");

            document.getElementById("draw_text").addEventListener("keyup", function () {
                 create_canvas();
            });
            document.getElementById("draw_text2").addEventListener("keyup", function () {
                 create_canvas();
            });
            document.getElementById("draw_text3").addEventListener("keyup", function () {
                 create_canvas();
            });
            document.getElementById("draw_text4").addEventListener("keyup", function () {
                 create_canvas();
            });
            document.getElementById("draw_text").dispatchEvent(new Event("keyup"));

            window.onload = function () {
//                console.log(">>>>>>>>>>window.onload");
//                console.log("<<<<<<<<<window.onload");
            }
//            console.log("<<<<<<<<<<script222");