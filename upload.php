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
        <input type="file" name="filename"><br>
        <label for="newFilename">Имя файла:</label>
        <input type="text" name="newFilename"><br>
        <input type="submit" name="submit" value="Закачать">
    </form>
</body>
</html>

<?php

include "db.php";

if (!empty($_FILES)) {
    $file = $_FILES['filename'];
    $name = $file['name'];
    $extension = explode('.', $file['name'])[1];
    if (!empty($_POST['newFilename'])){
        $name = $_POST['newFilename'].'.'.$extension;
    }
    $path = __DIR__.'/docs/'.$name;

    if (!move_uploaded_file($file['tmp_name'], $path)) {
        echo "Файл не закачен!";
    }

    $sql = "INSERT INTO docs (name, path) VALUES ('$name', '$path')";

    try{
        mysqli_query($conn, $sql);
        echo "Файл закачен!";
    }
    catch(Exception $e){
        echo $e->getMessage();
    }

    mysqli_close($conn);
}

?>