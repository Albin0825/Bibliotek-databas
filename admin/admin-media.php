<?php
require_once('../db.php');
require_once('../php/getMedia.php');
require_once('../php/getGenres.php');
require_once('../php/getAuthors.php');

// Get data from the media-creator table
$sql = "SELECT * FROM mediacreator";

$mAuthor = [];
foreach ($conn->query($sql) as $row) {
    array_push($mAuthor,$row);
}

// Get data from the media-genre table
$sql = "SELECT * FROM mediagenre";

$mGenre = [];
foreach ($conn->query($sql) as $row) {
    array_push($mGenre,$row);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navigering -->
    <div>
        <a href = "admin.php"><button>Start</button></a>
        <a href = "admin-users.php"><button>Användare</button></a>
    </div>

    <!-- Mediatabell -->
    <table>

    </table>    
    <a href = "admin-new-media.php"><button>Skapa ny</button></a>
</body>
</html>