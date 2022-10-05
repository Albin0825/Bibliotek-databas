<?php
    require "db.php";

    if (!empty($_POST["search"])){
        $search = $_POST["search"];
        $sql = "SELECT * FROM media WHERE media.title LIKE '%$search%'";
    }else{
        $sql = "SELECT * FROM media";
    }
    $filter = [];

    if(!empty($_POST["Book"])){
        array_push($filter,"Book");    
    }
    if(!empty($_POST["Audio Book"])){
        array_push($filter,"Audio Book");
    }
    if(!empty($_POST["Refrense Book"])){
        array_push($filter,"Refrense Book");
    }
    if(!empty($_POST["Movie"])){
        array_push($filter,"Movie");
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
        <form id="searchf" method="POST" style="display:flex">
            <input type="text" name="search" autofocus/>
            <p> | Book</p>
            <input type="checkbox" name="Book" checked/>
            <p> | Audio Book</p>
            <input type="checkbox" name="Audio Book" checked/>
            <p> | Refrense Book</p>
            <input type="checkbox" name="Refrense Book" checked/>
            <p> | Moive</p>
            <input type="checkbox" name="Movie" checked/>
            <input type="submit" value="Search"/>
        </form>
        <?php

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                for($i = count($filter)-1;$i>0;--$i){
                    if ($filter[$i] == $row["type"]){
                        if($row["type"] == "Book" || $row["type"] == "Refrense Book"){
                            echo $row["title"] . " | " . $row["type"]. " | " . $row["ageRestriction"]. " | ".$row["length"] ." Pages<br>";
                        } else{
                            echo $row["title"] . " | " . $row["type"]. " | " . $row["ageRestriction"]. " | ".$row["length"] ." Minutes<br>";
                        }
                    }
                }
            }
        }
        ?>
    </div>
</body>
</html>