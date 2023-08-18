<?php

include "db.php";

$message = "";

if (isset($_POST["submit"])) 
{
    $extenstion = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    if (!empty($_POST["newName"]))
    {
        $_FILES["file"]["name"] = $_POST["newName"] . "." . $extenstion;
    }
    $filename = $_FILES["file"]["name"];

    $destination = "docs/" . $filename;

    $file = $_FILES["file"]["tmp_name"];

    if(move_uploaded_file($file, $destination))
    {
        $sql = "INSERT INTO docs (name) 
        VALUES ('$filename')";

        try 
        {
            mysqli_query($conn, $sql);
            $message = "Файл загружен!";
        }
        catch (mysqli_sql_exception) 
        {
            $message = "Что-то пошло не так..";
        }
    }
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Загрузчик документов!</h1>
    <a href="index.php">Вернуться.</a>
    <hr>
    <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <input type="file" name="file"><br>
        <label for="newName">Опционально:</label><br>
        <input type="text" name="newName" placeholder="Имя документа"><br>
        <input type="submit" name="submit" value="Закачать">
    </form>
    <?php echo $message; ?>
</body>
</html>