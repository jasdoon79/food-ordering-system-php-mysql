<?php
    ob_start();
    ini_set('session.use_only_cookies', 1);
    session_name("VendorSession");
    session_start();

	$pageTitle = 'Restaurants';

	if(isset($_SESSION['vendor_userid']))
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

        <?php

            
            $do = 'Manage';

            if($do == "Manage")
            {
                $stmt = $con->prepare("SELECT name, owner, email, status FROM restaurants");
                $stmt->execute();
                $restaurants = $stmt->fetchAll();

            ?>
                <div class="card">
                    <div class="card-header">
                        <?php echo $pageTitle; ?>
                    </div>
                    <div class="card-body">

                        <!-- RESTAURANTS TABLE -->

                        <table class="table table-bordered clients-table">
                            <thead>
                                <tr>
                                    <th scope="col">Restaurant Name</th>
                                    <th scope="col">Owner</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($restaurants as $restaurant)
                                    {
                                        echo "<tr>";
                                            echo "<td>";
                                                echo $restaurant['name'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $restaurant['owner'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $restaurant['email'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $restaurant['status'];
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
        header('Location: index.php');
        exit();
    }
?>