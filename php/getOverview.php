<?php
require_once('../db.php');

$sql = "SELECT 
    (SELECT COUNT(ID) FROM media) AS mediaCount,
    (SELECT COUNT(ID) FROM user) AS userCount,
    (SELECT COUNT(ID) FROM borrow) AS borrowCount,
    (SELECT COUNT(ID) FROM media WHERE type = 'Book') AS bookCount,
    (SELECT COUNT(ID) FROM media WHERE type = 'Movie') AS movieCount,
    (SELECT COUNT(ID) FROM media WHERE type = 'Audiobook') AS audioCount,
    (SELECT COUNT(ID) FROM media WHERE type = 'Refrense Book') AS refCount";

$result = mysqli_query($conn,$sql);
$stats = mysqli_fetch_assoc($result);
?>