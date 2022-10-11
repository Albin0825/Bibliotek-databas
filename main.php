<?php
    session_start();
    require "db.php";
    $uID = $_SESSION["uID"];
    $filter = [];


    /*============================================================
        Get User
    ============================================================*/
    $sql = "SELECT * FROM user";

    $resultUser = $conn->query($sql);

    $user = [];
    if ($resultUser->num_rows > 0) {
        // output data of each row
        while($row = $resultUser->fetch_assoc()) {
            array_push($user,$row);
        }
    }





    /*============================================================
        Borrow
    ============================================================*/
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
    /*============================================================
        Search
    ============================================================*/
    
    if (!empty($_POST["search"]) && empty($_POST["sorting"])){
        
        $search = $_POST["search"];
        if(is_numeric($search)){
            $sql = "SELECT * FROM media WHERE media.ISBN LIKE '$search' ORDER BY title ASC";
        }else{
            $sql = "SELECT * FROM media WHERE media.title LIKE '%$search%' ORDER BY title ASC";
        }
        
    }else if(!empty($_POST["search"]) && !empty($_POST["sorting"])){
        $search = $_POST["search"];
        
        if($_POST["sorting"] === "A-Ö"){
            $sql = "SELECT * FROM media WHERE media.title LIKE '%$search%' ORDER BY title ASC";
        }
        if($_POST["sorting"] === "Ö-A"){
            $sql = "SELECT * FROM media WHERE media.title LIKE '%$search%' ORDER BY title DESC";
        }
        if($_POST["sorting"] === "Längd>"){
            $sql = "SELECT * FROM media WHERE media.title LIKE '%$search%' ORDER BY `media`.`length` ASC";
        }
        if($_POST["sorting"] === "Längd<"){
            $sql = "SELECT * FROM media WHERE media.title LIKE '%$search%' ORDER BY `media`.`length` DESC";
        }
    }else if(!empty($_POST["sorting"])){
        if($_POST["sorting"] === "A-Ö"){
            $sql = "SELECT * FROM media ORDER BY title ASC";
        }
        if($_POST["sorting"] === "Ö-A"){
            $sql = "SELECT * FROM media ORDER BY title DESC";
        }
        if($_POST["sorting"] === "Längd>"){
            $sql = "SELECT * FROM media ORDER BY `media`.`length` ASC";
        }
        if($_POST["sorting"] === "Längd<"){
            $sql = "SELECT * FROM media ORDER BY `media`.`length` DESC";
        }
    } else{
        $sql = "SELECT * FROM media ORDER BY `media`.`title` ASC";
    }
    $result = $conn->query($sql);



    /*============================================================
        Return
    -============================================================*/
    if (!empty($_POST["return"])){
        $return = $_POST["return"];
        $sql = "DELETE FROM borrow WHERE borrow.mID = ".$return;
        $retrunRet = $conn->query($sql);
        array_push($filter,"Book");
        array_push($filter,"Audio Book");
        array_push($filter,"Refrense Book");
        array_push($filter,"Movie");
    }



    /*============================================================
        Reserved
    ============================================================
    if (!empty($_POST['reserve'])){
        $reserve = $_POST['reserve'];
        $sql = "INSERT INTO queue (uID, mID, qDate) VALUE ($uID,$reserve,'$date')";
        $reserveRes = $conn->query($sql); 
        array_push($filter,"Book");
        array_push($filter,"Audio Book");
        array_push($filter,"Refrense Book");
        array_push($filter,"Movie");
    }



    ============================================================
        unReserve
    ============================================================
    if (!empty($_POST["unReserve"])){
        $unReserve = $_POST["unReserve"];
        $sql = "DELETE FROM queue WHERE queue.mID = ".$unReserve;
        $retrunRet = $conn->query($sql);
        array_push($filter,"Book");
        array_push($filter,"Audio Book");
        array_push($filter,"Refrense Book");
        array_push($filter,"Movie");
    }
*/


    /*============================================================
        Filter
    ============================================================*/
    $sql = "SELECT * FROM genre";

    $resultGenre = $conn->query($sql);

    $genre = [];
    if ($resultGenre->num_rows > 0) {
        // output data of each row
        while($row = $resultGenre->fetch_assoc()) {
            array_push($genre,$row);
        }
    }

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



    /*============================================================
        Reserve
    ============================================================
    $sql = "SELECT * FROM queue";

    $resultqueue = $conn->query($sql);

    $queue = [];
    if ($resultqueue->num_rows > 0) {
        // output data of each row
        while($row = $resultqueue->fetch_assoc()) {
            array_push($queue,$row);
        }
    }
    */
    
    
    /*============================================================
        What is Borrowed
    ============================================================*/
    /*
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
    */
    $sql = "SELECT * FROM borrow";

    $resultborrow = $conn->query($sql);

    $borrowed = [];
    if ($resultborrow->num_rows > 0) {
        // output data of each row
        while($row = $resultborrow->fetch_assoc()) {
            array_push($borrowed,$row);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Document</title>
</head>
<body>
    <div>
            <div id="userThings">
                <?php echo "<div id='user'>".$user[$uID]['name']."</div>"; ?>
                <a id="logout" href="./"><img src="assets/img/logout.svg" alt="bog"></a>
            </div>
            <form id="search" method="POST">
                <div class="search">
                    
                    <input type="text" name="search" placeholder="Search">
                    <input type="submit" value="🔍"></input>
                    
                </div>
                <div class="filter">
                    <div class="img"><!-- sövde logo --></div>
                    <select name="genre" id="cars">
                        <option value="none">Genre</option>
                        <?php 
                        foreach($genre as $g){
                            echo "<option value=".$g["name"].">$g[name]</option>";
                        }
                        ?>
                    </select>
                    <select name="sorting" id="cars">
                        <option value="A-Ö">A - Ö</option>
                        <option value="Ö-A">Ö - A</option>
                        <option value="Längd>">Längd ></option>
                        <option value="Längd<">Längd <</option>
                    </select>
                    
                    <div>
                        Book
                        <input type="checkbox" name="Book" checked></input>
                        Audio Book
                        <input type="checkbox" name="AudioBook" checked></input>
                        Refrense Book
                        <input type="checkbox" name="RefrenseBook" checked></input>
                        Moive
                        <input type="checkbox" name="Movie" checked></input>
                    </div>
                    <input type="submit" value="Search"></input>
                </div>
            </form>
            
        
    </div>
    <div class="con">
    <?php
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $mID = $row['ID'];
                if(!empty($filter)){
                    foreach($filter as $type){
                        if ($type == $row["type"]){
                            if($row["type"] == "Book" || $row["type"] == "Refrense Book"){
                                echo "
                                    <form method='POST'>
                                        <img src='./assets/img/".$row['type'].".svg' alt=''>
                                        <div class='text'>" . $row["title"] . "<br> 
                                            <div class='text age-length'>" .
                                                $row["ageRestriction"] . "+
                                                <span class='length'>" . $row["length"] . "PP</span>
                                            </div>
                                            <div class='text condition-isbn'>
                                                <span class='acssent'>➤</span> ISBN: " . $row["ISBN"] . "
                                                <br>
                                                <span class='acssent'>➤</span> Condition: " . $row["quality"]+1 . "/10
                                            </div>
                                        </div>";
                            } else{
                                echo "
                                    <form method='POST'>
                                        <img src='./assets/img/".$row['type'].".svg' alt=''>
                                        <div class='text'>" . $row["title"] . "<br> 
                                            <div class='text age-length'>" .
                                                $row["ageRestriction"] . "+
                                                <span class='length'>" . $row["length"] . "Min</span>
                                            </div>
                                            <div class='text condition-isbn'>
                                                <span class='acssent'>➤</span> ISBN: " . $row["ISBN"] . "
                                                <br>
                                                <span class='acssent'>➤</span> Condition: " . $row["quality"]+1 . "/10
                                            </div>
                                        </div>";
                            }
                        }
                    }
                } else{
                        if($row["type"] == "Book" || $row["type"] == "Refrense Book"){
                            echo "
                                <form method='POST'>
                                    <img src='./assets/img/".$row['type'].".svg' alt=''>
                                    <div class='text'>" . $row["title"] . "<br> 
                                        <div class='text age-length'>" .
                                            $row["ageRestriction"] . "+
                                            <span class='length'>" . $row["length"] . "PP</span>
                                        </div>
                                        <div class='text condition-isbn'>
                                            ISBN: " . $row["ISBN"] . "
                                            <br>
                                            Condition: " . $row["quality"]+1 . "/10
                                        </div>
                                    </div>";
                        } else{
                            echo "
                                <form method='POST'>
                                    <img src='./assets/img/".$row['type'].".svg' alt=''>
                                    <div class='text'>" . $row["title"] . "<br> 
                                        <div class='text age-length'>" .
                                            $row["ageRestriction"] . "+
                                            <span class='length'>" . $row["length"] . "Min</span>
                                        </div>
                                        <div class='text condition-isbn'>
                                            ISBN: " . $row["ISBN"] . "
                                            <br>
                                            Condition: " . $row["quality"]+1 . "/10
                                        </div>
                                    </div>";
                        }
                    }
                    $temp = 0;
                    foreach($filter as $type){
                        if ($type == $row["type"]){
                            foreach($borrowed as $b){
                                if($b['mID'] == $row["ID"] && $b['uID'] == $uID){
                                    echo"<input type='hidden' name='return' value='$mID'/> <input type='submit' value='Return'/></form>";
                                    $temp = 1;
                                } else if ($b['mID'] == $row["ID"]){ 
                                    echo"<input id='borrowed' type='submit' value='Borrowed'/></form>";
                                    $temp = 1;
                                }
                            }
                            if($temp == 0 && $type != "Refrense Book"){
                                echo"<input type='hidden' name='media' value='$mID'/> <input type='submit' value='Borrow'/></form>";
                            } else if($temp == 0){
                                echo"</form>";
                            }
                        }
                    }
                }
            }
        ?>
    </div>
</body>
</html>