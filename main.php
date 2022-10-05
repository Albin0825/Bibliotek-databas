<?php
    require "db.php";

    if (!empty($_POST["search"])){
        $search = $_POST["search"];
        $sql = "SELECT * FROM media WHERE media.title LIKE '%$search%'";
    }else{
        $sql = "SELECT * FROM media";
    }

    

    $result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <div>
        <form method="POST">
            <input type="text" name="search"/><input type="submit" value="Search"/>
        </form>
        <?php

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row["type"] == "Book" || $row["type"] == "Refrense Book"){
                    echo $row["title"] . " | " . $row["type"]. " | " . $row["ageRestriction"]. " | ".$row["length"] ." Pages<br>";
                } else{
                    echo $row["title"] . " | " . $row["type"]. " | " . $row["ageRestriction"]. " | ".$row["length"] ." Minutes<br>";
                }
                
            }
        }
        ?>
    </div>
</body>
</html>