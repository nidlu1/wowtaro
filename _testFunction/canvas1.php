<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        #my_canvas {
            border: 1px solid grey;
        }
    </style>
</head>
<body>
<canvas id="my_canvas" width="1200" height="1000"></canvas><br>
<input id="draw_text" value="111111">
<script>

    document.getElementById("draw_text").addEventListener("keyup", function() {
        var canvas = document.getElementById("my_canvas");
        var context = canvas.getContext("2d");

        context.clearRect(0, 0, canvas.width, canvas.height);

        let text = document.getElementById("draw_text").value;

        context.font = "10pt BM YEONSUNG OTF";
        context.fillText(text, 1000, 20);
    });

    document.getElementById("draw_text").dispatchEvent(new Event("keyup"));
</script>
</body>
</html>