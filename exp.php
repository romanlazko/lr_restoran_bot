<?php
function AddEntry() {
    session_start();
    require_once("dbconnect.php");
 
    echo "<BR>";
    echo "AddEntries Started";
    echo "<BR>";
    $query = "INSERT INTO CRM.Clients (Name, Phone, Email)
        VALUES ('John', '89161206482', 'john@example.com')";
    $handler = mysql_query($query) or die ( "Error : ".mysql_error() );  
    return $result;
}
AddEntry();
?>
