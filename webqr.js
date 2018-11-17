
var gCtx = null;
var gCanvas = null;
var imageData = null;
var c=0;
var stype=0;
var gUM=false;
var webkit=false;
var moz=false;
var v=null;




function handleFiles(f)
{
	var o=[];
	for(var i =0;i<f.length;i++)
	{
		var reader = new FileReader();
		reader.onload = (function(theFile) {
			return function(e) {
				gCtx.clearRect(0, 0, gCanvas.width, gCanvas.height);
				qrcode.decode(e.target.result);
			};
		})(f[i]);
		reader.readAsDataURL(f[i]);
	}
}
function initCanvas(ww,hh)
{
    gCanvas = document.getElementById("qr-canvas");
    var w = ww;
    var h = hh;
    gCanvas.style.width = w + "px";
    gCanvas.style.height = h + "px";
    gCanvas.width = w;
    gCanvas.height = h;
    gCtx = gCanvas.getContext("2d");
    gCtx.clearRect(0, 0, w, h);
    imageData = gCtx.getImageData( 0,0,320,240);
}

function read(a)
{
	if(a=='error decoding QR Code'){
		var error = 'Ошибка считывания, попробуйте еще раз';
		document.getElementById("result").innerHTML=error;
	}else{
		var options = "reply_markup": {
            "inline_keyboard": [[
                {
                    "text": "A",
                    "callback_data": "A1"            
                }, 
                {
                    "text": "B",
                    "callback_data": "C1"            
                }]
            ]
        };
		var currentLocation = window.location.search;
		var but = currentLocation.split('?')[1];
		var html=a;
		const Http = new XMLHttpRequest();
		const url='https://api.telegram.org/bot738988528:AAH9NXpv9RdgUiUKLE5hYB8nheHSLWW4aOI/sendMessage?chat_id='
		+but+'&text='+a+'&reply_markup='+options;
		Http.open("GET", url);
		Http.send();
		Http.onreadystatechange=(e)=>{
			console.log(Http.responseText)
		}
		var ok = 'QR код отсканирован. Нажмите "Готово" что бы продолжить';
		document.getElementById("result").innerHTML=ok;
	}	
}	

function load()
{
	if( window.File && window.FileReader)
	{
		initCanvas(800,600);
		qrcode.callback = read;
		document.getElementById("mainbody").style.display="inline";
	}
}
