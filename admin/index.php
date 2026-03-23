<?php
ini_set('session.use_only_cookies', 1);
session_name("AdminSession");
session_start();
$pageTitle = 'Admin Login';

if (isset($_SESSION['admin_userid'])) {
    header('Location: dashboard');
    exit();
}

?>

<?php include 'connect.php'; ?>
<?php include 'Includes/functions/functions.php'; ?>
<?php include 'Includes/templates/header.php'; ?>

<div class="login">
    <form class="login-container validate-form" name="login-form" action="index" method="POST"
          onsubmit="return validateLoginForm()">
        <span class="login100-form-title p-b-32">
            Admin Login
        </span>
        <?php
        // Check if user clicked on the submit button
        if (isset($_POST['admin_login'])) {
            $username = test_input($_POST['username']);
            $password = test_input($_POST['password']);
            $hashedPass = sha1($password);

            // Check if User Exists In the database
            $stmt = $con->prepare("SELECT user_id, username FROM users WHERE username = ? AND password = ? AND user_r = 'admin'");
            $stmt->execute(array($username, $hashedPass));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            // Check if count > 0 which means that the database contains a record about this username
            if ($count > 0) {
				$_SESSION = array();
                $_SESSION['admin_userid'] = $row['user_id'];  // Store only user ID
                $_SESSION['admin_id'] = $row['user_id'];
    			$_SESSION['username'] = $row['username'];
				session_regenerate_id(true); // Regenerate session ID
                $_SESSION['login_time'] = time();
				header("Location: dashboard", true, 303); // Use 303 redirect
                exit();
            } else {
                ?>
                <div class="alert alert-danger">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="messages">
                        <div>Username and/or password are incorrect!</div>
                    </div>
                </div>
                <?php
            }
        }
        ?>

        <div class="form-input">
            <span class="txt1">Username</span>
            <input type="text" name="username" class="form-control username"
                   oninput="document.getElementById('username_required').style.display = 'none'" id="user"
                   autocomplete="off">
            <div class="invalid-feedback" id="username_required">Username is required!</div>
        </div>

        <div class="form-input">
            <span class="txt1">Password</span>
            <input type="password" name="password" class="form-control"
                   oninput="document.getElementById('password_required').style.display = 'none'" id="password"
                   autocomplete="new-password">
            <div class="invalid-feedback" id="password_required">Password is required!</div>
        </div>

        <p>
            <button type="submit" name="admin_login">Sign In</button>
        </p>
    </form>
</div>

<?php include 'Includes/templates/footer.php'; ?>