<?php
session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['birthplace'] = $_POST['birthplace'];
    $_SESSION['birthdate'] = $_POST['birthdate'];
    $_SESSION['education'] = $_POST['education'];

    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = basename($_FILES["photo"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name; // Hindari nama file duplikat
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];

        if (in_array($imageFileType, $allowed_types) && $_FILES["photo"]["size"] <= 2000000) { // Batas 2MB
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $_SESSION['photo'] = $target_file;
            } else {
                $_SESSION['photo_error'] = "Gagal mengunggah foto.";
            }
        } else {
            $_SESSION['photo_error'] = "Format tidak didukung atau ukuran terlalu besar.";
        }
    }

    header("Location: cv.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Data</title>
    <style>
        .container {
            width: 400px;
            margin: 50px auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Input Your Data</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Place of Birth:</label>
                <input type="text" name="birthplace" required>
            </div>
            <div class="form-group">
                <label>Date of Birth:</label>
                <input type="date" name="birthdate" required>
            </div>
            <div class="form-group">
                <label>Education History:</label>
                <textarea name="education" required></textarea>
            </div>
            <div class ="form-group">
                <label>Upload Photo </label>
                <input type="file" name="photo" accept="image/*">
                <?php if (isset($_SESSION['photo_error'])) { echo "<p style='color:red;'>" . $_SESSION['photo_error'] . "</p>"; unset($_SESSION['photo_error']); } ?>
            </div>
            <button type="submit">Generate CV</button>
        </form>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>