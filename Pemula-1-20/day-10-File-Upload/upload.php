<?php
// Set the target directory
$targetDir = "uploads/";

// Create the uploads directory if it doesn't exist
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

// Check the number of files in the uploads directory
$filesInDirectory = array_diff(scandir($targetDir), array('.', '..'));
$currentFileCount = 0;
foreach ($filesInDirectory as $file) {
    if (is_file($targetDir . $file)) {
        $currentFileCount++;
    }
}

// Check if a file has been uploaded
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['files'])) {
    // Allowed file extensions
    $allowedTypes = array('jpg', 'jpeg', 'png');

    // Maximum file size in bytes (e.g., 10MB)
    $maxSize = 10 * 1024 * 1024;

    $files = $_FILES['files'];

    // Count total files to be uploaded
    $totalFiles = count($files['name']);

    // Check if total files exceed the limit
    if ($currentFileCount + $totalFiles > 10) {
        $error = 'Uploading these files will exceed the maximum limit of 10 files.';
        header("Location: index.php?status=error&message=" . urlencode($error));
        exit;
    }

    $errors = array();
    $successCount = 0;

    // Process each file
    for ($i = 0; $i < $totalFiles; $i++) {
        // Check for upload errors
        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            $errors[] = $files['name'][$i] . ' - An error occurred while uploading the file.';
            continue;
        }

        // Check file size
        if ($files['size'][$i] > $maxSize) {
            $errors[] = $files['name'][$i] . ' - File size is too large. Maximum is 10MB.';
            continue;
        }

        // Get file extension
        $fileExt = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));

        // Check if file type is allowed
        if (!in_array($fileExt, $allowedTypes)) {
            $errors[] = $files['name'][$i] . ' - File type is not allowed.';
            continue;
        }

        // Sanitize file name
        $fileName = basename($files['name'][$i]);
        $fileName = preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $fileName);

        // Create a unique file name to prevent overwriting
        $newFileName = uniqid() . '_' . $fileName;

        // Set the target file path
        $targetFile = $targetDir . $newFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($files['tmp_name'][$i], $targetFile)) {
            // Set file permissions
            chmod($targetFile, 0644);

            // Convert and compress image to WEBP
            $convertedFileName = pathinfo($newFileName, PATHINFO_FILENAME) . '.webp';
            $convertedFilePath = $targetDir . $convertedFileName;

            // Convert and compress image
            if (convertImageToWebp($targetFile, $convertedFilePath)) {
                // Delete the original uploaded file
                unlink($targetFile);
                $newFileName = $convertedFileName;
            } else {
                $errors[] = $files['name'][$i] . ' - Failed to convert image to WEBP.';
                // Delete the failed conversion file
                unlink($targetFile);
                continue;
            }

            $successCount++;
        } else {
            $errors[] = $files['name'][$i] . ' - Failed to save the file.';
        }
    }

    // Prepare feedback message
    if ($successCount > 0) {
        $message = $successCount . ' files were successfully uploaded.';
        if (!empty($errors)) {
            $message .= ' However, some files failed to upload.';
        }
        header("Location: index.php?status=success&message=" . urlencode($message));
        exit;
    } else {
        $message = 'No files were successfully uploaded.';
        if (!empty($errors)) {
            $message .= ' Errors: ' . implode(', ', $errors);
        }
        header("Location: index.php?status=error&message=" . urlencode($message));
        exit;
    }
} else {
    $error = 'No files were uploaded.';
    header("Location: index.php?status=error&message=" . urlencode($error));
    exit;
}

// Function to convert image to WEBP format
function convertImageToWebp($source, $destination, $quality = 80)
{
    // Get image info
    $info = getimagesize($source);
    $mime = $info['mime'];

    // Create image resource from source file
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            // Preserve transparency for PNG
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            break;
        default:
            return false;
    }

    // Convert and save image as WEBP
    $result = imagewebp($image, $destination, $quality);
    imagedestroy($image);
    return $result;
}
?>