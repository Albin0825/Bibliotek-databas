<?php
require_once('../db.php');
require_once('../php/getMedia.php');
require_once('../php/getGenres.php');
require_once('../php/getAuthors.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

    <!-- Navigering -->
    <div style="margin-top:14px; margin-bottom:14px; margin-left:4%;">
        <a href = "overview.php"><button>Overview</button></a>
        <a href = "users.php"><button>Users</button></a>
    </div>

    <!-- Mediatabell -->
    <table id="media-table">

    <?php
    // Table header
    echo "<tr>
    <th>ID</th><th>Title</th><th>Type</th><th>Author</th>
    <th>Genre</th><th>Age</th><th>Length</th>
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

        echo "<td style='border:none;'><div>";
        echo "<a href='edit-media.php?id=" . $media->ID . "'><button>Edit</button></a>";
        echo "<a href='../php/deleteMedia.php?id=" . $media->ID ."'><button>Remove</button></a>";
        echo "</div></td></tr>";
    }

    ?>
    </table> 

    <a href = "new-media.php">
        <button style="margin-top:14px; margin-left:4%;">New</button>
    </a>
</body>
</html>