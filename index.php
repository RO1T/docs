<?php   
    include "db.php";
    $arr = [];
    if(isset($_GET['search'])) 
    {
        $sql = "SELECT * FROM docs WHERE name LIKE '%".$_GET['search']."%'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) 
        {
            while($row = mysqli_fetch_assoc($result)) 
            {
                array_push($arr, $row);
            }
        }
        mysqli_close($conn);
    }

    if (isset($_GET['id'])) 
    {
        $id = $_GET['id'];
        $sql = "SELECT * FROM docs WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        $file = mysqli_fetch_assoc($result);
        $filepath = "docs/".$file['name'];

        if(file_exists($filepath)) 
        {
            header("Content-type: application/octet-stream");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=".basename($filepath));
            header("Expires: 0");
            header("Cache-Control: must-revalidate");
            header("Pragma: public");
            header("Content-Length: ".filesize($filepath));
            readfile($filepath); 
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
        <?php foreach($arr as $value) : ?>
        
        <li>
            <a href="index.php?id=<?php echo $value['id']?>"><?php echo $value['name'] ?></a>
        </li>

        <?php endforeach ; ?>
    </ul>
</body>
</html>