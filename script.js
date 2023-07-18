function updateDLT() {
    // Select the task list element from the HTML
    var taskListElement = document.getElementById('taskList');
    var taskSearchElement = document.getElementById('searchList');

    // Clear out the current task list display
    taskListElement.innerHTML = '';
    taskSearchElement.innerHTML = '';

    // Make an AJAX request to fetch the task list from the PHP file
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_tasks.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parse the JSON response
            var tasks = JSON.parse(xhr.responseText);

            // Loop through each task
            tasks.forEach(function (task) {
                // Create a new div to represent the task
                var taskElement = document.createElement('div');
                taskElement.className = 'newtask';

                // Populate the div with the task's details
                taskElement.innerHTML = `
                    <h3>Title: ${task.title}</h3>
                    <p>Description: ${task.description}</p>
                    <p>Due: ${task.dueDate}</p>
                    <p>Reminder Time: ${task.reminderTime}</p>
                    <p>Status: ${task.status}</p>
                    <p>Priority: ${task.priority}</p>
                    <button onclick="editTask(${task.id})">Edit</button>
                    <button onclick="deleteTask(${task.id})">Delete</button>
                `;

                // Add this new task div to the task list display
                taskListElement.appendChild(taskElement);
            });
        }
    };
    xhr.send();
}

// Function to add a new task
document.getElementById('addTask').addEventListener('click', function () {
    var title = document.getElementById('title').value;
    var description = document.getElementById('description').value;
    var dueDate = document.getElementById('dueDate').value;
    var reminderTime = document.getElementById('reminderTime').value;
    var status = document.getElementById('status').value;
    var priority = document.getElementById("priority").value;

    if (title && description && dueDate && reminderTime && status && priority) {

        // Make an AJAX request to insert the new task into the database
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'add_task.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Clear the input fields
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            document.getElementById('dueDate').value = '';
            document.getElementById('reminderTime').value = '';
            document.getElementById('status').value = 'pending';
            document.getElementById('priority').value = 'High';

            // Update the task list display
            updateDLT();
        }
    };
    xhr.send(`title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&dueDate=${encodeURIComponent(dueDate)}&reminderTime=${encodeURIComponent(reminderTime)}&status=${encodeURIComponent(status)}&priority=${encodeURIComponent(priority)}`);
}
    else {
    alert('Please fill in all the fields.');
    }
    }
);

// Function to delete a task
function deleteTask(id) {
    // Make an AJAX request to delete the task from the database
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_task.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Update the task list display
            updateDLT();
        }
    };
    xhr.send(`id=${encodeURIComponent(id)}`);
}

// Function to edit a task
// Function to edit a task
// Function to fetch and populate task details for editing
function editTask(id) {
    // Make an AJAX request to fetch the task details from the PHP file
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parse the JSON response
            var task = JSON.parse(xhr.responseText);
            console.log(task);

            // Populate the input fields with the task details
            document.getElementById('title').value = task.title || '';
            document.getElementById('description').value = task.description || '';
            document.getElementById('dueDate').value = task.dueDate || '';
            document.getElementById('')
            document.getElementById('status').value = task.status || '';
            document.getElementById('editId').value = task.id || '';

            // Change the button to "Update" mode
            document.getElementById('addTask').style.display = 'none';
            document.getElementById('updateTask').style.display = 'inline-block';
           
        }
    };
    xhr.send(`id=${encodeURIComponent(id)}`);
}

// Function to update the edited task
document.getElementById('updateTask').addEventListener('click', function () {
    var id = document.getElementById('editId').value;
    var title = document.getElementById('title').value;
    var description = document.getElementById('description').value;
    var dueDate = document.getElementById('dueDate').value;
    var status = document.getElementById('status').value;

    console.log(id);

    // Make an AJAX request to update the task in the database
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_task.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        console.log(xhr.responseText)
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Clear the input fields and edit ID
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            document.getElementById('dueDate').value = '';
            document.getElementById('reminderTime').value = '';
            document.getElementById('status').value = '';
            document.getElementById('priority').value = '';

            // Change the button back to "Add Task" mode
            document.getElementById('addTask').style.display = 'inline-block';
            document.getElementById('updateTask').style.display = 'none';

            // Update the task list display
            updateDLT();
        }
    };
    xhr.send(`id=${encodeURIComponent(id)}&title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&dueDate=${encodeURIComponent(dueDate)}&status=${encodeURIComponent(status)}`);
});



// Function to show the task list
function showTaskList() {
    

    var taskListElement = document.getElementById('taskList');
    TaskListStyle = taskListElement.style.display;
    console.log(TaskListStyle);

    // Toggle the display style of the task list
    if (TaskListStyle == 'none') {
        taskListElement.style.display = 'block';
    }
    updateDLT();
}


//Function To Show Search List
function showSearchList(task_list_display) {
    

    var taskSearchElement = document.getElementById('searchList');
    TaskSearchStyle = taskSearchElement.style.display;
    console.log(TaskSearchStyle);

    // Toggle the display style of the task list
    if (TaskSearchStyle == 'none') {
        
        taskSearchElement.style.display = 'block';
         // Update the task list when it is shown
    } 
}


document.getElementById('searchTask').addEventListener('click', function () {
    var title= document.getElementById('title').value;
    console.log("Title:", title);
    if (title) {
        document.getElementById('title').value = '';
        document.getElementById('description').value = '';
        document.getElementById('dueDate').value = '';
        document.getElementById('reminderTime').value = '';
        document.getElementById('status').value = 'pending';
        document.getElementById('priority').value = 'High';
    }

    else {
        alert('Please fill in title field.');
        return;
    }
     // Select the task list element from the HTML
     var taskSearchElement = document.getElementById('searchList');
    var taskListElement = document.getElementById('taskList');
     
     // Clear out the current task list display
     taskListElement.innerHTML = '';
     

     // Make an AJAX request to fetch the task list from the PHP file
     var xhr = new XMLHttpRequest();
     xhr.open('POST', 'get_tasks.php', true);
     xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
     xhr.onreadystatechange = function () {
         if (xhr.readyState === 4 && xhr.status === 200) {
            // Update the task list display
            
            var tasks = JSON.parse(xhr.responseText);
            tasks.forEach(function (task) {
                // Create a new div to represent the task
                if (task.title == title) {
                    console.log("Task found:", task.title);
                    // Clear out the current task list display
                    taskSearchElement.innerHTML = '';
                    var taskElement = document.createElement('div');
                    taskElement.className = 'newtask';

                // Populate the div with the task's details
                    taskElement.innerHTML = `
                    <h3>Title: ${task.title}</h3>
                    <p>Description: ${task.description}</p>
                    <p>Due: ${task.dueDate}</p>
                    <p>Reminder Time: ${task.reminderTime}</p>
                    <p>Status: ${task.status}</p>
                    <p>Priority: ${task.priority}</p>
                    <button onclick="editTask(${task.id})">Edit</button>
                    <button onclick="deleteTask(${task.id})">Delete</button>
                `;
                    // Add this new task div to the task list display
                taskSearchElement.appendChild(taskElement);
                
            }

                });

            }

        }
        showSearchList();
        xhr.send();
}

)

