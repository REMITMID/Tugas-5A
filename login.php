<?php
session_start();
if(isset($_SESSION['email'])) {
    header("Location: form.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Get domain from email
    $domain = substr(strrchr($email, "@"), 1);
    
    if($password === $domain) {
        $_SESSION['email'] = $email;
        header("Location: form.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        .container {
            width: 300px;
            margin: 50px auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>