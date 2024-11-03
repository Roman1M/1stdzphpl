<?php
include $_SERVER["DOCUMENT_ROOT"]."/connection_database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Обробка завантаження зображення
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = '/uploads/'; // Директорія для завантаження
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        // Перевірка на коректність та збереження файлу
        if (move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $uploadFile)) {
            $image = $uploadFile;
        } else {
            $image = ''; // або зробіть обробку помилки
        }
    } else {
        $image = '';
    }

    $stmt = $dbh->prepare("INSERT INTO users (name, email, phone, image) VALUES (:name, :email, :phone, :image)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':image', $image);
    $stmt->execute();

    header("Location: /index.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати користувача</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="text-center">Додати користувача</h1>
    <form action="create.php" method="post" class="col-md-6 offset-md-3" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">ПІБ</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Пошта</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Телефон</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Фото</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Додати</button>
    </form>
</div>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>

