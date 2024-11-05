<?php
session_start();

// Initialize task list if not exists
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand brand-logo" href="#">
                <i class="bi bi-check2-square me-2"></i>Task Manager
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">
                            <i class="bi bi-house-door me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="reset_tasks.php" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Clear all tasks">
                            <i class="bi bi-trash me-1"></i>Reset
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="task-container">
            <h1 class="h3 mb-4"><i class="bi bi-list-task me-2"></i>Task List</h1>

            <form action="add_task.php" method="post" class="mb-4">
                <div class="input-group">
                    <input type="text" name="task" class="form-control form-control-lg" placeholder="Add a new task..."
                        required>
                    <button class="btn btn-primary px-4" type="submit" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Add new task">
                        <i class="bi bi-plus-lg me-1"></i>Add
                    </button>
                </div>
            </form>

            <?php if (empty($_SESSION['tasks'])): ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox display-1"></i>
                    <p class="mt-3">No tasks yet. Add a new task above.</p>
                </div>
            <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="<?php echo $task['completed'] ? 'text-decoration-line-through text-muted' : ''; ?>">
                                <?php if ($task['completed']): ?>
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <?php else: ?>
                                    <i class="bi bi-circle me-2"></i>
                                <?php endif; ?>
                                <?php echo htmlspecialchars($task['name']); ?>
                            </span>
                            <div>
                                <?php if (!$task['completed']): ?>
                                    <a href="complete_task.php?index=<?php echo $index; ?>"
                                        class="btn btn-success btn-sm btn-action me-1" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Mark as complete">
                                        <i class="bi bi-check-lg"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="delete_task.php?index=<?php echo $index; ?>" class="btn btn-danger btn-sm btn-action"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Delete task">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>