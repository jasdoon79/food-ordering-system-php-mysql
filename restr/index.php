<?php 
	ini_set('session.use_only_cookies', 1);
	session_name("VendorSession");
	session_start();
	$pageTitle = 'Vendor Login';

	if(isset($_SESSION['vendor_userid']))
	{
		header('Location: dashboard');
	}
?>

<!-- PHP INCLUDES -->

<?php include 'connect.php'; ?>
<?php include 'Includes/functions/functions.php'; ?>
<?php include 'Includes/templates/header.php'; ?>

	<!-- LOGIN FORM -->

	<div class="login">
		<form class="login-container validate-form" name="login-form" action="index" method="POST" onsubmit="return validateLoginForm()">
			<span class="login100-form-title p-b-32">
				Vendor Login
			</span>
			<?php
				//Check if user click on the submit button
				if(isset($_POST['vendor_login']))
				{
					$username = test_input($_POST['username']);
					$password = test_input($_POST['password']);
					$hashedPass = sha1($password);

					//Check if User Exist In database

					$stmt = $con->prepare("Select user_id, username, password, email from users where username = ? and password = ? and user_r = 'rest'");
					$stmt->execute(array($username,$hashedPass));
					$row = $stmt->fetch();
					$count = $stmt->rowCount();

					// Check if count > 0 which mean that the database contain a record about this username

					if($count > 0)
					{
						// Check if restaurant associated with this user is active
						$user_email = $row['email'];
						$checkRestaurantStatus = $con->prepare("SELECT status FROM restaurants WHERE email = ?");
						$checkRestaurantStatus->execute(array($user_email));
						$restaurant = $checkRestaurantStatus->fetch();
						
						if($checkRestaurantStatus->rowCount() > 0 && $restaurant['status'] == 'active') {
							$_SESSION['vendor_username'] = $username;
							$_SESSION['vendor_password'] = $password;
							$_SESSION['vendor_userid'] = $row['user_id'];
							header('Location: dashboard');
							die();
						} else {
							?>
								<div class="alert alert-warning">
									<button data-dismiss="alert" class="close close-sm" type="button">
										<span aria-hidden="true">×</span>
									</button>
									<div class="messages">
										<div>Your restaurant is not yet active!</div>
									</div>
								</div>
							<?php
						}
					}
					else
					{
						?>
							<div class="alert alert-danger">
								<button data-dismiss="alert" class="close close-sm" type="button">
									<span aria-hidden="true">×</span>
								</button>
								<div class="messages">
									<div>Username and/or password are incorrect!</div>
								</div>
							</div>
						<?php 
					}
				}
			?>

			<!-- USERNAME INPUT -->

			<div class="form-input">
				<span class="txt1">Username</span>
				<input type="text" name="username" class = "form-control username" oninput="document.getElementById('username_required').style.display = 'none'" id="user" autocomplete="off">
				<div class="invalid-feedback" id="username_required">Username is required!</div>
			</div>

			<!-- PASSWORD INPUT -->
			
			<div class="form-input">
				<span class="txt1">Password</span>
				<input type="password" name="password" class="form-control" oninput="document.getElementById('password_required').style.display = 'none'" id="password" autocomplete="new-password">
				<div class="invalid-feedback" id="password_required">Password is required!</div>
			</div>

			<!-- SIGNIN BUTTON -->
			
			<p>
				<button type="submit" name="vendor_login" >Sign In</button>
			</p>
			<p class="text-center">
				New User? <a href="register">Register here</a>
			</p>

		</form>
	</div>

<?php include 'Includes/templates/footer.php'; ?>