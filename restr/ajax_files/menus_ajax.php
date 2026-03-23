<?php include '../connect.php'; ?>
<?php include '../Includes/functions/functions.php'; ?>

<?php

	if(isset($_POST['do_']) && $_POST['do_'] == "Delete")
	{
		$menu_id = $_POST['menu_id'];

        $stmt = $con->prepare("DELETE from menus where menu_id = ?");
        $stmt->execute(array($menu_id));
	}

	if(isset($_POST['do_']) && $_POST['do_'] == "Search")
{
    $search_value = $_POST['search_value'];
    
    // If search value is empty, get all menus
    if(empty($search_value)) {
        $stmt = $con->prepare("SELECT * FROM menus m, menu_categories mc WHERE mc.category_id = m.category_id");
        $stmt->execute();
    } else {
        // Search by name, category, description or price
        $stmt = $con->prepare("SELECT * FROM menus m, menu_categories mc 
                          WHERE mc.category_id = m.category_id AND 
                          (m.menu_name LIKE ? OR 
                           mc.category_name LIKE ? OR 
                           m.menu_description LIKE ? OR 
                           m.menu_price LIKE ?)");
        $stmt->execute(array("%".$search_value."%", 
                            "%".$search_value."%", 
                            "%".$search_value."%", 
                            "%".$search_value."%"));
    }
    
    $menus = $stmt->fetchAll();
    $output = '';
    
    foreach($menus as $menu) {
        $output .= "<tr>";
        $output .= "<td>".$menu['menu_name']."</td>";
        $output .= "<td style='text-transform:capitalize'>".$menu['category_name']."</td>";
        $output .= "<td>".$menu['menu_description']."</td>";
        $output .= "<td>$".$menu['menu_price']."</td>";
        $output .= "<td>";
        
        $delete_data = "delete_".$menu["menu_id"];
        $view_data = "view_".$menu["menu_id"];
        
        $output .= "<ul class='list-inline m-0'>";
        
        // VIEW BUTTON
        $output .= "<li class='list-inline-item' data-toggle='tooltip' title='View'>";
        $output .= "<button class='btn btn-primary btn-sm rounded-0' type='button' data-toggle='modal' data-target='#".$view_data."' data-placement='top'>";
        $output .= "<i class='fa fa-eye'></i>";
        $output .= "</button>";
        
        // VIEW MODAL
        $output .= "<div class='modal fade' id='".$view_data."' tabindex='-1' role='dialog' aria-labelledby='".$view_data."' aria-hidden='true'>";
        $output .= "<div class='modal-dialog modal-dialog' role='document'>";
        $output .= "<div class='modal-content'>";
        $output .= "<div class='modal-body'>";
        $output .= "<div class='thumbnail' style='cursor:pointer'>";
        $source = "Uploads/images/".$menu['menu_image'];
        $output .= "<img src='".$source."'>";
        $output .= "<div class='caption'>";
        $output .= "<h3>";
        $output .= "<span style='float: right;'>$".$menu['menu_price']."</span>";
        $output .= $menu['menu_name'];
        $output .= "</h3>";
        $output .= "<p>".$menu['menu_description']."</p>";
        $output .= "</div>";
        $output .= "</div>";
        $output .= "</div>";
        $output .= "</div>";
        $output .= "</div>";
        $output .= "</div>";
        $output .= "</li>";
        
        // EDIT BUTTON
        $output .= "<li class='list-inline-item' data-toggle='tooltip' title='Edit'>";
        $output .= "<button class='btn btn-success btn-sm rounded-0'>";
        $output .= "<a href='menus.php?do=Edit&menu_id=".$menu['menu_id']."' style='color: white;'>";
        $output .= "<i class='fa fa-edit'></i>";
        $output .= "</a>";
        $output .= "</button>";
        $output .= "</li>";
        
        // DELETE BUTTON
        $output .= "<li class='list-inline-item' data-toggle='tooltip' title='Delete'>";
        $output .= "<button class='btn btn-danger btn-sm rounded-0' type='button' data-toggle='modal' data-target='#".$delete_data."' data-placement='top'>";
        $output .= "<i class='fa fa-trash'></i>";
        $output .= "</button>";
        
        // DELETE MODAL
        $output .= "<div class='modal fade' id='".$delete_data."' tabindex='-1' role='dialog' aria-labelledby='".$delete_data."' aria-hidden='true'>";
        $output .= "<div class='modal-dialog' role='document'>";
        $output .= "<div class='modal-content'>";
        $output .= "<div class='modal-header'>";
        $output .= "<h5 class='modal-title'>Delete Menu</h5>";
        $output .= "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
        $output .= "<span aria-hidden='true'>&times;</span>";
        $output .= "</button>";
        $output .= "</div>";
        $output .= "<div class='modal-body'>";
        $output .= "Are you sure you want to delete this Menu \"".strtoupper($menu['menu_name'])."\"?";
        $output .= "</div>";
        $output .= "<div class='modal-footer'>";
        $output .= "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>";
        $output .= "<button type='button' data-id='".$menu['menu_id']."' class='btn btn-danger delete_menu_bttn'>Delete</button>";
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