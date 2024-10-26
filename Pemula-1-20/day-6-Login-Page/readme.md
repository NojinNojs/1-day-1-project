# Start Generation Here
# README for Login Page Project

## Overview
This project is a simple login page built using PHP and Bootstrap. It allows users to enter their credentials and checks them against predefined static values. If the credentials are correct, the user is redirected to a success page; otherwise, an error message is displayed.

## Project Structure
- `index.php`: The main login page where users can enter their username and password.
- `login.php`: The backend script that processes the login form submission.
- `success.php`: A page displayed upon successful login.

## Technologies Used
- **PHP**: Server-side scripting language used for processing the login logic.
- **HTML/CSS**: Markup and styling languages used to create the structure and design of the web pages.
- **Bootstrap**: A front-end framework for developing responsive and mobile-first websites.

## How It Works
1. **User Input**: The user enters their username and password in the `index.php` form.
2. **Form Submission**: Upon submission, the form sends a POST request to `login.php`.
3. **Validation**: In `login.php`, the submitted credentials are compared against predefined valid credentials.
   - If the credentials match, the user is redirected to `success.php`.
   - If they do not match, the user is redirected back to `index.php` with an error message.
4. **Success Page**: The `success.php` page displays a welcome message upon successful login.

## Usage
1. Clone the repository or download the files.
2. Set up a local server environment (e.g., XAMPP, WAMP).
3. Place the project files in the server's root directory.
4. Access the `index.php` file through your web browser to test the login functionality.

## Conclusion
This project serves as a basic example of how to implement a login system using PHP. It can be expanded with features such as database integration for dynamic user management, password hashing for security, and more.

Feel free to modify and enhance the project as per your requirements!

# Author
Created by [Nojin](https://nojin.site/)