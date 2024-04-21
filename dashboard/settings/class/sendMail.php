<?php

// include_once(__DIR__."/../../library/phpmailer/PHPMailerAutoload.php");


include_once __DIR__ . '/../../library/phpmailer/src/Exception.php';
include_once __DIR__ . '/../../library/phpmailer/src/PHPMailer.php';
include_once __DIR__ . '/../../library/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendMail extends PHPMailer
{
    public $ip;
    public function __construct()
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function Mail_endpoint($data)
    {

        // $this->IsSMTP(); // telling the class to use SMTP  
		// $this->Mailer = "smtp";
        // $this->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
        // $this->SMTPAuth = true;                  // enable SMTP authentication
        // $this->SMTPSecure = "ssl";                 // sets the prefix to the servier
        // // $this->Host = "messaging.com.au";      // sets GMAIL as the SMTP server
        // $this->Host = "smtp.gmail.com";      // sets GMAIL as the SMTP server
        // $this->Port = 587;                   // set the SMTP port for the GMAIL server
        // $this->Port = 465;                   // set the SMTP port for the GMAIL server

        $this->IsSMTP(); // telling the class to use SMTP
        $this->Mailer = "smtp";
        $this->SMTPDebug = 0; // enables SMTP debug information (for testing)
        $this->SMTPAuth = true; // enable SMTP authentication
        $this->SMTPSecure = "tls"; // sets the prefix to the server
        $this->Host = "smtp.gmail.com"; // sets Gmail as the SMTP server
        $this->Port = 587; // set the SMTP port for Gmail server
        
        $ip = $_SERVER['REMOTE_ADDR'];

        if ($ip == '::1' || $ip == 'localhost') {
        } else {
            // $this->Username = $data['from'];
            // $this->Password = '2Onh)Px2-T8n';

            $this->Username = 'messagingpty@gmail.com';
            $this->Password = '#KemAdmin7453';
            
            // $this->Username = 'hughi.obeni@gmail.com';
            // $this->Password = 'khwy airw klcf pxev';
            
        }
       
        $this->setFrom($data['from'], $data['sender_name']);
        // Add a recipient
        $this->addAddress($data['to']);
        
        if(isset($data['copy']) && $data['copy'] == true){
            $this->addCC('notifications@messaging.com.au', $data['sender_name']); // CC recipient
        }

        // Email subject
        $this->Subject = $data['subject'];

        isset($data['extra'])?$this->addStringAttachment($data['attachment'],$data['filename']):'';

        // Set email format to HTML
        $this->isHTML(true);

        // Email body content

        $email_template_string = file_get_contents($data['template'], true);

        $content = array(
            'logo' =>$data['logo'],
            'subject' => $data['subject'],
            'message' => $data['message'],
            'full_name' => $data['full_name'],
            'type' => $data['type'],
            'salute' => $data['salute'],
            'subtitle' => $data['subtitle'],
            'beneficiary' => $data['beneficiary'],
            'amount' => $data['amount'],
            'reference' => $data['reference'],
            'date' => $data['date'],
            'title' => $data['title'],
            'label' => $data['label'],
            'beneficiary_account' => $data['beneficiary_account'],
            'beneficiary_bank' => $data['beneficiary_bank'],
            'destination_amount' => $data['destination_amount'],
            'pdflink' => $data['pdflink'],
            'messaging' => $data['messaging'],
            'purpose' => $data['purpose'],
            'method' => $data['method'],
            'status' => $data['status'],
            'color' => $data['color']
        );

		$email_template = str_replace(
			array('{{logo}}', '{{subject}}', '{{message}}','{{full_name}}','{{type}}','{{salute}}','{{subtitle}}','{{beneficiary}}','{{amount}}','{{reference}}','{{date}}','{{title}}','{{label}}','{{beneficiary_account}}','{{beneficiary_bank}}','{{destination_amount}}','{{pdflink}}','{{messaging}}','{{purpose}}','{{method}}','{{status}}','{{color}}'),
			$content,
			$email_template_string
		);


        $this->Body = $email_template;
        $this->AltBody = isset($data['alt_message'])?$data['alt_message']:'This is the body in plain text for non-HTML mail clients';

        $send = $this->send();

        if ($send) :
            return json_encode(array('response_code' => 0,'response_message'=>'Sent'));
        else :
            return json_encode(array('response_code' => 20, 'response_message' => $this->ErrorInfo));
        endif;
    }

    public function Mailer($data)
    {
        if(isset($data['route']) && $data['route'] == 2){
            return $this->Mail_default($data);
        }else{
            return $this->Mail_endpoint($data);
        }
        
    }

    public function Send_mail($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://console.messaging.com.au/api/mail',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $stmt =  json_decode($response, true);
        if ($stmt['response_code'] === 0) {
            return json_encode(array('response_code' => 0));
        }else{
            return json_encode(array('response_code' => 20, 'response_message' => $stmt['response_message']));
        }
    }

    private function Mail_default($data)
    {
        
        $to      = "<{$data['to']}>";
        $subject = $data['subject'];

        $bcc_mail = "<{$data['bcc_email']}>";
        $bcc_subject = $data['bcc_subject'];
      
        // Set content-type header for sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $headers .= "From: {$data['sender_name']} <{$data['from']}>". "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion(). "\r\n";

        // $email_template_string = file_get_contents($data['template'], true);

        // Urgent message
        $headers .= "X-Priority: 1\r\n";

        $email_template_string = file_get_contents($data['template'], true);

        
        if(!isset($data['copy']) || $data['copy'] == false){
            $headers .= "BCC: $bcc_mail";
        }else{

            // Set content-type header for sending HTML email
            $bcc_headers = "MIME-Version: 1.0" . "\r\n";
            $bcc_headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            $bcc_headers .= "From: {$data['sender_name']} <{$data['from']}>". "\r\n";
            $bcc_headers .= 'X-Mailer: PHP/' . phpversion(). "\r\n";

            // Urgent message
            $bcc_headers .= "X-Priority: 1\r\n";

            $content = array(
                'logo' =>$data['logo'],
                'subject' => $data['subject'],
                'message' => $data['message'],
                'full_name' => $data['full_name'],
                'type' => $data['type'],
                'salute' => $data['salute'],
                'subtitle' => $data['subtitle'],
                'beneficiary' => $data['beneficiary'],
                'amount' => $data['amount'],
                'reference' => $data['reference'],
                'date' => $data['date'],
                'title' => $data['title'],
                'label' => $data['label'],
                'beneficiary_account' => $data['beneficiary_account'],
                'beneficiary_bank' => $data['beneficiary_bank'],
                'destination_amount' => $data['destination_amount'],
                'pdflink' => $data['pdflink'],
                'messaging' => $data['messaging'],
                'purpose' => $data['purpose'],
                'method' => $data['method'],
                'status' => $data['status'],
                'color' => $data['color']
            );
    
            $bcc_email_template = str_replace(
                array('{{logo}}', '{{subject}}', '{{message}}','{{full_name}}','{{type}}','{{salute}}','{{subtitle}}','{{beneficiary}}','{{amount}}','{{reference}}','{{date}}','{{title}}','{{label}}','{{beneficiary_account}}','{{beneficiary_bank}}','{{destination_amount}}','{{pdflink}}','{{messaging}}','{{purpose}}','{{method}}','{{status}}','{{color}}'),
                $content,
                $email_template_string
            );

            $is_sent = mail($bcc_mail,$bcc_subject,$bcc_email_template,$bcc_headers);
        }

        $content = array(
            'logo' =>$data['logo'],
            'subject' => $data['subject'],
            'message' => $data['message'],
            'full_name' => $data['full_name'],
            'type' => $data['type'],
            'salute' => $data['salute'],
            'subtitle' => $data['subtitle'],
            'beneficiary' => $data['beneficiary'],
            'amount' => $data['amount'],
            'reference' => $data['reference'],
            'date' => $data['date'],
            'title' => $data['title'],
            'label' => $data['label'],
            'beneficiary_account' => $data['beneficiary_account'],
            'beneficiary_bank' => $data['beneficiary_bank'],
            'destination_amount' => $data['destination_amount'],
            'pdflink' => $data['pdflink'],
            'messaging' => $data['messaging'],
            'purpose' => $data['purpose'],
            'method' => $data['method'],
            'status' => $data['status'],
            'color' => $data['color']
        );

		$email_template = str_replace(
			array('{{logo}}', '{{subject}}', '{{message}}','{{full_name}}','{{type}}','{{salute}}','{{subtitle}}','{{beneficiary}}','{{amount}}','{{reference}}','{{date}}','{{title}}','{{label}}','{{beneficiary_account}}','{{beneficiary_bank}}','{{destination_amount}}','{{pdflink}}','{{messaging}}','{{purpose}}','{{method}}','{{status}}','{{color}}'),
			$content,
			$email_template_string
		);


        $to = trim($to);
        $is_sent = mail($to,$subject,$email_template,$headers);

        if ($is_sent) {
            return json_encode(array('response_code' => 0,'response_message'=>'Sent'));
        }else {
            $is_sent  = mail($to,$subject,$email_template,$headers);
            (isset($data['copy']) && $data['copy'] == true) ? mail($bcc_mail,$bcc_subject,$bcc_email_template,$bcc_headers):'';

            return json_encode(array('response_code' => 20, 'response_message' => 'Something went wrong'));
        }

    }

    public function Send_grid($data) 
    {

        $url = "https://api.sendgrid.com/v3/mail/send";
        $api_key = "<<YOUR_API_KEY_HERE>>";

        $data = array(
            'personalizations' => array(
                array(
                    'to' => array(
                        array('email' => 'john_doe@example.com', 'name' => 'John Doe')
                    ),
                    'cc' => array(
                        array('email' => 'jane_doe@example.com', 'name' => 'Jane Doe')
                    ),
                    'bcc' => array(
                        array('email' => 'james_doe@example.com', 'name' => 'Jim Doe')
                    )
                ),
                array(
                    'from' => array('email' => 'sales@example.com', 'name' => 'Example Sales Team'),
                    'to' => array(
                        array('email' => 'janice_doe@example.com', 'name' => 'Janice Doe')
                    ),
                    'bcc' => array(
                        array('email' => 'jordan_doe@example.com', 'name' => 'Jordan Doe')
                    )
                )
            ),
            'from' => array('email' => 'orders@example.com', 'name' => 'Example Order Confirmation'),
            'reply_to' => array('email' => 'customer_service@example.com', 'name' => 'Example Customer Service Team'),
            'subject' => 'Your Example Order Confirmation',
            'content' => array(
                array(
                    'type' => 'text/html',
                    'value' => '<p>Hello from Twilio SendGrid!</p><p>Sending with the email service trusted by developers and marketers for <strong>time-savings</strong>, <strong>scalability</strong>, and <strong>delivery expertise</strong>.</p><p>%open-track%</p>'
                )
            ),
            'attachments' => array(
                array(
                    'content' => 'PCFET0NUWVBFIGh0bWw+CjxodG1sIGxhbmc9ImVuIj4KCiAgICA8aGVhZD4KICAgICAgICA8bWV0YSBjaGFyc2V0PSJVVEYtOCI+CiAgICAgICAgPG1ldGEgaHR0cC1lcXVpdj0iWC1VQS1Db21wYXRpYmxlIiBjb250ZW50PSJJRT1lZGdlIj4KICAgICAgICA8bWV0YSBuYW1lPSJ2aWV3cG9ydCIgY29udGVudD0id2lkdGg9ZGV2aWNlLXdpZHRoLCBpbml0aWFsLXNjYWxlPTEuMCI+CiAgICAgICAgPHRpdGxlPkRvY3VtZW50PC90aXRsZT4KICAgIDwvaGVhZD4KCiAgICA8Ym9keT4KCiAgICA8L2JvZHk+Cgo8L2h0bWw+Cg==',
                    'filename' => 'index.html',
                    'type' => 'text/html',
                    'disposition' => 'attachment'
                )
            ),
            'categories' => array('cake', 'pie', 'baking'),
            'send_at' => 1617260400,
            'batch_id' => 'AsdFgHjklQweRTYuIopzXcVBNm0aSDfGHjklmZcVbNMqWert1znmOP2asDFjkl',
            'asm' => array(
                'group_id' => 12345,
                'groups_to_display' => array(12345)
            ),
            'ip_pool_name' => 'transactional email',
            'mail_settings' => array(
                'bypass_list_management' => array('enable' => false),
                'footer' => array('enable' => false),
                'sandbox_mode' => array('enable' => false)
            ),
            'tracking_settings' => array(
                'click_tracking' => array('enable' => true, 'enable_text' => false),
                'open_tracking' => array('enable' => true, 'substitution_tag' => '%open-track%'),
                'subscription_tracking' => array('enable' => false)
            )
        );

        $payload = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $api_key,
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

    }

    public function SMS($data)
    {

        $accountSid = 'ACca2a8d611a30c9bd7ac16d21c68557d5';
        $authToken = '7a9e95c16e08abffd6795e7cb2eb4540';
        
        $url = 'https://api.twilio.com/2010-04-01/Accounts/' . $accountSid . '/Messages.json';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'To' => $data['to'],
            'From' => $data['from'],
            'Body' => $data['message']
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $accountSid . ':' . $authToken);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;


    }

    public function Voice() 
    {
        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://api.twilio.com/2010-04-01/Accounts/ACca2a8d611a30c9bd7ac16d21c68557d5/Calls.json');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'Url' => 'http://demo.twilio.com/docs/voice.xml',
            'To' => '+2348031372994',
            'From' => '+12513091299'
        ]));
        curl_setopt($ch, CURLOPT_USERPWD, 'ACca2a8d611a30c9bd7ac16d21c68557d5:7a9e95c16e08abffd6795e7cb2eb4540');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for errors
        if($response === false) {
            echo 'cURL error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        // Display response
        return $response;
    }
}
