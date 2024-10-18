# Nojin Notes

This is a simple PHP project where users can add notes through a basic form and display them on the main page. The project is built using PHP and stores notes in JSON format.

## Features

- Add notes (title and content).
- Display up to 5 recent notes on the main page.
- "Load More" feature to show additional notes.
- Delete notes.
- Modal form for adding notes.

## Installation

### 1. Environment Setup (Laragon or XAMPP)

#### Using Laragon

1. Download and install Laragon from [Laragon.org](https://laragon.org/download/).
2. Open Laragon and ensure Apache and MySQL servers are running.
3. Place the project folder in the `C:/laragon/www/` directory.

#### Using XAMPP

1. Download and install XAMPP from [apachefriends.org](https://www.apachefriends.org/download.html).
2. Start Apache and MySQL from the `XAMPP Control Panel`.
3. Place the project folder in the `C:/xampp/htdocs/`.

### 2. Create JSON File for Notes

Inside the project folder, create a file named `notes.json`. This file will be used to store note data in JSON format.

If `notes.json` does not exist, the application will automatically create it. You can create an empty file named `notes.json` or run the application without this file.

### 3. Running the Project

After setting up all files, you can run the project by opening a browser and visiting the following URL:

- For Laragon: `http://localhost/day-3-Form-Submission`
- For XAMPP: `http://localhost/day-3-Form-Submission`

## Directory Structure

```bash
.
├── add_note.php          # File PHP untuk menambahkan catatan baru
├── delete_note.php       # File PHP untuk menghapus catatan
├── index.php             # Halaman utama untuk menampilkan dan menambahkan catatan
├── notes.json            # File JSON untuk menyimpan data catatan
└── README.md             # Dokumentasi proyek ini
```
