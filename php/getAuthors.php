<?php
require_once('../db.php');

$sql = "SELECT * FROM creator";

$authorList = [];

// Put all authors in the authorList array
foreach ($conn->query($sql) as $row) {
    $a = new stdClass;
    $a->ID = $row['ID'];
    $a->name = $row['name'];
    array_push($authorList,$a);
}
?>