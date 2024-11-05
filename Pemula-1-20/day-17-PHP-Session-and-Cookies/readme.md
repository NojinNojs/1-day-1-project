# Task Reminder Application

This project is a simple yet effective task reminder application developed in PHP. It leverages sessions to manage user data, specifically for storing and tracking tasks.

## Features
- **Add Tasks**: Users can add new tasks to their list.
- **Complete Tasks**: Users can mark tasks as completed.
- **Delete Tasks**: Users can remove tasks from their list.
- **Reset Tasks**: Users can clear all tasks at once.

## Session Management
- **Task Storage**: The application uses PHP sessions to store the user's task list in `$_SESSION['tasks']`. Each task is an associative array containing the task name and its completion status.
- **Adding Tasks**: When a user submits a new task via the `add_task.php` script, it is appended to the session array.
- **Completing Tasks**: The `complete_task.php` script updates the completion status of a task based on its index in the session array.
- **Deleting Tasks**: The `delete_task.php` script allows users to remove a specific task from the session array, ensuring the task list remains current.
- **Resetting Tasks**: The `reset_tasks.php` script clears the entire task list by resetting the session variable.

## Cookie Usage
While this application primarily utilizes sessions, cookies can be integrated to enhance user experience by storing preferences such as theme settings or last visited tasks.

## Conclusion
This task reminder application effectively demonstrates the use of PHP sessions for managing user tasks, providing a seamless experience for users to keep track of their to-do lists.