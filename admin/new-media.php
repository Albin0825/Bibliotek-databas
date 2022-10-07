<?php
require_once('../db.php');
require_once('../php/getGenres.php');
require_once('../php/getAuthors.php');

if(isset($_POST)) {
    $name = $_POST['m-name'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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

        <label for="m-name">Name:</label>
        <input type="text" name="m-name" style="margin-top:3px;">

        <label for="m-author[]">Author(s):</label>
        <select name="m-author[]" multiple>
            <?php
            foreach($authorList as $author) {
                $a = $author->name;
                echo "<option value=". str_replace(" ","_",$a) . ">" . $a . "</option>";
            }
            ?>
        </select>

        <a href="new-author.php">Add New Author</a>

        <label for="m-genre[]">Genre(s):</label>
        <select name="m-genre[]" multiple>
            <?php
            foreach($genreList as $genre) {
                $g = $genre->name;
                echo "<option value=". str_replace(" ","_",$g) . ">" . $g . "</option>";
            }
            ?>
        </select>

        <a href="new-genre.php">Add New Genre</a>

        <label for="m-type">Type:</label>
        <select name="m-type" style="margin-top:3px;">
            <option value="Book">Book</option>
            <option value="Movie">Movie</option>
            <option value="Audio Book">Audio Book</option>
            <option value="Refrense Book">Reference Book</option>
        </select>

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

        <label for="m-length">Length:</label>
        <input type="number" name="m-length">

        <label for="m-cond">Condition:</label>
        <input type="number" name="m-cond">

        <label for="m-price">Price:</label>
        <input type="number" name="m-price">

        <label for="m-isbn">ISBN:</label>
        <input type="text" name="m-isbn">

        <input type="submit" value="Create">
    </form>
    
</body>
</html>