<SCRIPT LANGUAGE="JavaScript">
        function clear() 
        { 
                parent.document.form.text.value = '';
        } 
</SCRIPT>
 
<?php
        echo "<p class='shout_text'>Сообщений нет!</p>";
        echo "<script>clear();</script>"; //здесь ошибка отсутствует
?>
