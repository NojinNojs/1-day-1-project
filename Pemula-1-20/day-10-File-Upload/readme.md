# File Upload Feature Documentation

## Overview
This project demonstrates a simple file upload feature using PHP. Users can upload images in JPG, JPEG, and PNG formats, with a maximum file size of 10MB. The uploaded files are stored in a designated directory on the server.

## Features
- **Drag and Drop Interface**: Users can easily drag and drop files into the upload area.
- **File Type Validation**: Only JPG, JPEG, and PNG files are accepted.
- **File Size Limit**: Each file must not exceed 10MB.
- **Dynamic File List**: Displays a list of uploaded files with options to view them.

## Getting Started
1. **Set Up the Server**: Ensure you have a local server environment (like XAMPP or MAMP) running PHP.

2. **Create Uploads Directory**: The application will automatically create an `uploads` directory if it doesn't exist.

3. **Access the Application**: Open your browser and navigate to `http://localhost/Pemula-1-20/day-10-File-Upload/index.php`.

## Usage
- Click on the "Browse Files" button or drag and drop files into the designated area.
- After selecting files, click the "Upload" button to upload the files to the server.
- Uploaded files will be displayed below the upload area.

## Error Handling
- If the upload exceeds the file size limit or if an unsupported file type is selected, an error message will be displayed.
- The application limits the total number of uploaded files to 10.

## Conclusion
This simple file upload feature provides a user-friendly interface for uploading images using PHP. It includes essential validations and feedback mechanisms to enhance user experience.
