<!doctype html>
<html lang="en"><head>
    <title>How to decode QR code | PHPGang.com</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <style type="text/css">
    
      img {border-width: 0}
      * {font-family:'Lucida Grande', sans-serif;}
    </style>
  </head>
  <body  >
  
    
    <div>

       
  <p>
               <style type="text/css">
body{
    width:100%;
    text-align:center;
}
#qrfile{
    width:320px;
    height:240px;
}
#v{
    width:320px;
    height:240px;
}
#qr-canvas{
    display:none;
}
#iembedflash{
    margin:0;
    padding:0;
}
#mp1{
    text-align:center;
    font-size:25px;
}
#mp2{
    text-align:center;
    font-size:25px;
    color:red;
}
.selector{
    border: solid;
    border-width: 3px 3px 1px 3px;
    margin:0;
    padding:0;
    cursor:pointer;
    margin-bottom:-5px;
}
#outdiv
{
    width:320px;
    height:240px;
    border: solid;
    border-width: 1px 1px 1px 1px;
}
#result{
    border: solid;
    border-width: 1px 1px 1px 1px;
    padding: 0px;
    width: 100%;
}

#imghelp{
    position:relative;
    left:0px;
    top:-160px;
    z-index:100;
    font:18px arial,sans-serif;
    background:#f0f0f0;
    margin-left:35px;
    margin-right:35px;
    padding-top:10px;
    padding-bottom:10px;
    border-radius:20px;
}
p.helptext{
    margin-top:54px;
    font:18px arial,sans-serif;
}
p.helptext2{
    margin-top:100px;
    font:18px arial,sans-serif;
}
ul{
    margin-bottom:0;
    margin-right:40px;
}
li{
    display:inline;
    padding-right: 0.5em;
    padding-left: 0.5em;
    font-weight: bold;
    border-right: 1px solid #333333;
}
li a{
    text-decoration: none;
    color: black;
}

#footer a{
    color: black;
}
.tsel{
    padding:0;
}

</style>
	  <script type="text/javascript" src="llqrcode.js"></script>

<script type="text/javascript" src="webqr.js"></script>
<script type="text/javascript" src="jquery-1.8.0.min.js"></script>
<script>
$(document).ready(function() {
load();
setimg();            
});
</script>
<div id="main">
<!-- 	<div id="qrfile">
		<canvas id="out-canvas" width="320" height="240">
		</canvas>
    <div id="imghelp">
	Select a file
	<input type="file" onchange="handleFiles(this.files)"/>
	</div>
</div> -->
<div id="mainbody">


<div id="outdiv">
	<div id="qrfile"><canvas id="out-canvas" width="320" height="240"></canvas>
    <div id="imghelp">
	Select a file
	<input type="file" onchange="handleFiles(this.files)"/>
	</div>
</div>
</div>
<div id="result"></div>
</div></div>           <canvas id="qr-canvas" width="800" height="600"></canvas>        </p>            




  </body>
</html>
