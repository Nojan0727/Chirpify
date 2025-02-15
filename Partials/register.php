<?php
include "header.php";
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim(isset($_POST['username']) ? $_POST['username'] : '');
    $password = trim(isset($_POST['password']) ? $_POST['password'] : '');
    $age = trim(isset($_POST['age']) ? $_POST['age'] : '');
    $bio = trim(isset($_POST['bio']) ? $_POST['bio'] : '');
    $error = "";

    if (empty($username) || empty($password) || empty($age) || empty($bio)) {
        $error = "All fields are required!";
    } elseif (!is_numeric($age) || $age < 13) {
        $error = "You must be at least 13 years old.";
    } else {
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
            $upload_dir = "uploads/";

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_name = basename($_FILES["profile_picture"]["name"]);
            $target_file = $upload_dir . $file_name;
            $allowed_types = ["image/jpeg", "image/png", "image/gif"];

            if (!in_array($_FILES["profile_picture"]["type"], $allowed_types)) {
                $error = "Only JPG, PNG, and GIF files are allowed.";
            } elseif (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $_SESSION['profile_picture'] = $target_file;
            } else {
                $error = "Error uploading file.";
            }
        }

        if (empty($error)) {
            $_SESSION['user'] = $username;
            $_SESSION['age'] = $age;
            $_SESSION['bio'] = $bio;
            $_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT);

            header("Location: home.php");
            exit();
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link rel="stylesheet" href="Main.css">
</head>
<body>
<div class="container">
    <h2>Create an account</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form action="register.php" method="POST" enctype="multipart/form-data">
        <label for="profile_picture">Profile Picture:</label>
        <input type="file" name="profile_picture" id="profile_picture" required>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required>

        <label for="bio">Bio:</label>
        <input type="text" name="bio" id="bio" required>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>