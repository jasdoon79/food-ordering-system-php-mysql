<?php
    /*
		Title Function That Echo The Page Title In Case The Page Has The Variable $pageTitle And Echo Default Title For Other Pages
	*/
	function getTitle()
	{
		global $pageTitle;
		if(isset($pageTitle))
			echo $pageTitle."Swiga";
		else
			echo "Swiga";
	}

	/*
		This function returns the number of items in a given table
	*/

    function countItems($item,$table)
	{
		global $con;
		$stat_ = $con->prepare("SELECT COUNT($item) FROM $table");
		$stat_->execute();
		
		return $stat_->fetchColumn();
	}

    /*
	
	** Check Items Function
	** Function to Check Item In Database [Function with Parameters]
	** $select = the item to select [Example : user, item, category]
	** $from = the table to select from [Example : users, items, categories]
	** $value = The value of select [Example: Ossama, Box, Electronics]

	*/
	function checkItem($select, $from, $value)
	{
		global $con;
		$statment = $con->prepare("SELECT $select FROM $from WHERE $select = ? ");
		$statment->execute(array($value));
		$count = $statment->rowCount();
		
		return $count;
	}


  	/*
    	==============================================
    	TEST INPUT FUNCTION, IS USED FOR SANITIZING USER INPUTS
    	AND REMOVE SUSPICIOUS CHARS and Remove Extra Spaces
    	==============================================
	
	*/

  	function test_input($data) 
  	{
      	$data = trim($data);
      	$data = stripslashes($data);
      	$data = htmlspecialchars($data);
      	return $data;
  	}

	/*
		==============================================
		GET RESTAURANTS FUNCTION
		This function fetches all restaurants from the database
		and returns them as JSON
		==============================================
	*/
	
	function getRestaurants() 
	{
		global $con;
		
		try {
			// Prepare SQL to fetch all restaurants
			$stmt = $con->prepare("SELECT * FROM restaurants where status= 'active'");
			$stmt->execute();
			
			// Fetch all rows as associative array
			$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			// Return restaurants data
			return $restaurants;
		} catch(PDOException $e) {
			// Return empty array with error info
			return ['error' => 'Database error: ' . $e->getMessage()];
		}
	}

	/*
		==============================================
		GET RESTAURANTS JSON FUNCTION
		This function outputs restaurants data as JSON
		Used for AJAX requests from JavaScript
		==============================================
	*/
	
	function getRestaurantsJson()
	{
		header('Content-Type: application/json');
		echo json_encode(getRestaurants());
		exit;
	}

	function getMenuItems($restaurant_id = 0) 
{
    global $con;
    
    try {
        // Always fetch all menu items
        $stmt = $con->prepare("SELECT m.*, c.category_name, r.name as restaurant_name 
                              FROM menus m 
                              LEFT JOIN categories c ON m.category_id = c.category_id
                              LEFT JOIN restaurants r ON m.restaurant_id = r.id
                              ORDER BY m.restaurant_id, m.category_id");
        $stmt->execute();
        
        // Fetch all rows as associative array
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return menu items data
        return $menuItems;
    } catch(PDOException $e) {
        // Return empty array with error info
        return ['error' => 'Database error: ' . $e->getMessage()];
    }
}

/*
    ==============================================
    GET MENU ITEMS JSON FUNCTION
    This function outputs menu items data as JSON
    Used for AJAX requests from JavaScript
    ==============================================
*/
function getMenuItemsJson($restaurant_id = 0)
{
    header('Content-Type: application/json');
    echo json_encode(getMenuItems($restaurant_id));
    exit;}
?>