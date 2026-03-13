<?php

require_once __DIR__ . "/../models/User.php";

class ProfileController {
	
	public function showProfile() {
		Auth::requireLogin();
		$user = new Users();

		$user_id = $_SESSION['user_id'];

		$request = "SELECT username, email, email_notifications
					FROM users 
					WHERE id = :user_id";
		
		$statement = $user->getConnection()->prepare($request);
		$statement->execute([':user_id' => $user_id]);
		$fetchData = $statement->fetch(PDO::FETCH_ASSOC);



		ob_start();
		require_once __DIR__ . '/../views/profile.php';
		$content = ob_get_clean();
		require_once __DIR__ . '/../views/layout.php';

	}

	public function updateProfile() {
		Auth::requireLogin();
		$user = new Users();

        $user_id = $_SESSION['user_id'];

        if (isset($_POST['username'])) {
            $username = checkInput($_POST['username']);
            $email = checkInput($_POST['email']);
            $email_notifications = isset($_POST['notification']) ? 1 : 0;

            $request = "UPDATE users SET username = :username, email = :email, email_notifications = :email_notifications WHERE id = :user_id";
            $statement = $user->getConnection()->prepare($request);
            $statement->execute([
                ':username' => $username,
                ':email' => $email,
                ':email_notifications' => $email_notifications,
                ':user_id' => $user_id
            ]);
        }
        
        elseif (isset($_POST['password']) && !empty($_POST['password'])) {
            $passwordHashed = password_hash($_POST['password'], PASSWORD_ARGON2ID);
            
            $request = "UPDATE users SET password = :password WHERE id = :user_id";
            $statement = $user->getConnection()->prepare($request);
            $statement->execute([
                ':password' => $passwordHashed,
                ':user_id' => $user_id
            ]);
        }

        header('Location: /profile');
        exit();
	}
}

## htmlspecialchar pour éviter les injections XSS
function checkInput(string $data) {
	$data = trim($data);
	$data = htmlspecialchars($data);
	return $data;
}
