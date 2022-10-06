<?php
require_once('../db.php');

$sql = "SELECT * FROM genres";

$mediaList = [];

foreach ($conn->query($sql) as $row) {
    array_push($mediaList,$row);
}

echo $mediaList;
?>