<?php
include $_SERVER["DOCUMENT_ROOT"]."/connection_database.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $dbh->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

header("Location: /index.php");
exit();
?>
