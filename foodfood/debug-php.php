<?php
// This file is a debugging helper for troubleshooting user authentication
// Create a test connection to check database connectivity

// First, display PHP info
echo "<h1>PHP Server Information</h1>";
echo "<h2>PHP Version: " . phpversion() . "</h2>";

// Test database connection
echo "<h1>Database Connection Test</h1>";

// Include connection file
require_once './functions/connect.php';

if (isset($con) && $con instanceof PDO) {
    echo "<p style='color: green;'>Database connection successful ✓</p>";
    
    // Check webusers table
    try {
        $stmt = $con->prepare("SHOW TABLES LIKE 'webusers'");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: green;'>webusers table exists ✓</p>";
            
            // Check table structure
            $stmt = $con->prepare("DESCRIBE webusers");
            $stmt->execute();
            $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            echo "<h2>Table Structure:</h2>";
            echo "<ul>";
            foreach ($columns as $column) {
                echo "<li>$column</li>";
            }
            echo "</ul>";
            
            // Count users
            $stmt = $con->prepare("SELECT COUNT(*) FROM webusers");
            $stmt->execute();
            $count = $stmt->fetchColumn();
            echo "<p>Total users: $count</p>";
            
        } else {
            echo "<p style='color: red;'>webusers table does not exist ✗</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Database error: " . $e->getMessage() . " ✗</p>";
    }
} else {
    echo "<p style='color: red;'>Database connection failed ✗</p>";
}

// Check session configuration
echo "<h1>Session Configuration</h1>";
echo "<ul>";
echo "<li>session.use_only_cookies: " . ini_get('session.use_only_cookies') . "</li>";
echo "<li>session.name: " . session_name() . "</li>";
echo "<li>session.save_path: " . session_save_path() . "</li>";
echo "</ul>";

// Test POST handling
echo "<h1>POST Request Test</h1>";
echo "<form method='post'>";
echo "<input type='hidden' name='action' value='test'>";
echo "<input type='text' name='test_value' placeholder='Enter test value'>";
echo "<button type='submit'>Submit Test</button>";
echo "</form>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>POST Data Received:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}

// Include and test functions
echo "<h1>Functions Test</h1>";
require_once './functions/functions.php';

// Test test_input function
echo "<h2>test_input Function</h2>";
$test_string = " <script>alert('test')</script> ";
$sanitized = test_input($test_string);
echo "Original: " . htmlspecialchars($test_string) . "<br>";
echo "Sanitized: " . htmlspecialchars($sanitized) . "<br>";

// Test checkItem function
echo "<h2>checkItem Function</h2>";
try {
    $username_check = checkItem('username', 'webusers', 'abhinav_27');
    echo "Username 'abhinav_27' exists: " . ($username_check > 0 ? 'Yes' : 'No') . "<br>";
} catch (Exception $e) {
    echo "Error checking username: " . $e->getMessage() . "<br>";
}

// Server info
echo "<h1>Server Information</h1>";
echo "<ul>";
echo "<li>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</li>";
echo "<li>Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "</li>";
echo "<li>Script Name: " . $_SERVER['SCRIPT_NAME'] . "</li>";
echo "<li>Request URI: " . $_SERVER['REQUEST_URI'] . "</li>";
echo "</ul>";

// File system check
echo "<h1>File System Check</h1>";
$files_to_check = array(
    'auth.php',
    './functions/user_handler.php',
    './functions/connect.php',
    './functions/functions.php',
    './Design/js/auth.js'
);

echo "<ul>";
foreach ($files_to_check as $file) {
    echo "<li>$file: " . (file_exists($file) ? "<span style='color: green;'>Exists ✓</span>" : "<span style='color: red;'>Missing ✗</span>") . "</li>";
}
echo "</ul>";

?>