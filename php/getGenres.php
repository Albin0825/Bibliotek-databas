<?php
require_once('../db.php');

$sql = "SELECT * FROM genre";

$genreList = [];

// Put all genres in the genreList array
foreach ($conn->query($sql) as $row) {
    $g = new stdClass;
    $g->ID = $row['ID'];
    $g->name = $row['name'];
    array_push($genreList,$g);
}
?>