<?php include '../connect.php'; ?>
<?php include '../Includes/functions/functions.php'; ?>

<?php
	
	if(isset($_POST['do_']) && $_POST['do_'] == "Deliver_Order")
{
    $order_id = $_POST['order_id'];
    $vendor_id = $_SESSION['vendor_id']; // Assuming vendor ID is stored in session

    // Ensure the order belongs to the vendor's restaurant
    $stmt = $con->prepare("SELECT * FROM placed_orders WHERE order_id = ? AND restaurant_id = (SELECT restaurant_id FROM vendors WHERE vendor_id = ?)");
    $stmt->execute(array($order_id, $vendor_id));
    
    if($stmt->rowCount() > 0) {
        $stmt = $con->prepare("UPDATE placed_orders SET delivered = 1 WHERE order_id = ?");
        $stmt->execute(array($order_id));
    } else {
        echo "Unauthorized action.";
    }
}
	elseif(isset($_POST['do_']) && $_POST['do_'] == "Cancel_Order")
	{
		$order_id = $_POST['order_id'];
		$cancellation_reason_order = test_input($_POST['cancellation_reason_order']);

        $stmt = $con->prepare("update placed_orders set canceled = 1, cancellation_reason = ? where order_id = ?");
        $stmt->execute(array($cancellation_reason_order,$order_id));
	}

?>