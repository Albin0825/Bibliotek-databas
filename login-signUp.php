<?php
    session_start();
    require "db.php";

    if (isset($_POST['login'])) {
        if(!empty($_POST)){
            $name = $_POST["name"];
            $password = $_POST["password"];

            $sql = "SELECT id, name, password FROM user WHERE BINARY name='$name' and BINARY password='$password'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $_SESSION["uID"] = $row["id"];
                    if($row["id"] == 0) {
                        ?>
                    <script>
                        location.replace("admin/overview.php")
                    </script>
                <?php
                        
                    }
                    else {
                        echo "ID: " . $row["id"] . " | Name: " . $row["name"]. " | Password:" . $row["password"]. "<br>"; // normal user
                        ?>
                        <script>
                            location.replace("main.php")
                        </script>
                    <?php
                    }
                }
            }
            else {
                ?>
                    <script>
                        location.replace("./")
                    </script>
                <?php
            }
        }
    }

    if (isset($_POST['sign-up'])) {
        $list = [];
        if(!empty($_POST)){
            $name = $_POST["name"];
            $password = $_POST["password"];
            $cPassword = $_POST["cPassword"];
            $dob = $_POST["dob"];
            $adress = $_POST["adress"];

            $sql = "SELECT * FROM user";
            $result = $conn->query($sql);
            
            while ($row = $result->fetch_assoc()) {
                
                array_push($list,$row);
            }
            

            foreach($list as $x) {
                if($name == $x["name"] && $password == $x["password"]) {
                    ?>
                        <script>
                            location.replace("sign-up/")
                        </script>
                    <?php
                }
                else if($list[count($list)-1] == $x ) {
                    if($password === $cPassword) {
                        $sql = "INSERT INTO user(name, password, dob, adress) VALUE('$name', '$password', '$dob', '$adress')";
                        
                        if ($conn->query($sql) === TRUE) {
                            ?>
                                <script>
                                    location.replace("./")
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
                                location.replace("sign-up/")
                            </script>
                        <?php
                    }
                }
            }
        }
    }
?>