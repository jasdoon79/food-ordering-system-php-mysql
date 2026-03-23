<?php
// Include required files
include_once './connect.php';
include_once './functions.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_only_cookies', 1);
    session_name("UserSession");
    session_start();
}

// Set response headers
header('Content-Type: application/json');

// Initialize response array
$response = array(
    'success' => false,
    'message' => 'No action specified'
);

// Get the action from POST data
$action = isset($_POST['action']) ? test_input($_POST['action']) : '';

// Handle different actions
switch ($action) {
    case 'login':
        handleLogin();
        break;
    case 'signup':
        handleSignup();
        break;
    case 'logout':
        handleLogout();
        break;
    case 'check_session':
        checkSession();
        break;
    default:
        // Invalid action
        $response['message'] = 'Invalid action';
        break;
}

// Output response as JSON
echo json_encode($response);
exit;

/**
 * Handle user login
 */
function handleLogin() {
    global $con, $response;
    
    // Get and sanitize input data
    $username = isset($_POST['username']) ? test_input($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : ''; // Don't sanitize password
    
    // Validate input
    if (empty($username) || empty($password)) {
        $response['message'] = 'Please enter both username and password';
        return;
    }
    
    try {
        // Check if user exists
        $stmt = $con->prepare("SELECT user_id, name, username, email, password_hash FROM webusers WHERE username = ?");
        $stmt->execute(array($username));
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verify password
            if (password_verify($password, $user['password_hash'])) {
                // Password is correct, create session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['logged_in'] = true;
                $_SESSION['login_time'] = time();
                
                // Update response
                $response['success'] = true;
                $response['redirect'] = 'index.php';
                $response['message'] = 'Login successful!';
                $response['user'] = array(
                    'name' => $user['name'],
                    'username' => $user['username']
                );
            } else {
                $response['message'] = 'Invalid password';
            }
        } else {
            $response['message'] = 'User not found';
        }
    } catch (PDOException $e) {
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
}

/**
 * Handle user registration
 */
function handleSignup() {
    global $con, $response;
    
    // Get and sanitize input data
    $name = isset($_POST['name']) ? test_input($_POST['name']) : '';
    $username = isset($_POST['username']) ? test_input($_POST['username']) : '';
    $email = isset($_POST['email']) ? test_input($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : ''; // Don't sanitize password
    
    // Validate input
    if (empty($name) || empty($username) || empty($email) || empty($password)) {
        $response['message'] = 'All fields are required';
        return;
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email format';
        return;
    }
    
    // Validate username format (alphanumeric, underscore, 3-20 chars)
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $response['message'] = 'Username must be 3-20 characters and contain only letters, numbers, and underscores';
        return;
    }
    
    // Validate password strength
    if (strlen($password) < 8 || !preg_match('/[a-zA-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $response['message'] = 'Password must be at least 8 characters and include both letters and numbers';
        return;
    }
    
    try {
        // Check if username already exists
        if (checkItem('username', 'webusers', $username) > 0) {
            $response['message'] = 'Username already exists';
            return;
        }
        
        // Check if email already exists
        if (checkItem('email', 'webusers', $email) > 0) {
            $response['message'] = 'Email already exists';
            return;
        }
        
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $con->prepare("INSERT INTO webusers (name, username, email, password_hash, created_at) 
                               VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute(array($name, $username, $email, $password_hash));
        
        if ($stmt->rowCount() > 0) {
            $response['success'] = true;
            $response['message'] = 'Registration successful! You can now login.';
        } else {
            $response['message'] = 'Failed to create account';
        }
    } catch (PDOException $e) {
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
}

/**
 * Handle user logout
 */
function handleLogout() {
    global $response;
    
    // Unset all session variables
    $_SESSION = array();
    
    // Delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
    
    $response['success'] = true;
    $response['message'] = 'Logout successful';
    $response['redirect'] = 'auth.php';
}

/**
 * Check if user is logged in
 */
function checkSession() {
    global $response;
    
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        $response['success'] = true;
        $response['message'] = 'User is logged in';
        $response['user'] = array(
            'user_id' => $_SESSION['user_id'],
            'name' => $_SESSION['name'],
            'username' => $_SESSION['username'],
            'email' => $_SESSION['email']
        );
    } else {
        $response['message'] = 'User is not logged in';
    }
}