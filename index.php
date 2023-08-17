<?php   
    include "db.php";
    $arr = [];
    if(isset($_GET['search'])) {
        $sql = "SELECT * FROM docs WHERE name LIKE '%".$_GET['search']."%'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($arr, "<li>".$row['name']."</li>");
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
    <h1>DOCS ПРОЕКТ!</h1>
    <p>Для загрузки новых документов перейдите по ссылке: <a href="upload.php">Загрузить файл.</a></p>
    <hr>
    <form action="<?php $_SERVER['PHP_SELF']?>" method="get" enctype="multipart/form-data">
        <label for="search">Поиск:</label>
        <input type="text" name="search">
        <input type="submit" value="Искать">
    </form>
    <ul>
        <?php
            echo implode(" ", $arr);
        ?>
    </ul>
</body>
</html>