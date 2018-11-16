<SCRIPT LANGUAGE="JavaScript">
        function clear() 
        { 
                return = 'привет';
        } 
</SCRIPT>
 
<?php
        echo "<p class='shout_text'>Сообщений нет!</p>";
        echo "<script>clear();</script>"; //здесь ошибка отсутствует
?>
