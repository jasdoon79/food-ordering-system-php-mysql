<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('session.use_only_cookies', 1);
session_name("VendorSession");
session_start();
$pageTitle = 'Vendor Registration';

if(isset($_SESSION['vendor_userid']))
{
    header('Location: dashboard');
    exit(); // Added exit after redirect
}

// PHP INCLUDES
include 'connect.php';
include 'Includes/functions/functions.php';
include 'Includes/templates/header.php';
?>

<div class="login">
    <form class="login-container validate-form" name="register-form" action="register" method="POST"
          onsubmit="return validateRegisterForm()">
        <span class="login100-form-title p-b-32">
            Vendor Registration
        </span>
        <?php
        // Check if user clicked on the submit button
        if (isset($_POST['vendor_register'])) {
            $username = test_input($_POST['username']);
            $email = test_input($_POST['email']);
            $full_name = test_input($_POST['full_name']);  
            $password = $_POST['password'];  
            $hashedPass = sha1($password);
            $rest = 'rest';

            // Check if username already exists
            $stmt = $con->prepare("SELECT username FROM users WHERE username = ?");
            $stmt->execute(array($username));
            $count = $stmt->rowCount();

            // Check if email already exists
            $stmt_email = $con->prepare("SELECT email FROM users WHERE email = ?");
            $stmt_email->execute(array($email));
            $count_email = $stmt_email->rowCount();

            // Form validation
            $formErrors = array();

            if ($count > 0) {
                $formErrors[] = "Username already exists!";
            }

            if ($count_email > 0) {
                $formErrors[] = "Email already exists!";
            }

            if (empty($username)) {
                $formErrors[] = "Username can't be empty!";
            }

            if (empty($email)) {
                $formErrors[] = "Email can't be empty!";
            }

            if (empty($full_name)) {
                $formErrors[] = "Full name can't be empty!";
            }

            if (empty($password)) {
                $formErrors[] = "Password can't be empty!";
            }

            // If no errors, proceed with registration
            if (empty($formErrors)) {
                try {
                    // Insert new user into database
                    // Check which fields exist in the users table
                    $table_info = $con->query("DESCRIBE users");
                    $columns = array();
                    while ($row = $table_info->fetch(PDO::FETCH_ASSOC)) {
                        $columns[] = $row['Field'];
                    }

                    $insert_fields = array('username', 'password', 'user_r');
                    $insert_values = array('?', '?', '?');
                    $insert_params = array($username, $hashedPass, $rest);

                    if (in_array('email', $columns)) {
                        $insert_fields[] = 'email';
                        $insert_values[] = '?';
                        $insert_params[] = $email;
                    }
                    if (in_array('full_name', $columns)) {
                        $insert_fields[] = 'full_name';
                        $insert_values[] = '?';
                        $insert_params[] = $full_name;
                    }

                    $sql = "INSERT INTO users (" . implode(',', $insert_fields) . ") VALUES (" . implode(',', $insert_values) . ")";
                    $stmt = $con->prepare($sql);
                    
                    // Remove debugging output which was blocking redirects
                    // echo "SQL: " . $sql . "<br>";
                    // echo "Params: " . print_r($insert_params, true) . "<br>";
                    
                    $stmt->execute($insert_params);
                    
                    // Get the user ID of the newly registered user
                    $userId = $con->lastInsertId();
                    
                    // Set session for the newly registered user
                    $_SESSION['vendor_userid'] = $userId;
                    $_SESSION['vendor_username'] = $username;
                    
                    // Redirect to restaurant_form.php
                    header('Location: restaurant_form');
                    exit(); // Added exit after redirect
                } catch (PDOException $e) {
                    // Log the error!  Crucial for debugging
                    error_log("Registration error: " . $e->getMessage(), 0);
                    echo "<div class='alert alert-danger'>Registration failed: " . $e->getMessage() . "</div>";
                }
            } else {
                // Display errors
                foreach ($formErrors as $error) {
                    ?>
                    <div class="alert alert-danger">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                        <div class="messages">
                            <div><?php echo $error; ?></div>
                        </div>
                    </div>
                    <?php
                }
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
            <span class="txt1">Email</span>
            <input type="email" name="email" class="form-control"
                   oninput="document.getElementById('email_required').style.display = 'none'" id="email"
                   autocomplete="off">
            <div class="invalid-feedback" id="email_required">Valid email is required!</div>
        </div>

        <div class="form-input">
            <span class="txt1">Full Name</span>
            <input type="text" name="full_name" class="form-control"  
                   oninput="document.getElementById('fullname_required').style.display = 'none'" id="fullname"
                   autocomplete="off">
            <div class="invalid-feedback" id="fullname_required">Full name is required!</div>
        </div>

        <div class="form-input">
            <span class="txt1">Password</span>
            <input type="password" name="password" class="form-control"
                   oninput="document.getElementById('password_required').style.display = 'none'" id="password"
                   autocomplete="new-password">
            <div class="invalid-feedback" id="password_required">Password is required!</div>
        </div>

        <p>
            <button type="submit" name="vendor_register">Register</button>
        </p>

        <p class="text-center">
            Already have an account? <a href="index">Login here</a>
        </p>

    </form>
</div>

<script>
    function validateRegisterForm() {
        var username = document.getElementById("user").value;
        var email = document.getElementById("email").value;
        var fullname = document.getElementById("fullname").value;
        var password = document.getElementById("password").value;
        var valid = true;

        if (username == "") {
            document.getElementById("username_required").style.display = "block";
            valid = false;
        }

        if (email == "") {
            document.getElementById("email_required").style.display = "block";
            valid = false;
        }

        if (fullname == "") {
            document.getElementById("fullname_required").style.display = "block";
            valid = false;
        }

        if (password == "") {
            document.getElementById("password_required").style.display = "block";
            valid = false;
        }

        return valid;
    }
</script>

<?php include 'Includes/templates/footer.php'; ?>