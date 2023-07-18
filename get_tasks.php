<?php

// Establish a database connection
$host = 'localhost';
$db = 'task_manager';
$user = 'root';
$password = '';

$mysqli = new mysqli($host, $user, $password, $db);

// Fetch all tasks from the database
$query = "SELECT * FROM tasks  " ;
$result = $mysqli->query($query);

$tasks = array();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

// Send the tasks as a JSON response
header('Content-Type: application/json');
echo json_encode($tasks);
echo $row;
?>


