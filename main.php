<?php
    session_start();
    require "db.php";
    $uID = $_SESSION["uID"];
    $filter = [];
/*-----------------------------------------------------------
            Borrow
-----------------------------------------------------------*/
    $date = date('y-m-d');
    if (!empty($_POST['media'])){
        $media = $_POST['media'];
        $sql = "INSERT INTO borrow (mID, uID, bDate, rDate) VALUE ($media, $uID, '20$date', '2022-12-04')";
        $conn->query($sql);
        array_push($filter,"Book");
        array_push($filter,"Audio Book");
        array_push($filter,"Refrense Book");
        array_push($filter,"Movie");
    }
/*-----------------------------------------------------------
            Search
-----------------------------------------------------------*/

    if (!empty($_POST["search"])){
        $search = $_POST["search"];
        if(is_numeric($search)){
            $sql = "SELECT * FROM media WHERE media.ISBN LIKE '$search'";
        }else{
            $sql = "SELECT * FROM media WHERE media.title LIKE '%$search%'";
        }
        
    }else{
        $sql = "SELECT * FROM media";
    }
    $result = $conn->query($sql);
/*-----------------------------------------------------------
            Return
-----------------------------------------------------------*/
    if (!empty($_POST["return"])){
        $return = $_POST["return"];
        $sql = "DELETE FROM borrow WHERE borrow.mID = ".$return;
        $retrunRet = $conn->query($sql);
        array_push($filter,"Book");
        array_push($filter,"Audio Book");
        array_push($filter,"Refrense Book");
        array_push($filter,"Movie");
    }
/*-----------------------------------------------------------
            Reserved
-----------------------------------------------------------*/
    if (!empty($_POST['reserve'])){
        $reserve = $_POST['reserve'];
        $sql = "INSERT INTO queue (uID, mID, qDate) VALUE ($uID,$reserve,'$date')";
        $reserveRes = $conn->query($sql); 
        array_push($filter,"Book");
        array_push($filter,"Audio Book");
        array_push($filter,"Refrense Book");
        array_push($filter,"Movie");
    }

/*-----------------------------------------------------------
            unReserve
-----------------------------------------------------------*/
    if (!empty($_POST["unReserve"])){
        $unReserve = $_POST["unReserve"];
        $sql = "DELETE FROM queue WHERE queue.mID = ".$unReserve;
        $retrunRet = $conn->query($sql);
        array_push($filter,"Book");
        array_push($filter,"Audio Book");
        array_push($filter,"Refrense Book");
        array_push($filter,"Movie");
    }


/*-----------------------------------------------------------
            Filter
-----------------------------------------------------------*/
    
    if($_POST == NULL){
        array_push($filter,"Book");
        array_push($filter,"Audio Book");
        array_push($filter,"Refrense Book");
        array_push($filter,"Movie");
    }
    if(!empty($_POST["Book"])){
        array_push($filter,"Book");
    }
    if(!empty($_POST["AudioBook"])){
        array_push($filter,"Audio Book");
    }
    if(!empty($_POST["RefrenseBook"])){
        array_push($filter,"Refrense Book");
    }
    if(!empty($_POST["Movie"])){
        array_push($filter,"Movie");
    }

/*-----------------------------------------------------------
            Reserve
-----------------------------------------------------------*/
$sql = "SELECT * FROM queue";

$resultqueue = $conn->query($sql);

$queue = [];
if ($resultqueue->num_rows > 0) {
    // output data of each row
    while($row = $resultqueue->fetch_assoc()) {
        array_push($queue,$row);
    }
}


/*-----------------------------------------------------------
            What is Borrowed
-----------------------------------------------------------*/
    $sql = "SELECT * FROM borrow";

    $resultborrow = $conn->query($sql);

    $borrowed = [];
    if ($resultborrow->num_rows > 0) {
        // output data of each row
        while($row = $resultborrow->fetch_assoc()) {
            $temp = 0;
            if(!empty($queue)){
                foreach($queue as $q){
                    if($q["uID"] == $row["uID"]){
                        $temp = 1;
                    }
                }
                if($temp == 1){
                    array_push($borrowed,$row);
                    $temp = 0;
                }
            }else{
                if($row["uID"] != $uID){
                    array_push($borrowed,$row);
                }
                
            }
        }
    }

    $resultborrow = $conn->query($sql);

    $borroweded = [];
    if ($resultborrow->num_rows > 0) {
        // output data of each row
        while($row = $resultborrow->fetch_assoc()) {
            foreach($borrowed as $b){
                if($b != $row){
                    array_push($borroweded,$row);
                }
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
    <div>
        <form id="searchf" method="POST" style="display:flex">
            <input type="text" name="search" autofocus/>
            <p> | Book</p>
            <input type="checkbox" name="Book" checked></input>
            <p> | Audio Book</p>
            <input type="checkbox" name="AudioBook" checked></input>
            <p> | Refrense Book</p>
            <input type="checkbox" name="RefrenseBook" checked></input>
            <p> | Moive</p>
            <input type="checkbox" name="Movie" checked></input>
            <input type="submit" value="Search"></input>
        </form>
        <?php

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $mID = $row['ID'];
                if(!empty($filter)){
                    foreach($filter as $type){
                        if ($type == $row["type"]){
                            if($row["type"] == "Book" || $row["type"] == "Refrense Book"){
                                echo "<form method='POST'>".$row["title"] . " | " . $row["type"]. " | " . $row["ageRestriction"]. "+ | ".$row["length"]." Pages ";
                            } else{
                                echo "<form method='POST'>".$row["title"] . " | " . $row["type"]. " | " . $row["ageRestriction"]. "+ | ".$row["length"] ." Minutes ";
                            }
                        }
                    }
                } else{
                        if($row["type"] == "Book" || $row["type"] == "Refrense Book"){
                            echo "<form method='POST'>".$row["title"] . " | " . $row["type"]. " | " . $row["ageRestriction"]. "+ | ".$row["length"] ." Pages ";
                        } else{
                            echo "<form method='POST'>".$row["title"] . " | " . $row["type"]. " | " . $row["ageRestriction"]. "+ | ".$row["length"] ." Minutes ";
                        }
                    }
                $temp = 0;
                foreach($filter as $type){
                    if ($type == $row["type"]){
                            foreach($borroweded as $b){
                                if($b['mID'] == $row["ID"] && $b['uID'] == $uID){
                                    echo"<input type='hidden' name='return' value='$mID'/> <input type='submit' value='Return'/></form> <br>";
                                    $temp = 1;
                                } else if ($b['mID'] == $row["ID"]){ 
                                    echo"<input type='hidden' name='reserve' value='$mID'/> <input type='submit' value='Reserve'/></form> <br>";
                                    $temp = 1;
                                }
                            }
                            foreach($queue as $q){
                                if($q['mID'] == $row["ID"] && $q['uID'] == $uID){
                                    echo"<input type='hidden' name='unReserve' value='$mID'/> <input type='submit' value='Stop Reserving'/></form> <br>";
                                    $temp = 1;
                                }
                            }
                            if($temp == 0){
                                echo"<input type='hidden' name='media' value='$mID'/> <input type='submit' value='Borrow'/></form> <br>";
                            }
                    }
                }
            }}
        ?>
    </div>
</body>
</html>