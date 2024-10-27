# Simple Contact Form

Welcome to the Simple Contact Form project! This project allows users to easily get in touch by filling out a contact form. Below are the details of the implementation and features.

## Features

- **User Input**: Users can enter their name, email address, and message.
- **Email Sending**: The form sends an email using PHP after validating the input.
- **JavaScript Validation**: Ensures that all fields are filled, the email format is correct, and provides clear feedback to users in case of errors.
- **Success Confirmation**: Users receive confirmation that their email has been successfully sent after submitting the form.

## Getting Started

1. **Install Dependencies**:
   Make sure you have Composer installed, then run:
   ```bash
   composer install
   ```

2. **Set Up Environment Variables**:
   Copy the `.env.example` file to `.env` and fill in your SMTP details.

3. **Run the Application**:
   You can run the application on a local server. Make sure to configure your server to handle PHP files.

## Usage

- Open `index.html` in your browser.
- Fill out the contact form and click "Send Message".
- Ensure all fields are filled correctly to avoid validation errors.

## Contributing

Feel free to submit issues or pull requests if you have suggestions or improvements!

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.