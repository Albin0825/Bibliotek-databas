<?php
require_once('../db.php');

$sql = "SELECT * FROM genres";

$genreList = [];

// Put all genres in the genreList array
foreach ($conn->query($sql) as $row) {
    array_push($genreList,$row);
}
?>