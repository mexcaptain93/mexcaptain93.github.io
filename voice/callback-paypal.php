<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/phpmailer/Exception.php';
require 'libs/phpmailer/PHPMailer.php';
require 'libs/phpmailer/SMTP.php';

// $payload = @file_get_contents('php://input');
// $event = null;

// try {
//     $event = \Stripe\Event::constructFrom(
//         json_decode($payload, true)
//     );
// } catch(\UnexpectedValueException $e) {
//     // Invalid payload
//     http_response_code(400);
//     exit();
// }

// Handle the event
// switch ($event->type) {
//     case 'payment_intent.succeeded':
//         echo 0;
//         // $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
//         // handlePaymentIntentSucceeded($paymentIntent);
//         // echo 9;
//         break;
//     default:
//         echo 'fail';
//         http_response_code(400);
//         exit();
// }


$email = $_POST['option_selection5'];

$project    =    'Voice Tag Manager';
$to         =    'prodbylazybonesbeats@gmail.com';
$subject    =    "[paid via paypal] NEW ORDER ($email)";
    
$message = '';

function addLine($key, $value) {
    global $c, $message;
    $message .= "
            " . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
                <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
                <td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
                </tr>
            ";
}

for ($i = 1; $i <= 5; $i++) {
    addLine($_POST["option_name$i"], $_POST["option_selection$i"]);
}
    
$message = "<table style='width: 100%;'>$message</table>";

function adopt($text) {
    return '=?UTF-8?B?'.Base64_encode($text).'?=';
}

$mail = new PHPMailer;
$mail->addAddress($to);
$mail->Subject = adopt($subject);
$mail->msgHTML($message);
$mail->setFrom('mail@voicetaglab.com', 'Voice Tag Manager');
$mail->addReplyTo('mail@voicetaglab.com', 'Voice Tag Manager');

$mail->IsSMTP(); 
$mail->SMTPDebug = 0; 
$mail->SMTPAuth = true; 
$mail->SMTPSecure = 'ssl'; 
$mail->Host = "smtp.timeweb.ru";

$mail->Port = 465; 
$mail->IsHTML(true);
$mail->Username = "mail@voicetaglab.com";
$mail->Password = "amarilnigga1";

//send the message, check for errors
$mail->send();

http_response_code(200);
