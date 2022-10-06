<?php
require_once('../db.php');

$sql = "SELECT * FROM creator";

$authorList = [];

// Put all authors in the authorList array
foreach ($conn->query($sql) as $row) {
    array_push($authorList,$row);
}
?>