<?php
include $_SERVER["DOCUMENT_ROOT"]."/connection_database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Обробка завантаження нового зображення
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = '/uploads/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $uploadFile)) {
            $image = $uploadFile;
        } else {
            $image = $_POST['current_image'];
        }
    } else {
        $image = $_POST['current_image'];
    }

    $stmt = $dbh->prepare("UPDATE users SET name=:name, email=:email, phone=:phone, image=:image WHERE id=:id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':image', $image);
    $stmt->execute();

    header("Location: /index.php");
    exit();
}
?>

