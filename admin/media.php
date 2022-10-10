<?php
require_once('../db.php');
require_once('../php/getMedia.php');
require_once('../php/getGenres.php');
require_once('../php/getAuthors.php');

function find_in_array($array, $itemID) {
    for($i = 0 ; $i < sizeof($array) ; $i++) {
        if($array[$i]->ID == $itemID) {
            return $array[$i];
        }
    }
}


$sql1 = "SELECT * FROM mediacreator";
$sql2 = "SELECT * FROM mediagenre";

// Add the authors into the 'authors' arrays of the specific media.
// There's probably a better way to do this with SQL. Too bad.
foreach ($conn->query($sql1) as $row) {
    array_push(
        find_in_array($mediaList,$row['mID'])->authors,
        find_in_array($authorList,$row['cID'])->name
    );
}



// Does the same thing for genres
foreach ($conn->query($sql2) as $row) {
    array_push(
        find_in_array($mediaList,$row['mID'])->genres,
        find_in_array($genreList,$row['gID'])->name
    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../assets/css/styleA.css">
</head>
<body>

    <!-- Navigering -->
    <div style="margin-top:14px; margin-bottom:14px; margin-left:4%;">
        <a href = "overview.php"><button>Overview</button></a>
        <a href = "users.php"><button>Users</button></a>
    </div>

    <!-- Mediatabell -->
    <table style="margin-left:4%; width:92%;">
    <?php

    // Table header
    echo "<tr>
    <th>ID</th><th>Title</th><th>Type</th><th>Author</th>
    <th>Genre</th><th>Age requirement</th><th>Length</th>
    <th>Condition</th><th>Price</th><th>ISBN</th>
    </tr>";

    // Add media to table
    foreach($mediaList as $media) {
        $genreText = "";
        $authorText = "";

        // Convert genre array to string
        foreach($media->genres as $g) {
            $genreText .= $g . ", ";
        }
        
        // Convert author array to string
        foreach($media->authors as $a) {
            $authorText .= $a . ", ";
        }

        echo "<tr>";
        echo "<td style='text-align:center;'>" . $media->ID . "</td>";
        echo "<td>" . $media->title . "</td>";
        echo "<td style='text-align:center;'>" . $media->type . "</td>";
        echo "<td>" . substr($authorText, 0, -2) . "</td>";
        echo "<td>" . substr($genreText, 0, -2) . "</td>";
        echo "<td style='text-align:center;'>" . $media->ageRestriction . "</td>";
        echo "<td style='text-align:center;'>" . $media->length;
        if($media->type == "Book") {
            echo " Pages";
        }
        echo"</td>";
        echo "<td style='text-align:center;'>" . $media->quality . "</td>";
        echo "<td style='text-align:center;'>" . $media->price . "</td>";
        echo "<td>" . $media->ISBN . "</td>";
        echo "</tr>";
    }
    ?>
    </table>    
    <a href = "new-media.php">
        <button style="margin-top:14px; margin-left:4%;">New</button>
    </a>
</body>
</html>