
<?php
    // Include database connection and functions
    // Paths are relative to the current file, which is inside the functions directory
    require_once 'connect.php';
    require_once 'functions.php';
    
    // Always get all menu items regardless of restaurant_id parameter
    getMenuItemsJson();
?>