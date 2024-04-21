
<?php
use PHPMailer\PHPMailer\PHPMailer;
// include_once(__DIR__."/../../library/phpmailer/PHPMailerAutoload.php");


include_once __DIR__ . '/../../library/phpmailer/src/Exception.php';
include_once __DIR__ . '/../../library/phpmailer/src/PHPMailer.php';
include_once __DIR__ . '/../../library/phpmailer/src/SMTP.php';

class Notification
{


    public function sendEmails($email_data)
    {

        if (!isset($email_data['to'], $email_data['from'], $email_data['subject'], $email_data['message'])) {
            return json_encode(["response_code" => 432, "response_message" => "Missing required data for sending email notification"]);
        }

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com;';
        $mail->SMTPAuth = true;
        $mail->Username = 'davidakanang@gmail.com';
        $mail->Password = 'kshz xpgs tmqi iulp';
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;
        // $image = $email_data['logo'];
        // $imageName = 'Logo';
        // $mail->addAttachment($image);
        // $mail->addEmbeddedImage($image, 'image1', $imageName);
        $mail->setFrom($email_data['from']);
        $mail->addAddress($email_data['to']);
        // $mail->addAddress('receiver2@gfg.com', 'Name');
        $mail->isHTML(true);
        $mail->Subject = $email_data['subject'];
        $mail->Body = $email_data['message'];
        // $mail->AltBody = 'Body in plain text for non-HTML mail clients';
        if ($mail->send()) {
            return json_encode(array("response_code" => 0, "response_message" => "mail sent successfully"));
        } else {
            return json_encode(array("response_code" => 20, 'response_message' => "Activation link  could not be sent."));
        }
    }
    public function sendEmail($email_data)
    {
        // Check if all required data is provided
        if (!isset($email_data['to'], $email_data['from'], $email_data['subject'], $email_data['message'])) {
            return "Missing required data for sending email notification.";
        }

        // Gmail SMTP settings
        $smtp_host = 'smtp.gmail.com';
        $smtp_port = 587; // TLS port
        $smtp_username = 'your_email@gmail.com'; // Your Gmail email address
        $smtp_password = 'your_gmail_password'; // Your Gmail password or app-specific password

        // Set up email headers
        $headers = "From: " . $email_data['from'] . "\r\n";
        $headers .= "Reply-To: " . $email_data['from'] . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Compose the email message
        $message = "<html><body>";
        $message .= "<h1>" . $email_data['subject'] . "</h1>";
        $message .= "<p>" . $email_data['message'] . "</p>";
        $message .= "</body></html>";

        // Set additional SMTP configuration options
        $smtp_options = '-f ' . $smtp_username;

        // Send the email using Gmail SMTP
        if (mail($email_data['to'], $email_data['subject'], $message, $headers, $smtp_options)) {
            return json_encode(['response_code' => '0', 'response_message' => 'Email Notification sent successfully']);
        } else {
            return json_encode(['response_code' => '419', 'response_message' => 'Failed to send email notification.']);
        }
    }

    // Method to send notifications through different channels
    public function channel($email_data)
    {
        // var_dump($email_data['channel']);exit;
        // Check if the notification data includes a specified channel
        if (!isset($email_data['channel'])) {
            // return "Channel not specified for notification.";
            return json_encode(['response_code' => '412', 'response_message' => 'Channel not specified for notification.']);
        }

        // Dispatch the notification based on the specified channel
        switch ($email_data['channel']) {
            case 'mail':
                return $this->sendEmails($email_data);
                // Add cases for other notification channels (e.g., SMS, push notifications) as needed
                // case 'sms':
                //     return $this->sendSMS($data);
                // case 'push':
                //     return $this->sendPushNotification($data);
            default:
                return json_encode(['response_code' => '413', 'response_message' => 'Unsupported notification channel' . $email_data['channel']]);
        }
    }
}
