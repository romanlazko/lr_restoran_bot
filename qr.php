<!doctype html>
<html lang="en">
<head>
<title>How to decode QR code | PHPGang.com</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="qrcss.css" rel="stylesheet">
</head>
   <body>
        <script type="text/javascript" src="llqrcode.js"></script>
        <script type="text/javascript" src="webqr.js"></script>
        <script type="text/javascript" src="jquery-1.8.0.min.js"></script>
        <script>
            $(document).ready(function() {
                load();          
            });
        </script>
        <div id="main">
            <div id="mainbody">
                <div id="outdiv">
                    <div id="qrfile">
                        <canvas id="out-canvas" width="320" height="240"></canvas>
                        
                    </div>
                </div>
                <div id="imghelp">
                    <label for="button">Отсканировать QR код</label>

                    <input type="file" id="button" onchange="handleFiles(this.files)"/>
                </div>
                <div id="result">
                </div>
            </div>
        </div>
        <canvas id="qr-canvas" width="800" height="600"></canvas>      
    </body>
</html>
