<?php
require_once('../db.php');
require_once('../php/getGenres.php');
require_once('../php/getAuthors.php');

// Get the ID of the media being edited. 
$mediaID = $_GET['id'];
// Return to media table if no ID is given
if(!$mediaID) {
    header("Location: media.php");
}

$sql = "SELECT * FROM media WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$mediaID);
$stmt->execute();
$media = $stmt->get_result()->fetch_assoc(); 

if(isset($_POST['m-name'])) {
    $name = $_POST['m-name'];
    $authors = $_POST['m-author'];
    $genres = $_POST['m-genre'];
    $type = $_POST['m-type'];
    $age = $_POST['m-age'];
    $length = $_POST['m-length'];
    $quality = $_POST['m-cond'];
    $price = $_POST['m-price'];
    $ISBN = $_POST['m-isbn'];

    $sql = "INSERT INTO media (title,type,ageRestriction,length,quality,price,ISBN)
        VALUES (?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiiis", $name, $type, $age, $length, $quality, $price, $ISBN);
    $stmt->execute();

    $mediaID = $stmt->insert_id;

    foreach($authors as $a) {
        $sql = "INSERT INTO mediacreator (mID, cID) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $mediaID, $a);
        $stmt->execute();
    }

    foreach($genres as $g) {
        $sql = "INSERT INTO mediagenre (gID, mID) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $g, $mediaID);
        $stmt->execute();
    }
}

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

    <!-- Navigation -->
    <div style="margin-top:14px; margin-bottom:14px; margin-left:4%;">
        <a href = "overview.php"><button>Overview</button></a>
        <a href = "media.php"><button>Media</button></a>
        <a href = "users.php"><button>Users</button></a>
    </div>

    <!-- Media Form -->
    <form method="post" id="new-media">

        <!-- Media name -->
        <label for="m-name">Name:</label>
        <input type="text" name="m-name" style="margin-top:3px;">

        <!-- Author -->
        <label for="m-author[]">Author(s):</label>
        <select name="m-author[]" multiple>
            <?php
            foreach($authorList as $author) {

                echo "<option value=". $author->ID . ">" . $author->name . "</option>";
            }
            ?>
        </select>
        <a href="new-author.php">Add New Author</a>

        <!-- Genre -->

        <label for="m-genre[]">Genre(s):</label>
        <select name="m-genre[]" multiple>
            <?php
            foreach($genreList as $genre) {
                echo "<option value=". $genre->ID . ">" . $genre->name . "</option>";
            }
            ?>
        </select>
        <a href="new-genre.php">Add New Genre</a>

        <!-- Type -->

        <label for="m-type">Type:</label>
        <select name="m-type" style="margin-top:3px;">
            <option value="Book">Book</option>
            <option value="Movie">Movie</option>
            <option value="Audio Book">Audio Book</option>
            <option value="Refrense Book">Reference Book</option>
        </select>

        <!-- Age requirement -->

        <label for="m-age">Age requirement:</label>
        <select name="m-age" style="margin-top:3px;">
            <option value=0>None</option>
            <option value=3>3</option>
            <option value=7>7</option>
            <option value=9>9</option>
            <option value=12>12</option>
            <option value=16>16</option>
            <option value=18>18+</option>
        </select>
        
        <!-- Length -->
        <label for="m-length">Length:</label>
        <input type="number" name="m-length">

        <!-- Condition -->
        <label for="m-cond">Condition:</label>
        <input type="number" name="m-cond">

        <!-- Price -->
        <label for="m-price">Price:</label>
        <input type="number" name="m-price">

        <!-- ISBN -->

        <label for="m-isbn">ISBN:</label>
        <input type="text" name="m-isbn">

        <input type="submit" value="Create">
    </form>
    
</body>
</html>