<?php include '../connect.php'; ?>
<?php include '../Includes/functions/functions.php'; ?>

<?php
	
	if(isset($_POST['do']) && $_POST['do'] == "Add")
	{
        $category_name = test_input($_POST['category_name']);

        $checkItem = checkItem("category_name","menu_categories",$category_name);

        if($checkItem != 0)
        {
            $data['alert'] = "Warning";
            $data['message'] = "This category name already exists!";
            echo json_encode($data);
            exit();
        }
        elseif($checkItem == 0)
        {
        	//Insert into the database
            $stmt = $con->prepare("insert into menu_categories(category_name) values(?) ");
            $stmt->execute(array($category_name));

            $data['alert'] = "Success";
            $data['message'] = "The new category has been inserted successfully !";
            echo json_encode($data);
            exit();
        }
            
	}

	if(isset($_POST['do']) && $_POST['do'] == "Delete")
	{
		$category_id = $_POST['category_id'];

        $stmt = $con->prepare("DELETE from menu_categories where category_id = ?");
        $stmt->execute(array($category_id));    
	}
	
	if(isset($_POST['do']) && $_POST['do'] == "Search")
	{
	    $search_value = $_POST['search_value'];
	    
	    // If search value is empty, get all categories
	    if(empty($search_value)) {
	        $stmt = $con->prepare("SELECT * FROM menu_categories");
	        $stmt->execute();
	    } else {
	        // Search by ID or name
	        $stmt = $con->prepare("SELECT * FROM menu_categories 
	                              WHERE category_id LIKE ? OR category_name LIKE ?");
	        $stmt->execute(array("%".$search_value."%", "%".$search_value."%"));
	    }
	    
	    $categories = $stmt->fetchAll();
	    $output = '';
	    
	    foreach($categories as $category) {
	        $output .= "<tr>";
	        $output .= "<td>".$category['category_id']."</td>";
	        $output .= "<td style='text-transform:capitalize'>".$category['category_name']."</td>";
	        $output .= "<td>";
	        
	        $delete_data = "delete_".$category["category_id"];
	        $output .= "<ul class='list-inline m-0'>";
	        $output .= "<li class='list-inline-item' data-toggle='tooltip' title='Delete'>";
	        $output .= "<button class='btn btn-danger btn-sm rounded-0' type='button' data-toggle='modal' data-target='#".$delete_data."' data-placement='top'>";
	        $output .= "<i class='fa fa-trash'></i>";
	        $output .= "</button>";
	        
	        $output .= "<div class='modal fade' id='".$delete_data."' tabindex='-1' role='dialog' aria-labelledby='".$delete_data."' aria-hidden='true'>";
	        $output .= "<div class='modal-dialog' role='document'>";
	        $output .= "<div class='modal-content'>";
	        $output .= "<div class='modal-header'>";
	        $output .= "<h5 class='modal-title'>Delete Category</h5>";
	        $output .= "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
	        $output .= "<span aria-hidden='true'>&times;</span>";
	        $output .= "</button>";
	        $output .= "</div>";
	        $output .= "<div class='modal-body'>";
	        $output .= "Are you sure you want to delete this Category \"".strtoupper($category['category_name'])."\"?";
	        $output .= "</div>";
	        $output .= "<div class='modal-footer'>";
	        $output .= "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>";
	        $output .= "<button type='button' data-id='".$category['category_id']."' class='btn btn-danger delete_category_bttn'>Delete</button>";
	        $output .= "</div>";
	        $output .= "</div>";
	        $output .= "</div>";
	        $output .= "</div>";
	        $output .= "</li>";
	        $output .= "</ul>";
	        
	        $output .= "</td>";
	        $output .= "</tr>";
	    }
	    
	    echo $output;
	    exit();
	}
	
?>