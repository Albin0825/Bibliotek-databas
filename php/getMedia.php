<?php
require_once('../db.php');

$sql = "SELECT * FROM media";

$mediaList = [];

// Put all media in the mediaList array
foreach ($conn->query($sql) as $row) {
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
?>