<?php
$QRCodeReader = new Libern\QRCodeReader\QRCodeReader();
$qrcode_text = $QRCodeReader->decode("https://cdn1.savepice.ru/uploads/2018/11/16/9646b9cea324190bc95963c7ec81acdd-full.jpg");
echo $qrcode_text;
?>
