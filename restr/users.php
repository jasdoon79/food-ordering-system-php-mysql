<?php
    ob_start();
	ini_set('session.use_only_cookies', 1);
    session_name("VendorSession");
    session_start();

	$pageTitle = 'Users';

	if(isset($_SESSION['vendor_userid']))
	{
		include 'connect.php';
  		include 'Includes/functions/functions.php'; 
		include 'Includes/templates/header.php';
		include 'Includes/templates/navbar.php';

        ?>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script type="text/javascript">

                var vertical_menu = document.getElementById("vertical-menu");


                var current = vertical_menu.getElementsByClassName("active_link");

                if(current.length > 0)
                {
                    current[0].classList.remove("active_link");   
                }
                
                vertical_menu.getElementsByClassName('users_link')[0].className += " active_link";

            </script>

        <?php
            $do = '';

            if(isset($_GET['do']) && in_array(htmlspecialchars($_GET['do']), array('Add','Edit')))
                $do = $_GET['do'];
            else
                $do = 'Manage';

            if($do == "Manage")
            {
                $stmt = $con->prepare("SELECT * FROM users");
                $stmt->execute();
                $users = $stmt->fetchAll();

            ?>
                <div class="card">
                    <div class="card-header">
                        <?php echo $pageTitle; ?>
                    </div>
                    <div class="card-body">

                        <!-- USERS TABLE -->

                        <table class="table table-bordered users-table">
                            <thead>
                                <tr>
                                    <th scope="col">Username</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Full Name</th>
                                    <!-- Removed the "Manage" column header -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($users as $user)
                                    {
                                        echo "<tr>";
                                            echo "<td>";
                                                echo $user['username'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $user['email'];
                                            echo "</td>";
                                            echo "<td>";
                                                echo $user['full_name'];
                                            echo "</td>";
                                            // Removed the "Manage" column with edit button
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>  
                    </div>
                </div>
            <?php
            }
            # Edit the user details - keeping this section in case it's needed elsewhere
            elseif($do == 'Edit')
            {
                // Redirect to the main users page since editing is no longer an option
                header('Location: users');
                exit();
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