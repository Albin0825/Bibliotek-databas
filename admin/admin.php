<?php
require_once('../php/getOverview.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminsida</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navigering -->
    <div>
        <a href = "admin-media.php"><button>Media</button></a>
        <a href = "admin-users.php"><button>Användare</button></a>
    </div>

    <!-- Adminöversikt -->
    <?php
    echo "<p>Totala mediaobjekt: " . $stats['mediaCount'] . "<br>";
    echo "Antal utlånade: " . $stats['borrowCount'] . "</p>";

    echo "<p>Antal böcker: " . $stats['bookCount'] . "<br>";
    echo "Antal filmer: " . $stats['movieCount'] . "<br>";
    echo "Antal ljudböcker: " . $stats['audioCount'] . "<br>";
    echo "Antal referensböcker: " . $stats['refCount'] . "</p>";

    echo "<p>Biblioteket har " . $stats['userCount'] . " medlemmar";
    ?>
</body>
</html>