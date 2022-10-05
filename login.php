<?php

    require "db.php";

    if(!empty($_POST)){
        $name = $_POST["name"];
        $password = $_POST["password"];

        $sql = "SELECT id, name, password FROM user WHERE name='$name' and password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"] . " | Name: " . $row["name"]. " | Password:" . $row["password"]. "<br>";
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