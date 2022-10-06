<?php
require_once('../db.php');

$sql = "SELECT * FROM media";

$mediaList = [];

// Put all media in the mediaList array
foreach ($conn->query($sql) as $row) {
    array_push($mediaList,$row);
}
?>