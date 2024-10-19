// Akses elemen HTML
const taskInput = document.getElementById("task-input");
const taskList = document.getElementById("task-list");
const addTaskButton = document.getElementById("add-task-btn");
const clearAllButton = document.getElementById("clear-all-btn");
const clearCompletedButton = document.getElementById("clear-completed-btn");
const reverseSortButton = document.getElementById("reverse-sort-btn");
const noTaskMessage = document.getElementById("no-task-msg");

// Bootstrap Toast
const toastElement = document.querySelector(".toast");
const toastBody = toastElement.querySelector(".toast-body");
const toastProgress = document.getElementById("toast-progress");
const toast = new bootstrap.Toast(toastElement);

// Modal
let taskToDelete = null;
const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
const confirmDeleteBtn = document.getElementById("confirm-delete-btn");
const editModal = new bootstrap.Modal(document.getElementById("editModal"));
const editTaskInput = document.getElementById("edit-task-input");
let taskToEdit = null;

// Load tasks from local storage
let tasks = JSON.parse(localStorage.getItem("tasks")) || [];

// Fungsi untuk render task list
function renderTasks() {
  taskList.innerHTML = ""; // Bersihkan list
  tasks.forEach((task, index) => {
    const taskItem = document.createElement("li");
    taskItem.classList.add(
      "list-group-item",
      "d-flex",
      "align-items-center",
      "justify-content-between",
      "fade-in" // Added animation class
    );

    // Tampilkan checkbox dan teks tugas
    const taskTextWrapper = document.createElement("div");
    taskTextWrapper.classList.add("d-flex", "align-items-center");
    const taskCheckbox = document.createElement("input");
    taskCheckbox.type = "checkbox";
    taskCheckbox.classList.add("form-check-input", "me-2");
    taskCheckbox.checked = task.completed;
    taskCheckbox.addEventListener("change", () => toggleCompleteTask(index));

    const taskText = document.createElement("span");
    taskText.classList.add("task-text"); // Added class for styling
    if (task.completed) {
      taskText.classList.add("text-decoration-line-through");
    }
    taskText.textContent = task.title;

    taskTextWrapper.appendChild(taskCheckbox);
    taskTextWrapper.appendChild(taskText);

    // Tampilkan tombol edit dan hapus
    const taskActions = document.createElement("div");
    const editButton = document.createElement("button");
    editButton.classList.add("btn", "btn-sm", "btn-warning", "me-2");
    editButton.innerHTML = '<i class="fas fa-edit"></i>';
    editButton.addEventListener("click", () => {
      taskToEdit = index;
      editTaskInput.value = tasks[index].title;
      editModal.show();
    });

    const deleteButton = document.createElement("button");
    deleteButton.classList.add("btn", "btn-sm", "btn-danger");
    deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
    deleteButton.addEventListener("click", () => {
      taskToDelete = index;
      deleteModal.show();
    });

    taskActions.appendChild(editButton);
    taskActions.appendChild(deleteButton);

    taskItem.appendChild(taskTextWrapper);
    taskItem.appendChild(taskActions);
    taskList.appendChild(taskItem);
  });

  // Tampilkan pesan jika tidak ada task
  noTaskMessage.classList.toggle("d-none", tasks.length > 0);

  // Simpan tasks ke local storage
  localStorage.setItem("tasks", JSON.stringify(tasks));
}

// Fungsi untuk menambah task
function addTask() {
  const taskTitle = taskInput.value.trim();
  if (taskTitle) {
    tasks.push({ title: taskTitle, completed: false });
    taskInput.value = "";
    renderTasks();
    showToast("Task added!");
  }
}

// Fungsi untuk toggle complete task
function toggleCompleteTask(index) {
  tasks[index].completed = !tasks[index].completed;
  renderTasks();
}

// Fungsi untuk menghapus task
function deleteTask(index) {
  tasks.splice(index, 1);
  renderTasks();
  showToast("Task deleted!");
}

// Fungsi untuk mengedit task
function editTask() {
  const newTitle = editTaskInput.value.trim();
  if (newTitle) {
    tasks[taskToEdit].title = newTitle;
    renderTasks();
    showToast("Task edited!");
    editModal.hide();
  }
}

// Fungsi untuk clear all tasks
clearAllButton.addEventListener("click", () => {
  if (tasks.length > 0) {
    tasks = [];
    renderTasks();
    showToast("All tasks cleared!");
  }
});

// Fungsi untuk clear completed tasks
clearCompletedButton.addEventListener("click", () => {
  tasks = tasks.filter((task) => !task.completed);
  renderTasks();
  showToast("Completed tasks cleared!");
});

// Fungsi untuk reverse sort tasks
reverseSortButton.addEventListener("click", () => {
  tasks.reverse();
  renderTasks();
  showToast("Tasks sorted!");
});

// Fungsi untuk menghapus task dengan konfirmasi modal
confirmDeleteBtn.addEventListener("click", () => {
  deleteTask(taskToDelete);
  deleteModal.hide();
});

// Fungsi untuk mengedit task dengan modal
document.getElementById("confirm-edit-btn").addEventListener("click", editTask);

// Fungsi untuk menampilkan toast notification
function showToast(message) {
  toastBody.textContent = message;
  toastProgress.style.width = '100%';
  toast.show();

  let progress = 100;
  const interval = setInterval(() => {
    progress -= 20; // Decrease progress
    toastProgress.style.width = `${progress}%`;
    if (progress <= 0) {
      clearInterval(interval);
      toast.hide();
    }
  }, 1000); // Update every second
}

// Event listener untuk menambah task
addTaskButton.addEventListener("click", () => {
  addTask();
});

// Event listener untuk menambah task ketika tekan "Enter"
taskInput.addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    addTask();
  }
});

// Render tasks ketika halaman pertama kali dimuat
renderTasks();
