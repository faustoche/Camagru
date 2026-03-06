<?php

require_once __DIR__ . '/../models/User.php';

class PasswordController {
	
	public function processNewPassword() {
		$email = trim($_POST['email']);

		$user = new Users();

		if ($user->findUserByEmail($email)) {
			$randomToken = bin2hex(random_bytes('15'));

			$expirationTime = date("Y-m-d H:i:s", strtotime("+1 hour"));

			$user->saveResetToken($email, $randomToken, $expirationTime);
			$appUrl = $_SERVER['HTTP_HOST'];

			$confirmationPath = "http://" . $appUrl . "/reset?token=" . $randomToken;
			$emailSubject = "Forgot your password?";
			$emailMessage = "Click on the link to change your password: " . $confirmationPath;

			mail($email, $emailSubject, $emailMessage);

			header('Location: /login');
			exit();
		}
	}
}