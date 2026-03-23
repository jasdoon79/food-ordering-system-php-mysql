<?php
    ob_start();
    ini_set('session.use_only_cookies', 1);
    session_name("AdminSession");
    session_start();

	$pageTitle = 'Clients Management';

	if(isset($_SESSION['admin_id']))
	{
		include 'connect.php';
  		include 'Includes/functions/functions.php'; 
		include 'Includes/templates/header.php';
		include 'Includes/templates/navbar.php';

        ?>

            <script type="text/javascript">
                var vertical_menu = document.getElementById("vertical-menu");

                var current = vertical_menu.getElementsByClassName("active_link");

                if(current.length > 0)
                {
                    current[0].classList.remove("active_link");   
                }
                
                vertical_menu.getElementsByClassName('clients_link')[0].className += " active_link";
            </script>
            
            <style type="text/css">
                .clients-table
                {
                    -webkit-box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
                    box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
                }
                
                .search-container {
                    margin-bottom: 20px;
                    width: 300px;
                    float: right;
                }

                .search-bar {
                    width: 100%;
                }

                .clearfix::after {
                    content: "";
                    clear: both;
                    display: table;
                }

                @media (max-width: 768px) {
                    .search-container {
                        float: none;
                        width: 100%;
                        margin-top: 10px;
                    }
                }
                
                .status-toggle {
                    cursor: pointer;
                }
            </style>

        <?php

            $do = '';

            if(isset($_GET['do']) && in_array(htmlspecialchars($_GET['do']), array('View')))
                $do = $_GET['do'];
            else
                $do = 'Manage';

            if($do == "Manage")
            {
                $stmt = $con->prepare("SELECT * FROM restaurants ORDER BY name ASC");
                $stmt->execute();
                $clients = $stmt->fetchAll();

            ?>
                <div class="card">
                    <div class="card-header">
                        <?php echo $pageTitle; ?>
                    </div>
                    <div class="card-body">

                        <!-- SEARCH BAR -->
                        <div class="above-table clearfix" style="margin-bottom: 1rem!important;">
                            <div class="search-container">
                                <div class="input-group search-bar">
                                    <input type="text" id="search_input" class="form-control" placeholder="Search clients...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" id="search_button" type="button">
                                        <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CLIENTS TABLE -->

                        <table class="table table-bordered clients-table">
                            <thead>
                                <tr>
                                    <th scope="col">Restaurant Name</th>
                                    <th scope="col">Owner</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($clients as $client)
                                    {
                                        echo "<tr>";
                                            echo "<td>";
                                                echo $client['name'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $client['owner'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $client['type'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $client['email'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo "<span id='status_badge_".$client['id']."' class='badge badge-" . ($client['status'] == 'active' ? 'success' : 'danger') . "'>";
                                                echo ucfirst($client['status']);
                                                echo "</span>";
                                            echo "</td>";
                                            echo "<td>";
                                                $view_data = "view_".$client["id"];
                                                $new_status = ($client['status'] == 'active') ? 'inactive' : 'active';
                                                $button_class = ($client['status'] == 'active') ? 'success' : 'secondary';
                                                $title = ($client['status'] == 'active') ? 'Set Inactive' : 'Set Active';
                                                ?>
                                                <ul class="list-inline m-0">
                                                    <!-- VIEW BUTTON -->
                                                    <li class="list-inline-item" data-toggle="tooltip" title="View">
                                                        <button class="btn btn-primary btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $view_data; ?>" data-placement="top" >
                                                            <i class="fa fa-eye"></i>
                                                        </button>

                                                        <!-- VIEW Modal -->
                                                        <div class="modal fade" id="<?php echo $view_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $view_data; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"><?php echo $client['name']; ?> Details</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="restaurant-details">
                                                                            <p><strong>Restaurant:</strong> <?php echo $client['name']; ?></p>
                                                                            <p><strong>Owner:</strong> <?php echo $client['owner']; ?></p>
                                                                            <p><strong>Type:</strong> <?php echo $client['type']; ?></p>
                                                                            <p><strong>Email:</strong> <?php echo $client['email']; ?></p>
                                                                            <p><strong>Rating:</strong> <?php echo $client['rating']; ?></p>
                                                                            <p><strong>Delivery Time:</strong> <?php echo $client['time']; ?> minutes</p>
                                                                            <p><strong>Offers:</strong> <?php echo $client['offer']; ?></p>
                                                                            <p><strong>Status:</strong> <span id="modal_status_<?php echo $client['id']; ?>"><?php echo ucfirst($client['status']); ?></span></p>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <!-- DIRECT STATUS TOGGLE -->
                                                    <li class="list-inline-item" data-toggle="tooltip" title="<?php echo $title; ?>">
                                                        <button class="btn btn-<?php echo $button_class; ?> btn-sm rounded-0 status-toggle" 
                                                                type="button" 
                                                                data-id="<?php echo $client['id']; ?>" 
                                                                data-current="<?php echo $client['status']; ?>" 
                                                                data-placement="top">
                                                            <i class="fa fa-toggle-on"></i>
                                                        </button>
                                                    </li>
                                                </ul>
                                                <?php
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>  
                    </div>
                </div>
            <?php
            }

        /* FOOTER BOTTOM */

        include 'Includes/templates/footer.php';

    }
    else
    {
        header('Location: index');
        exit();
    }

?>

<!-- JS SCRIPT -->

<script type="text/javascript">
    // Direct status toggle without modal
    $(document).on('click', '.status-toggle', function() {
        var client_id = $(this).data('id');
        var current_status = $(this).data('current');
        var new_status = (current_status === 'active') ? 'inactive' : 'active';
        var button = $(this);
        
        $.ajax({
            url: "ajax_files/clients_ajax",
            method: "POST",
            data: {client_id: client_id, status: new_status, do_: "ChangeStatus"},
            success: function(data) {
                // Update the button appearance
                if (new_status === 'active') {
                    button.removeClass('btn-secondary').addClass('btn-success');
                    button.attr('title', 'Set Inactive');
                    button.data('current', 'active');
                    $('#status_badge_' + client_id).removeClass('badge-danger').addClass('badge-success').text('Active');
                    
                    // Update modal status if it exists
                    if ($('#modal_status_' + client_id).length) {
                        $('#modal_status_' + client_id).text('Active');
                    }
                } else {
                    button.removeClass('btn-success').addClass('btn-secondary');
                    button.attr('title', 'Set Active');
                    button.data('current', 'inactive');
                    $('#status_badge_' + client_id).removeClass('badge-success').addClass('badge-danger').text('Inactive');
                    
                    // Update modal status if it exists
                    if ($('#modal_status_' + client_id).length) {
                        $('#modal_status_' + client_id).text('Inactive');
                    }
                }
                
                // Re-initialize tooltip
                $('[data-toggle="tooltip"]').tooltip('dispose').tooltip();
            },
            error: function(xhr, status, error) {
                console.error('Error updating status:', error);
            }
        });
    });

    // Search functionality
    $('#search_input').keyup(function() {
        searchClients();
    });

    $('#search_button').click(function() {
        searchClients();
    });

    function searchClients() {
        var searchValue = $('#search_input').val().toLowerCase();
        
        $.ajax({
            url: "ajax_files/clients_ajax",
            method: "POST",
            data: {search_value: searchValue, do_: "Search"},
            success: function(data) {
                $('tbody').html(data);
                // Re-initialize tooltips after search
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function(xhr, status, error) {
                console.error('Error searching clients:', error);
            }
        });
    }
    
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>