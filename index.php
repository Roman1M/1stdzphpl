<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список користувачів</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="text-center">Список користувачів</h1>
    <a href="create.php" class="btn btn-success mb-3">Додати користувача</a> <!-- Додана кнопка -->
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">ПІБ</th>
            <th scope="col">Фото</th>
            <th scope="col">Пошта</th>
            <th scope="col">Телефон</th>
            <th scope="col">Дії</th>
        </tr>
        </thead>
        <tbody>
        <?php
        include $_SERVER["DOCUMENT_ROOT"]."/connection_database.php";

        $sql = 'SELECT * FROM users';
        foreach ($dbh->query($sql) as $row) {
            $id = $row["id"];
            $name = $row["name"];
            $image = $row["image"];
            $email = $row["email"];
            $phone = $row["phone"];
            echo "
            <tr>
                <th scope='row'>$id</th>
                <td>$name</td>
                <td>
                    <img src='$image' alt='$name' width='100'>
                </td>
                <td>$email</td>
                <td>$phone</td>
                <td>
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal'
                        data-id='$id' data-name='$name' data-image='$image' data-email='$email' data-phone='$phone'>
                        Змінити
                    </button>
                    <a href='delete.php?id=$id' class='btn btn-danger'>Видалити</a>
                </td>
            </tr>
            ";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Модальне вікно редагування -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="edit.php" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Редагувати користувача</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit-id">
                <input type="hidden" name="current_image" id="current-image">

                <div class="mb-3">
                    <label for="edit-name" class="form-label">ПІБ</label>
                    <input type="text" class="form-control" id="edit-name" name="name">
                </div>

                <div class="mb-3">
                    <label for="edit-email" class="form-label">Пошта</label>
                    <input type="email" class="form-control" id="edit-email" name="email">
                </div>

                <div class="mb-3">
                    <label for="edit-phone" class="form-label">Телефон</label>
                    <input type="text" class="form-control" id="edit-phone" name="phone">
                </div>

                <div class="mb-3">
                    <label for="edit-image" class="form-label">Фото</label>
                    <input type="file" class="form-control" id="edit-image" name="image" accept="image/*">
                    <img id="preview-image" src="" alt="Фото користувача" class="mt-2" style="width: 100px;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                <button type="submit" class="btn btn-primary">Зберегти зміни</button>
            </div>
        </form>
    </div>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const email = button.getAttribute('data-email');
            const phone = button.getAttribute('data-phone');
            const image = button.getAttribute('data-image');

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-phone').value = phone;
            document.getElementById('current-image').value = image;
            document.getElementById('preview-image').src = image; // Попередній перегляд поточного зображення
        });

        // Динамічний попередній перегляд вибраного зображення
        document.getElementById('edit-image').addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
</body>
</html>

