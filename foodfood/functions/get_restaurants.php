<?php
    // Include database connection and functions
    require_once 'connect.php';
    require_once 'functions.php';
    
    // Call the function to output restaurants as JSON
    getRestaurantsJson();
?>