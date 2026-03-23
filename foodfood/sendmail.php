<?php
// Modified sendmail.php to avoid executing the form handling code when included
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$options = [
    'fromEmail' => 'abhinavg2712@gmail.com',
    'fromName' => 'Swiga',
    'smtp' => [
        'host' => 'smtp.gmail.com',
        'username' => 'abhinavg2712@gmail.com',
        'password' => 'oyxl hwtm gjyy zrdu', //  Use a secure method to store this!
        'port' => 587,
        'encryption' => 'tls',
    ],
];

function sendEmail(string $recipientEmail, string $recipientName, string $subject, string $body, array $options = []): bool
{
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Validate required options
        if (empty($options['fromEmail']) || empty($options['fromName'])) {
            throw new InvalidArgumentException('Sender email and name are required.');
        }
        $fromEmail = $options['fromEmail'];
        $fromName = $options['fromName'];

        $isHTML = $options['isHTML'] ?? true;
        $attachments = $options['attachments'] ?? [];
        $cc = $options['cc'] ?? [];
        $bcc = $options['bcc'] ?? [];

        // Server settings
        if (!empty($options['smtp'])) {
            if (empty($options['smtp']['host']) || empty($options['smtp']['username']) || empty($options['smtp']['password'])) {
                throw new InvalidArgumentException('SMTP host, username, and password are required.');
            }
            $mail->isSMTP();
            $mail->Host = $options['smtp']['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $options['smtp']['username'];
            $mail->Password = $options['smtp']['password'];
            $mail->SMTPSecure = $options['smtp']['encryption'] ?? PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $options['smtp']['port'] ?? 587;
        }

        // Recipients
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($recipientEmail, $recipientName);

        // CC and BCC
        foreach ($cc as $email => $name) {
            $mail->addCC($email, $name ?? ''); //  Added null coalesce
        }
        foreach ($bcc as $email => $name) {
            $mail->addBCC($email, $name ?? ''); // Added null coalesce
        }

        // Attachments
        foreach ($attachments as $attachment) {
            if (is_array($attachment)) {
                $filePath = $attachment['path'];
                $fileName = $attachment['name'] ?? basename($filePath);
                $mail->addAttachment($filePath, $fileName);
            } else {
                $mail->addAttachment($attachment);
            }
        }

        // Content
        $mail->isHTML($isHTML);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log the error with more context
        error_log("Email sending failed in sendEmail(): {$e->getMessage()}");
        return false;
    }
}

// Only run this code if the file is accessed directly, not when included
if (basename($_SERVER['PHP_SELF']) == 'sendmail.php') {
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $toEmail = $_POST['toEmail'] ?? '';
        $toName = $_POST['toName'] ?? '';
        $emailSubject = $_POST['subject'] ?? '';
        $emailBody = $_POST['body'] ?? '';

        // Validate inputs
        if (empty($toEmail) || empty($emailSubject) || empty($emailBody)) {
            echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>
                    <strong class='font-bold'>Error!</strong>
                    <span class='block sm:inline'>Please fill in all required fields.</span>
                  </div>";
            exit;
        }

        // Prepare email options
        $emailOptions = [
            'fromEmail' => 'abhinavg2712@gmail.com',
            'fromName' => 'Swiga',
            'smtp' => [
                'host' => 'smtp.gmail.com',
                'username' => 'abhinavg2712@gmail.com',
                'password' => 'oyxl hwtm gjyy zrdu',
                'port' => 587,
                'encryption' => 'tls',
            ],
        ];

        // Send the email
        if (sendEmail($toEmail, $toName, $emailSubject, $emailBody, $emailOptions)) {
            echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4' role='alert'>
                    <strong class='font-bold'>Success!</strong>
                    <span class='block sm:inline'>Email sent successfully.</span>
                  </div>";
        } else {
            echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>
                    <strong class='font-bold'>Error!</strong>
                    <span class='block sm:inline'>Failed to send email. Please check the error logs.</span>
                  </div>";
        }
    }
}
?>