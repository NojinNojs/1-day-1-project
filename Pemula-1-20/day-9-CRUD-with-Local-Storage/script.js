// script.js

// Defining an array to store data
let dataList = [];

// Initializing Bootstrap 5 modals
let editModal = new bootstrap.Modal(document.getElementById("editModal"));
let deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));

// Function to display notifications
function showAlert(message, className) {
  const alert = document.getElementById("alert");
  alert.className = `alert ${className}`;
  alert.textContent = message;
  alert.classList.remove("d-none");
  setTimeout(() => {
    alert.classList.add("d-none");
  }, 3000);
}

// Function to save data to local storage
function saveData() {
  localStorage.setItem("dataList", JSON.stringify(dataList));
}

// Function to load data from local storage
function loadData() {
  const data = localStorage.getItem("dataList");
  if (data) {
    dataList = JSON.parse(data);
  } else {
    dataList = [];
  }
}

// Function to render data to the table
function renderData() {
  const dataListElement = document.getElementById("dataList");
  dataListElement.innerHTML = "";

  dataList.forEach((data, index) => {
    const row = document.createElement("tr");

    row.innerHTML = `
            <td>${data.name}</td>
            <td>${data.description}</td>
            <td>
                <button class="btn btn-sm btn-outline-light edit-btn" data-index="${index}" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger delete-btn" data-index="${index}" title="Delete">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;

    dataListElement.appendChild(row);
  });
}

// Function to add new data
function addData(e) {
  e.preventDefault();

  const name = document.getElementById("name").value.trim();
  const description = document.getElementById("description").value.trim();

  if (name === "" || description === "") {
    showAlert("All fields must be filled!", "alert-danger");
    return;
  }

  const newData = {
    name,
    description,
  };

  dataList.push(newData);
  saveData();
  renderData();
  document.getElementById("dataForm").reset();
  showAlert("Data successfully added!", "alert-success");
}

// Function to fill the edit form
function fillEditForm(index) {
  const data = dataList[index];
  document.getElementById("editIndex").value = index;
  document.getElementById("editName").value = data.name;
  document.getElementById("editDescription").value = data.description;
  editModal.show();
}

// Function to save data changes
function updateData(e) {
  e.preventDefault();

  const index = document.getElementById("editIndex").value;
  const name = document.getElementById("editName").value.trim();
  const description = document.getElementById("editDescription").value.trim();

  if (name === "" || description === "") {
    showAlert("All fields must be filled!", "alert-danger");
    return;
  }

  dataList[index] = { name, description };
  saveData();
  renderData();
  editModal.hide();
  showAlert("Data successfully updated!", "alert-success");
}

// Function to show delete confirmation modal
function showDeleteModal(index) {
  document.getElementById("deleteIndex").value = index;
  deleteModal.show();
}

// Function to delete data after confirmation
function deleteData() {
  const index = document.getElementById("deleteIndex").value;
  dataList.splice(index, 1);
  saveData();
  renderData();
  deleteModal.hide();
  showAlert("Data successfully deleted!", "alert-success");
}

// Event Listener
document.getElementById("dataForm").addEventListener("submit", addData);
document.getElementById("editForm").addEventListener("submit", updateData);
document.getElementById("confirmDelete").addEventListener("click", deleteData);
document.getElementById("dataList").addEventListener("click", (e) => {
  if (e.target.closest(".delete-btn")) {
    const index = e.target.closest(".delete-btn").getAttribute("data-index");
    showDeleteModal(index);
  } else if (e.target.closest(".edit-btn")) {
    const index = e.target.closest(".edit-btn").getAttribute("data-index");
    fillEditForm(index);
  }
});

// Initialize application
loadData();
renderData();
