<?php
    require "db.php";

    $sql = "SELECT * FROM media";

    $result = $conn->query($sql);

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>