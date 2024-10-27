<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$log_output = ""; // Variabel untuk menyimpan log

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    if (empty($name) || empty($email) || empty($message)) {
        $log_output .= "<div class='alert alert-danger' role='alert'>Please fill in all fields.</div>";
        echo $log_output;
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $log_output .= "<div class='alert alert-danger' role='alert'>Invalid email format.</div>";
        echo $log_output;
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
        $mail->Port = $_ENV['SMTP_PORT'];
        
        // Debugging settings
        $mail->SMTPDebug = $_ENV['SMTP_DEBUG_LEVEL']; // Mengatur level debugging dari .env
        $mail->Debugoutput = function($str, $level) use (&$log_output) {
            $log_output .= "<div class='alert alert-info' role='alert'>".gmdate("Y-m-d H:i:s")." [$level] $str</div>";
        };
        
        // Timeout settings
        $mail->Timeout = $_ENV['SMTP_TIMEOUT']; // Mengatur timeout dari .env

        // Email settings
        $mail->setFrom($_ENV['SMTP_USERNAME'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($_ENV['MAIL_TO_ADDRESS']); // Ganti dengan email tujuan dari .env
        $mail->isHTML(true);
        $mail->Subject = $_ENV['MAIL_SUBJECT'];
        $mail->Body = "<div style='font-family: Arial, sans-serif; color: #333;'>
                           <h2 style='color: #007bff;'>New Message from Contact Form</h2>
                           <p><strong>Name:</strong> $name</p>
                           <p><strong>Email:</strong> $email</p>
                           <p><strong>Message:</strong><br>$message</p>
                           <hr>
                           <footer style='margin-top: 20px; padding-top: 10px; border-top: 1px solid #ddd;'>
                               <p style='color: #555;'>This email was sent from the contact form on your website.</p>
                               <p style='color: #555;'>Visit us: <a href='https://1-day-1-project.nojinjourney.com/' style='color: #007bff;'>1-Day-1-Project</a></p>
                           </footer>
                       </div>";

        $mail->send();
        $log_output .= "<div class='alert alert-success' role='alert'>Email successfully sent. Thank you for contacting us!</div>";
    } catch (Exception $e) {
        $log_output .= "<div class='alert alert-danger' role='alert'>Failed to send email. Mailer Error: {$mail->ErrorInfo}</div>";
    }

    // Tampilkan log di frontend
    echo $log_output;
}
