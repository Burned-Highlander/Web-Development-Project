

<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link rel="stylesheet"  href="ahmad_241546585.css">
   
</head>
<body>
    <?php
    // Check if user is authenticated
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit(); // Add this line to stop further execution of the code
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
     session_destroy();
     header('Location: login.php');
     exit();

    }
    
    ?>

    <h1>Task Manager       
        <form method="POST" action = "index.php" style="display:inline"> 
            <input type="hidden" name="logout" value="true">
            <button type="submit" id="log_out" style="position:relative; left:80%;">Log Out</button>
        </form>         
    </h1>
    <h2>Add New Task</h2>
    <label>Title:</label>
    <input type="text" id="title" required><br>
    <label>Description:</label>
    <input type="text" id="description" required><br>
    <label>Due Date:</label>
    <input type="date" id="dueDate" required><br>
    <label>Reminder Time:</label>
    <input type="time" id="reminderTime" required><br>
    <label>Status:</label>
    <select id="status">
        <option value="pending">Pending</option>
        <option value="complete">Complete</option>
    </select><br>
    <label>Priority:</label>
    <select id="priority">
        <option value="High">High</option>
        <option value="Low">Low</option>
    </select><br>
    <button id="addTask">Add Task</button>
    <button id="searchTask">Search Via Title</button>
    <button onclick="showTaskList()">Show Tasks</button>
    <button id="updateTask" style="display: none;">Update Task</button>
    <button id="editId" style="display: none;">Update Task</button>
    

    <br>
    <div id="taskList" style="display: none;"></div>
    <div id="searchList" style="display: none;"></div>
    <script src="script.js"></script>
</body>
</html>
