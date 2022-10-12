<?php
require_once('../db.php');

$mediaID = $_GET['id'];

$sql = array("DELETE FROM media WHERE ID = ?",
    "DELETE FROM mediacreator WHERE mID = ?",
    "DELETE FROM mediagenre WHERE mID = ?");

for($i=0;$i<3;$i++) {
    $stmt = $conn->prepare($sql[$i]);
    $stmt->bind_param("i", $mediaID);
    $stmt->execute();
}

header("location: ../admin/media.php");
?>