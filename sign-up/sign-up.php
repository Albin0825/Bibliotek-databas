<?php

    require "../db.php";

    if(!empty($_POST)){
        $name = $_POST["name"];
        $password = $_POST["password"];
        $cPassword = $_POST["cPassword"];
        $dob = $_POST["dob"];
        $adress = $_POST["adress"];

        if($password === $cPassword) {
            $sql = "INSERT INTO user(name, password, dob, adress) VALUE('$name', '$password', '$dob', '$adress')";
            
            if ($conn->query($sql) === TRUE) {
                ?>
                    <script>
                        location.replace("../index.html")
                    </script>
                <?php
            }
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        else {
            ?>
                <script>
                    location.replace("index.html")
                </script>
            <?php
        }
    }
?>