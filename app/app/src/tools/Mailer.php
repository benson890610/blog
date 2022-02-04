<?php 

namespace App\Tools;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {

	public function send_confirm_registration_activation(string $address, string $token) {
		$mail = new PHPMailer;

		$mail->setFrom($_ENV['MAIL_USERNAME'], $_ENV['MAIL_FROM_NAME']);
		$mail->addAddress($address);
		$mail->addReplyTo($_ENV['MAIL_USERNAME']);
		$mail->isHTML(true);
		$mail->Subject = "{$_ENV['MAIL_FROM_NAME']} confirm registration message";
		$mail->Body = "<h1>Registration confirmation message on site {$_ENV['MAIL_FROM_NAME']}</h1>
						  <div>
						  		<p>If you think this message is sent to your address by mistake please ignore it.</p>
						  		<br><br>
						  		Click on this <a href='". $_ENV['APP_SRC'] ."user/confirm/{$token}'>LINK</a> to confirm your registration.
						  </div>";

		$mail->send();
	}

	public function send_password_forgot_activation(string $address, string $token) {
		$mail = new PHPMailer;

		$mail->setFrom($_ENV['MAIL_USERNAME'], $_ENV['MAIL_FROM_NAME']);
		$mail->addAddress($address);
		$mail->addReplyTo($_ENV['MAIL_USERNAME']);
		$mail->isHTML(true);
		$mail->Subject = "{$_ENV['MAIL_FROM_NAME']} password change message";
		$mail->Body    = "<h1>Password change confirmation message on site {$_ENV['MAIL_FROM_NAME']}</h1>
						  <div>
						  		<p>If you think this message is sent to your address by mistake please ignore it.</p>
						  		<br><br>
						  		Click on this <a href='". $_ENV['APP_SRC'] ."user/passwordChange/{$token}'>LINK</a> to change your password.
						  </div>";

		$mail->send();
	}

}