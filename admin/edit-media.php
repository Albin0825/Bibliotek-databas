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

require_once('../php/getMedia.php');
$media = $mediaList[0];

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

    $sql = "UPDATE media SET title = ?, type = ?, ageRestriction = ?, length= ?, quality = ?, price = ?, ISBN = ?
        WHERE ID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiiisi", $name, $type, $age, $length, $quality, $price, $ISBN, $mediaID);
    $stmt->execute();

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

    header("Location: media.php");
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
        <input type="text" name="m-name" style="margin-top:3px;" value="<?php echo $media->title ?>">

        <!-- Author -->
        <label for="m-author[]">Author(s):</label>
        <select name="m-author[]" multiple>
            <?php
            // Dynamically create the option list for the authors
            foreach($authorList as $author) {
                echo "<option value=". $author->ID;
                // If the media already has the author, mark it as selected
                foreach($media->authors as $a) {
                    if($author->name == $a) {
                        echo " selected";
                        break;
                    }
                }
                
                echo ">" . $author->name . "</option>";
            }
            ?>
        </select>
        <a href="new-author.php">Add New Author</a>

        <!-- Genre -->

        <label for="m-genre[]">Genre(s):</label>
        <select name="m-genre[]" multiple>
            <?php
            // Dynamically create the option list for the genres
            foreach($genreList as $genre) {
                echo "<option value=". $genre->ID;
                // If the media already has the genre, mark it as selected
                foreach($media->genres as $g) {
                    if($genre->name == $g) {
                        echo " selected";
                        break;
                    }
                }
                echo ">" . $genre->name . "</option>";
            }
            ?>
        </select>
        <a href="new-genre.php">Add New Genre</a>

        <!-- Type -->

        <label for="m-type">Type:</label>
        <select name="m-type" style="margin-top:3px;">
            <?php 
                // Create options for media type based on the given data
                $data = ["Book","Movie","Audio Book","Refrense Book"];
                foreach($data as $d) {
                    echo "<option value=" . $d;
                    // The medias current type is marked as selected
                    if($media->type == $d) {echo " selected";}
                    echo ">" . $d . "</option>";
                }
            ?>
        </select>

        <!-- Age requirement -->

        <label for="m-age">Age requirement:</label>
        <select name="m-age" style="margin-top:3px;">
            <?php 
                // Create options for age restrictions based on the given data
                $data = [[0,"None"],[3,"3"],[7,"7"],[9,"9"],[12,"12"],[16,"16"],[18,"18+"]];
                foreach($data as $d) {
                    echo "<option value=" . $d[0];
                    // The medias current age restriction is marked as selected
                    if($media->ageRestriction == $d[0]) {echo " selected";}
                    echo ">" . $d[1] . "</option>";
                }
            ?>
        </select>
        
        <!-- Length -->
        <label for="m-length">Length:</label>
        <input type="number" name="m-length" value="<?php echo $media->length ?>">

        <!-- Condition -->
        <label for="m-cond">Condition:</label>
        <input type="number" name="m-cond" value="<?php echo $media->quality ?>">

        <!-- Price -->
        <label for="m-price">Price:</label>
        <input type="number" name="m-price" value="<?php echo $media->price ?>">

        <!-- ISBN -->

        <label for="m-isbn">ISBN:</label>
        <input type="text" name="m-isbn" value="<?php echo $media->ISBN ?>">

        <input type="submit" value="Save">
    </form>
    
</body>
</html>