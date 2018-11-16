<SCRIPT LANGUAGE="JavaScript">
        function clear() 
        { 
                return 'привет';
        } 
        var m=5;
</SCRIPT>
 
<?php
        echo "<p class='shout_text'>Сообщений нет!</p>";
        echo "<script>m;</script>"; //здесь ошибка отсутствует
?>
