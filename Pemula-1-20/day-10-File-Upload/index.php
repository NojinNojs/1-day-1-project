<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
    <!-- Responsive Meta Tag -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .upload-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .drag-area {
            border: 2px dashed #4CAF50;
            padding: 2rem;
            border-radius: 5px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            background: #fafafa;
        }

        .drag-area:hover {
            background: #f1f1f1;
            border-color: #2E7D32;
        }

        .preview-image {
            max-height: 200px;
            object-fit: contain;
            border-radius: 5px;
            margin-top: 1rem;
        }

        .file-details {
            margin-top: 1rem;
            text-align: left;
        }

        .file-item {
            margin-bottom: 0.5rem;
        }

        .uploaded-files .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .uploaded-files .card-img-top {
            max-height: 150px;
            object-fit: cover;
        }

        .no-files {
            text-align: center;
            color: #777;
            margin-top: 2rem;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="upload-container">
            <h2 class="text-center mb-4">File Upload</h2>

            <!-- Feedback Messages -->
            <?php if (isset($_GET['status'])): ?>
                <?php if ($_GET['status'] == 'success'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> File uploaded successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> <?php echo htmlspecialchars($_GET['message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!--Upload Form -->
            <form action="upload.php" method="post" enctype="multipart/form-data" id="uploadForm">
                <div class="mb-4">
                    <div class="drag-area" id="dragArea">
                        <svg width="50" height="50" fill="#4CAF50" class="mb-3" viewBox="0 0 16 16">
                            <path
                                d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path
                                d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                        </svg>
                        <h5 id="dragText">Drag & Drop files here</h5>
                        <p class="text-muted">or</p>
                        <input class="form-control" type="file" id="fileInput" name="files[]" required hidden multiple
                            accept=".jpg,.jpeg,.png">
                        <button type="button" class="btn btn-outline-success"
                            onclick="document.getElementById('fileInput').click()">
                            Browse Files
                        </button>
                        <p class="mt-3 text-muted small">Supported formats: JPG, PNG (Max size: 10MB)</p>
                    </div>
                </div>
                <!--File Details -->
                <div class="file-details" id="fileDetails" style="display: none;">
                    <p><strong>Selected file:</strong></p>
                    <ul id="fileList"></ul>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4" id="uploadBtn" disabled>
                        <span class="me-2">Upload</span>
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                            <path
                                d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Display Uploaded Files -->
            <div class="uploaded-files mt-5">
                <h3 class="text-center mb-4">Uploaded Files</h3>
                <div class="row">
                    <?php
                    $files = array_diff(scandir('uploads/'), array('.', '..'));
                    if (!empty($files)):
                        foreach ($files as $file):
                            if (is_file('uploads/' . $file)):
                                $filePath = 'uploads/' . $file;
                                $fileExt = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                ?>
                                <div class="col-md-3">
                                    <div class="card mb-4">
                                        <?php if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'webp'])): ?>
                                            <img src="<?php echo $filePath; ?>" class="card-img-top" alt="Uploaded Image">
                                        <?php else: ?>
                                            <div class="card-body text-center">
                                                <svg width="50" height="50" fill="#4CAF50" class="mb-3" viewBox="0 0 16 16">
                                                    <path d="M4 0h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" />
                                                    <path d="M4.5 3h7v1h-7V3zM4.5 6h7v1h-7V6z" />
                                                </svg>
                                                <p><?php echo htmlspecialchars($file); ?></p>
                                                <a href="<?php echo $filePath; ?>" class="btn btn-success btn-sm" target="_blank">View
                                                    File</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php
                            endif;
                        endforeach;
                    else:
                        ?>
                        <p class="no-files">No files uploaded yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script>
        const dragArea = document.getElementById('dragArea');
        const fileInput = document.getElementById('fileInput');
        const fileDetails = document.getElementById('fileDetails');
        const fileList = document.getElementById('fileList');
        const uploadBtn = document.getElementById('uploadBtn');
        const dragText = document.getElementById('dragText');

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dragArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop area
        ['dragenter', 'dragover'].forEach(eventName => {
            dragArea.addEventListener(eventName, () => {
                dragArea.classList.add('bg-light');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dragArea.addEventListener(eventName, () => {
                dragArea.classList.remove('bg-light');
            }, false);
        });

        // Menangani file yang dijatuhkan
        dragArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length) {
                fileInput.files = files;
                updateFileDetails(files);
            }
        }

        // Menangani file yang dipilih
        fileInput.addEventListener('change', function (e) {
            if (e.target.files.length) {
                updateFileDetails(e.target.files);
            }
        });

        function updateFileDetails(files) {
            fileList.innerHTML = '';
            Array.from(files).forEach(file => {
                const listItem = document.createElement('li');
                listItem.classList.add('file-item');
                listItem.textContent = `${file.name} (${formatFileSize(file.size)})`;
                fileList.appendChild(listItem);
            });
            fileDetails.style.display = 'block';
            dragText.textContent = `${files.length} file dipilih`;
            uploadBtn.disabled = false;
        }

        function formatFileSize(bytes) {
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes === 0) return '0 Byte';
            const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10);
            return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
        }
    </script>
</body>

</html>