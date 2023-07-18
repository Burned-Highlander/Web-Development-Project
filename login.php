
<?php
// Database connection
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'task_login';

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Login process
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username and password match
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Start session and store username
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            session_start();
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit();
        }
        
    } 
    
    else {
        $errorMessage = 'Invalid username or password.';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>

     <link rel="stylesheet" href="login.css">
    <title>Login</title>
    

</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <?php if (isset($errorMessage)) : ?>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <label>Username:</label>
            <input type="text" name="username" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
        <form method="GET" action="register.php">
            <h5>If you don't have an account then register it first  THANK YOU</h5> 
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
