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

// Fetch restaurant details for the current user
$stmt = $con->prepare("SELECT * FROM restaurants WHERE email = ? LIMIT 1");
$stmt->execute(array($userInfo['email']));
$restaurantDetails = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container restaurant-details">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title">Restaurant Details</h1>
            
            <?php if ($restaurantDetails): ?>
                <div class="card">
                    <div class="card-header">
                        <h2><?php echo htmlspecialchars($restaurantDetails['name']); ?></h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?php echo htmlspecialchars($restaurantDetails['img']); ?>" 
                                     alt="<?php echo htmlspecialchars($restaurantDetails['name']); ?>" 
                                     class="img-fluid restaurant-image">
                            </div>
                            <div class="col-md-8">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Restaurant Type</th>
                                        <td><?php echo htmlspecialchars($restaurantDetails['type']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Rating</th>
                                        <td>
                                            <?php 
                                            $rating = floatval($restaurantDetails['rating']);
                                            echo number_format($rating, 1) . ' / 5.0'; 
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Delivery Time</th>
                                        <td><?php echo htmlspecialchars($restaurantDetails['time']); ?> minutes</td>
                                    </tr>
                                    <tr>
                                        <th>Price for Two</th>
                                        <td>₹<?php echo htmlspecialchars($restaurantDetails['forTwo']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Special Offer</th>
                                        <td><?php echo htmlspecialchars($restaurantDetails['offer']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <?php 
                                            $status = htmlspecialchars($restaurantDetails['status']);
                                            echo ucfirst($status); 
                                            if ($status === 'inactive') {
                                                echo ' <span class="badge badge-warning">Pending Approval</span>';
                                            } elseif ($status === 'active') {
                                                echo ' <span class="badge badge-success">Approved</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p><strong>Owner:</strong> <?php echo htmlspecialchars($restaurantDetails['owner']); ?></p>
                        <p><strong>Contact Email:</strong> <?php echo htmlspecialchars($restaurantDetails['email']); ?></p>
                        <p><button onclick="window.location.href='index'">Login</button></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <p>No restaurant details found. Please submit your restaurant details first.</p>
                    <a href="register" class="btn btn-primary">Submit Restaurant Details</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'Includes/templates/footer.php'; 
session_unset();
session_destroy();?>