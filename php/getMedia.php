<?php
require_once('../db.php');
require_once('../php/getGenres.php');
require_once('../php/getAuthors.php');

function find_in_array($array, $itemID) {
    for($i = 0 ; $i < sizeof($array) ; $i++) {
        if($array[$i]->ID == $itemID) {
            return $array[$i];
        }
    }
}

// Gets data for all media
if(!isset($mediaID)) {
    $sql = array("SELECT * FROM media",
        "SELECT * FROM mediacreator",
        "SELECT * FROM mediagenre");

    $result = [];
    for($i=0;$i<3;$i++) {
        $stmt = $conn->prepare($sql[$i]);
        $stmt->execute();
        array_push($result,$stmt->get_result());
    }
} 

// Gets data for a specific media ID
else {
    $sql = array("SELECT * FROM media WHERE ID = ?",
        "SELECT * FROM mediacreator WHERE mID = ?",
        "SELECT * FROM mediagenre WHERE mID = ?");

    $result = [];
    for($i=0;$i<3;$i++) {
        $stmt = $conn->prepare($sql[$i]);
        $stmt->bind_param("i", $mediaID);
        $stmt->execute();
        array_push($result,$stmt->get_result());
    }
}

$mediaList = [];

// Put all media in the mediaList array
while($row = $result[0]->fetch_assoc()) {
    $m = new stdClass;
    $m->ID = $row['ID'];
    $m->title = $row['title'];
    $m->type = $row['type'];
    $m->authors = [];
    $m->genres = [];
    $m->ageRestriction = $row['ageRestriction'];
    $m->length = $row['length'];
    $m->quality = $row['quality'];
    $m->price = $row['price'];
    $m->ISBN = $row['ISBN'];
    array_push($mediaList,$m);
}

// Add the authors into the 'authors' arrays of the specific media.
// There's probably a better way to do this with SQL. Too bad.
while($row = $result[1]->fetch_assoc()) {
    array_push(
        find_in_array($mediaList,$row['mID'])->authors,
        find_in_array($authorList,$row['cID'])->name
    );
}

// Does the same thing for genres
while($row = $result[2]->fetch_assoc()) {
    array_push(
        find_in_array($mediaList,$row['mID'])->genres,
        find_in_array($genreList,$row['gID'])->name
    );
}
?>