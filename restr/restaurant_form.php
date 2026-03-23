<?php
ini_set('session.use_only_cookies', 1);
session_name("VendorSession");
session_start();
$pageTitle = 'Restaurant Details';

// Redirect if not logged in
if(!isset($_SESSION['vendor_userid'])) {
    header('Location: index');
    exit();
}

// PHP INCLUDES
include 'connect.php';
include 'Includes/functions/functions.php';
include 'Includes/templates/header.php';

// Get user information
$userId = $_SESSION['vendor_userid'];
$stmt = $con->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute(array($userId));
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="login">
    <form class="login-container validate-form" name="restaurant-form" action="restaurant_form" method="POST" 
          enctype="multipart/form-data" onsubmit="return validateRestaurantForm()">
        <span class="login100-form-title p-b-32">
            Restaurant Details
        </span>
        <?php
        // Check if user clicked on the submit button
        if (isset($_POST['restaurant_submit'])) {
            $name = test_input($_POST['name']);
            $type = test_input($_POST['type']);
            $rating = isset($_POST['rating']) ? floatval($_POST['rating']) : 0;
            $time = isset($_POST['time']) ? intval($_POST['time']) : 0;
            $forTwo = isset($_POST['forTwo']) ? intval($_POST['forTwo']) : 0;
            $offer = test_input($_POST['offer']);
            $email = $userInfo['email']; // Use email from session
            $owner = $userInfo['full_name']; // Use name from session
            
            // Handle image upload
            $imgPath = '';
            if(isset($_FILES['restaurant_image']) && $_FILES['restaurant_image']['error'] == 0) {
                $allowed = array('jpg' => 'image/jpg', 'jpeg' => 'image/jpeg', 'png' => 'image/png');
                $filename = $_FILES['restaurant_image']['name'];
                $filetype = $_FILES['restaurant_image']['type'];
                $filesize = $_FILES['restaurant_image']['size'];
            
                // Verify file extension
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!array_key_exists($ext, $allowed)) {
                    $formErrors[] = "Error: Please select a valid file format.";
                }
            
                // Verify file size - 5MB maximum
                $maxsize = 5 * 1024 * 1024;
                if($filesize > $maxsize) {
                    $formErrors[] = "Error: File size is larger than the allowed limit.";
                }
            
                // Verify MIME type of the file
                if(in_array($filetype, $allowed)) {
                    // Check whether file exists before uploading it
                    $target_dir = "../img/";
                    if(!is_dir($target_dir)) {
                        mkdir($target_dir, 0755, true);
                    }
                    $imgPath = "../img/" . $name . "." . $ext;
                    
                    if(move_uploaded_file($_FILES['restaurant_image']['tmp_name'], $imgPath)) {
                        // File uploaded successfully
                    } else {
                        $formErrors[] = "Error: There was a problem uploading your file.";
                        $imgPath = '';
                    }
                } else {
                    $formErrors[] = "Error: There was a problem with the file type. Please upload a valid image.";
                }
            } else {
                // Default image path if no image is uploaded
                $imgPath = "../img/popular.png";
            }

            // Form validation
            $formErrors = array();

            if (empty($name)) {
                $formErrors[] = "Restaurant name can't be empty!";
            }

            if (empty($type)) {
                $formErrors[] = "Restaurant type can't be empty!";
            }

            if ($rating < 0 || $rating > 5) {
                $formErrors[] = "Rating must be between 0 and 5!";
            }

            if ($time <= 0) {
                $formErrors[] = "Delivery time can't be empty or zero!";
            }

            if ($forTwo <= 0) {
                $formErrors[] = "Price for two can't be empty or zero!";
            }

            // If no errors, proceed with registration
            if (empty($formErrors)) {
                try {
                    // Insert restaurant details into database
                    // Updated INSERT query to include id with NULL value to use auto-increment
                    $stmt = $con->prepare("INSERT INTO restaurants (id, name, type, rating, time, forTwo, offer, img, owner, email, status) 
                                          VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    
                    // Set status as inactive by default - requires admin approval
                    $status = 'inactive';
                    
                    $stmt->execute(array(
                        $name, 
                        $type, 
                        $rating, 
                        $time, 
                        $forTwo, 
                        $offer, 
                        $imgPath, 
                        $owner, 
                        $email, 
                        $status
                    ));

                    // Send email notification - Fixed approach
                    require_once '../foodfood/sendmail.php'; // Only include the file, don't execute the form handling code
                    
                    $emailSubject = "Restaurant Registration in Progress";
                    $emailBody = "
                        <html>
                        <head>
                            <title>Restaurant Registration</title>
                        </head>
                        <body>
                            <h2>Thank you for registering your restaurant!</h2>
                            <p>Dear {$owner},</p>
                            <p>Your restaurant <strong>{$name}</strong> has been registered successfully and is pending approval.</p>
                            <p>We will review your information and update you once your restaurant is approved.</p>
                            <p>Restaurant Details:</p>
                            <ul>
                                <li>Name: {$name}</li>
                                <li>Type: {$type}</li>
                                <li>Delivery Time: {$time} minutes</li>
                                <li>Price for Two: ₹{$forTwo}</li>
                                <li>Special Offer: {$offer}</li>
                            </ul>
                            <p>Thank you for choosing our platform!</p>
                            <p>Best regards,<br>The Food Delivery Team</p>
                        </body>
                        </html>
                    ";
                    
                    // Call the sendEmail function directly with the proper parameters
                    if (sendEmail($email, $owner, $emailSubject, $emailBody, $options)) {
                        // Email sent successfully
                    }

                    // Success message
                    ?>
                    <div class="alert alert-success">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                            <span aria-hidden="true">×</span>
                        </button>
                        <div class="messages">
                            <div>Restaurant details submitted successfully! Your restaurant is pending approval. We've sent a confirmation email to your registered email address.</div>
                        </div>
                    </div>
                    <?php
                    
                    // Redirect to restaurant_details.php after successful submission
                    header("Location: restaurant_details");
                    exit();

                } catch (PDOException $e) {
                    // Log the error for debugging
                    error_log("Restaurant registration error: " . $e->getMessage(), 0);
                    echo "<div class='alert alert-danger'>Registration failed. Please try again. Error: " . $e->getMessage() . "</div>";
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
            <span class="txt1">Restaurant Name</span>
            <input type="text" name="name" class="form-control"
                   oninput="document.getElementById('name_required').style.display = 'none'" id="rest_name"
                   autocomplete="off">
            <div class="invalid-feedback" id="name_required">Restaurant name is required!</div>
        </div>

        <div class="form-input">
            <span class="txt1">Restaurant Type</span>
            <input type="text" name="type" class="form-control"
                   oninput="document.getElementById('type_required').style.display = 'none'" id="rest_type"
                   autocomplete="off" placeholder="e.g., Indian, Chinese, Italian (comma separated)">
            <div class="invalid-feedback" id="type_required">Restaurant type is required!</div>
        </div>

        <div class="form-input">
            <span class="txt1">Rating (0-5)</span>
            <input type="number" name="rating" class="form-control" min="0" max="5" step="0.1"
                   oninput="document.getElementById('rating_required').style.display = 'none'" id="rest_rating"
                   autocomplete="off" value="0">
            <div class="invalid-feedback" id="rating_required">Valid rating is required!</div>
        </div>

        <div class="form-input">
            <span class="txt1">Delivery Time (minutes)</span>
            <input type="number" name="time" class="form-control" min="1"
                   oninput="document.getElementById('time_required').style.display = 'none'" id="rest_time"
                   autocomplete="off">
            <div class="invalid-feedback" id="time_required">Delivery time is required!</div>
        </div>

        <div class="form-input">
            <span class="txt1">Price for Two (₹)</span>
            <input type="number" name="forTwo" class="form-control" min="1"
                   oninput="document.getElementById('forTwo_required').style.display = 'none'" id="rest_forTwo"
                   autocomplete="off">
            <div class="invalid-feedback" id="forTwo_required">Price for two is required!</div>
        </div>

        <div class="form-input">
            <span class="txt1">Special Offer</span>
            <input type="text" name="offer" class="form-control"
                   oninput="document.getElementById('offer_required').style.display = 'none'" id="rest_offer"
                   autocomplete="off" placeholder="e.g., FREE DELIVERY, 50% off on all orders">
            <div class="invalid-feedback" id="offer_required">Offer description is required!</div>
        </div>

        <div class="form-input">
            <span class="txt1">Restaurant Image</span>
            <input type="file" name="restaurant_image" class="form-control"
                   id="rest_image" accept="image/png, image/jpeg, image/jpg">
            <small>Max file size: 5MB. Supported formats: JPG, JPEG, PNG</small>
        </div>

        <p>
            <button type="submit" name="restaurant_submit">Submit Restaurant Details</button>
        </p>

        <!-- <p class="text-center">
            <a href="dashboard">Back to Dashboard</a>
        </p> -->

    </form>
</div>

<script>
    function validateRestaurantForm() {
        var name = document.getElementById("rest_name").value;
        var type = document.getElementById("rest_type").value;
        var time = document.getElementById("rest_time").value;
        var forTwo = document.getElementById("rest_forTwo").value;
        var offer = document.getElementById("rest_offer").value;
        var valid = true;

        if (name == "") {
            document.getElementById("name_required").style.display = "block";
            valid = false;
        }

        if (type == "") {
            document.getElementById("type_required").style.display = "block";
            valid = false;
        }

        if (time == "" || time <= 0) {
            document.getElementById("time_required").style.display = "block";
            valid = false;
        }

        if (forTwo == "" || forTwo <= 0) {
            document.getElementById("forTwo_required").style.display = "block";
            valid = false;
        }

        if (offer == "") {
            document.getElementById("offer_required").style.display = "block";
            valid = false;
        }

        return valid;
    }
</script>

<?php include 'Includes/templates/footer.php'; ?>