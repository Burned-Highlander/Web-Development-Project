<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

// Database connection
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'task_login';

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if the user is already registered
function isUserRegistered($username, $conn) {
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Registration process
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isUserRegistered($username, $conn)) {
        echo 'You are already registered. Please login.';
    } else {

        $username = test_input($username);
        $password = test_input($password);
        $password = password_hash($password, PASSWORD_DEFAULT);
        // Insert user into the database
        $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        $stmt->bind_param('ss', $username, $password);
        if ($stmt->execute()) {
            // Redirect to login page
            header("Location: login.php");
            exit();
        } else {
            echo 'Error: ' . $stmt->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <h2>Registration</h2>
    <form method="POST" action="register.php">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit" name="register">Register</button>
    </form>
    <br>
    <form method="GET" action="login.php">
        <h5>If you already have an account, go to login. Thank you.</h5>
        <button type="submit">Login</button>
    </form>
</body>
</html>
