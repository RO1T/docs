<?php
try 
{
    $conn = mysqli_connect("localhost","root","","docsdb");
}
catch (mysqli_sql_exception) 
{
    echo "Не получилось подключится к базе данных <br>";
}
?>