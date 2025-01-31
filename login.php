<?php
// session_start();
$title = 'Login';
if (isset($_SESSION['user'])) {
	header("location: index.php"); // Redirect To Home Page
}
include "init.php";
// Check If Request Method Coming From Form Is Post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (isset($_POST['login'])) {

		$user = $_POST['username'];
		$password = $_POST['password'];
		$hashedpass = sha1($password);

		// Check If The User Is Exists In Database Or Not
		$stmt = $conn->prepare("SELECT id, username, password  FROM users WHERE username = ? AND password = ?");

		$stmt->execute(array($user, $hashedpass));

		$data = $stmt->fetch();


		$count = $stmt->rowCount();


		// If $count > 0 This Mean That User Has Account In Database

		if ($count > 0) {

			$_SESSION['user'] = $user;  // Create Session For User

			$_SESSION['u_id'] = $data['id'];

			header("location: index.php"); // Redirect To Home Page
			exit();
		}
	} else {

		$username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$email = $_POST['email'];


		$formErrors[] = '';
		if (isset($username)) {

			$filter_name = filter_var($username, FILTER_SANITIZE_STRING);

			if (strlen($filter_name) < 4) {

				$formErrors[] = 'Username Must Be More Than 4 Characters';
			}
		}

		if (isset($password) && isset($password2)) {

			if (empty($password)) {

				$formErrors[] = 'Sorry Password Is Empty';
			}

			$hash_password = sha1($password);
			$hash_password2 = sha1($password2);

			if ($hash_password !== $hash_password2) {

				$formErrors[] = 'Sorry Passowrd Not Match';
			}
		}

		if (isset($email) && !empty($email)) {

			$filter_email = filter_var($email, FILTER_SANITIZE_EMAIL);

			if (filter_var($filter_email, FILTER_VALIDATE_EMAIL) != true) {

				$formErrors[] = 'Your Email Not Valid';
			}
		} else {

			$formErrors[] = 'Your Email Is Empty';
		}

		// Inserting The Data In DataBase Using This Information

		if (empty($fromErrors)) {

			// Check Existing User Function

			$check =  Check_data("username", "users", $username);

			//  If User Equal 1 => This Meaning The User Is Exist
			if ($check == 1) {

				$formErrors[] =  'Sorry, This User Is Exist ';
			} else {


				$stmt = $conn->prepare("INSERT INTO `users`( `username`, `password`, `email`, `regstatus`, `Date`) VALUES (?, ?, ?, ?, NOw())");
				$stmt->execute(array($username, $hash_password, $email, 0));

				// Print A Successful Inserted Message

				$success_msg = "Congratulation You Are Now Registered User";
			}
		}
	}
}

?>

<div class="container login-page">
	<h1 class="text-center">
		<span class="selected" data-class="login">Login</span> |
		<span data-class="signup">Signup</span>
	</h1>
	<!-- Start Login Form -->
	<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<div class="input-container">
			<input
				class="form-control"
				type="text"
				name="username"
				autocomplete="off"
				placeholder="Type your username"
				required />
		</div>
		<div class="input-container">
			<input
				class="form-control"
				type="password"
				name="password"
				autocomplete="new-password"
				placeholder="Type your password"
				required />
		</div>
		<input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
	</form>
	<!-- End Login Form -->
	<!-- Start Signup Form -->
	<form class="signup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<div class="input-container">
			<input
				pattern=".{4,}"
				title="Username Must Be Between 4 Chars"
				class="form-control"
				type="text"
				name="username"
				autocomplete="off"
				placeholder="Type your username"
				required />
		</div>
		<div class="input-container">
			<input
				minlength="4"
				class="form-control"
				type="password"
				name="password"
				autocomplete="new-password"
				placeholder="Type a Complex password"
				required />
		</div>
		<div class="input-container">
			<input
				minlength="4"
				class="form-control"
				type="password"
				name="password2"
				autocomplete="new-password"
				placeholder="Type a password again"
				required />
		</div>
		<div class="input-container">
			<input
				class="form-control"
				type="email"
				name="email"
				placeholder="Type a Valid email" />
		</div>
		<input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" />
	</form>
	<!-- End Signup Form -->
	<div class="the-errors text-center">
		<?php

		if (!empty($formErrors)) {

			foreach ($formErrors as $error) {

				echo '<div class="msg error">' . $error . '</div>';
			}
		}

		if (isset($success_msg)) {

			echo '<div class="msg success">' . $success_msg . '</div>';
		}




		?>
	</div>
</div>


<?php include $temp . 'footer.php';  ?>