<?php include '../connect.php'; ?>
<?php include '../Includes/functions/functions.php'; ?>

<?php

    if(isset($_POST['do_']) && $_POST['do_'] == "ChangeStatus")
    {
        $client_id = $_POST['client_id'];
        $status = $_POST['status'];

        $stmt = $con->prepare("UPDATE restaurants SET status = ? WHERE id = ?");
        $stmt->execute(array($status, $client_id));
        
        // No need to return any data for direct status change
    }

    if(isset($_POST['do_']) && $_POST['do_'] == "Search")
    {
        $search_value = $_POST['search_value'];
        
        // If search value is empty, get all clients
        if(empty($search_value)) {
            $stmt = $con->prepare("SELECT * FROM restaurants ORDER BY name ASC");
            $stmt->execute();
        } else {
            // Search by name, owner, type, or email
            $stmt = $con->prepare("SELECT * FROM restaurants 
                              WHERE name LIKE ? OR 
                                    owner LIKE ? OR 
                                    type LIKE ? OR 
                                    email LIKE ?
                              ORDER BY name ASC");
            $stmt->execute(array(
                "%".$search_value."%", 
                "%".$search_value."%", 
                "%".$search_value."%", 
                "%".$search_value."%"
            ));
        }
        
        $clients = $stmt->fetchAll();
        $output = '';
        
        foreach($clients as $client) {
            $output .= "<tr>";
            $output .= "<td>".$client['name']."</td>";
            $output .= "<td>".$client['owner']."</td>";
            $output .= "<td>".$client['type']."</td>";
            $output .= "<td>".$client['email']."</td>";
            $output .= "<td><span id='status_badge_".$client['id']."' class='badge badge-" . ($client['status'] == 'active' ? 'success' : 'danger') . "'>" . ucfirst($client['status']) . "</span></td>";
            $output .= "<td>";
            
            $view_data = "view_".$client["id"];
            $new_status = ($client['status'] == 'active') ? 'inactive' : 'active';
            $button_class = ($client['status'] == 'active') ? 'success' : 'secondary';
            $title = ($client['status'] == 'active') ? 'Set Inactive' : 'Set Active';
            
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
            $output .= "<div class='modal-header'>";
            $output .= "<h5 class='modal-title'>".$client['name']." Details</h5>";
            $output .= "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
            $output .= "<span aria-hidden='true'>&times;</span>";
            $output .= "</button>";
            $output .= "</div>";
            $output .= "<div class='modal-body'>";
            $output .= "<div class='restaurant-details'>";
            $output .= "<p><strong>Restaurant:</strong> ".$client['name']."</p>";
            $output .= "<p><strong>Owner:</strong> ".$client['owner']."</p>";
            $output .= "<p><strong>Type:</strong> ".$client['type']."</p>";
            $output .= "<p><strong>Email:</strong> ".$client['email']."</p>";
            $output .= "<p><strong>Rating:</strong> ".$client['rating']."</p>";
            $output .= "<p><strong>Delivery Time:</strong> ".$client['time']." minutes</p>";
            $output .= "<p><strong>Offers:</strong> ".$client['offer']."</p>";
            $output .= "<p><strong>Status:</strong> <span id='modal_status_".$client['id']."'>".ucfirst($client['status'])."</span></p>";
            
            
            $output .= "</div>";
            $output .= "</div>";
            $output .= "</div>";
            $output .= "</div>";
            $output .= "</div>";
            $output .= "</li>";
            
            // DIRECT STATUS TOGGLE BUTTON
            $output .= "<li class='list-inline-item' data-toggle='tooltip' title='".$title."'>";
            $output .= "<button class='btn btn-".$button_class." btn-sm rounded-0 status-toggle' type='button' data-id='".$client['id']."' data-current='".$client['status']."' data-placement='top'>";
            $output .= "<i class='fa fa-toggle-on'></i>";
            $output .= "</button>";
            $output .= "</li>";
            
            $output .= "</ul>";
            $output .= "</td>";
            $output .= "</tr>";
        }
        
        echo $output;
        exit();
    }

?>