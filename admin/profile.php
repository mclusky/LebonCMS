<?php include 'include/admin_header.php';?>
<?php if (isset($_SESSION)) {
	$username = $_SESSION['username'];

	$query = "SELECT * FROM users WHERE username = '{$username}'";
	$user_profile_query = mysqli_query($connection, $query);

	while ($row = mysqli_fetch_array($user_profile_query)) {

		$firstname = $row['user_firstname'];
		$lastname = $row['user_lastname'];
		$user_role = $row['user_role'];
		$password = $row['user_password'];
		$email = $row['user_email'];
	}
}
?>

<?php

if (isset($_POST['edit_user'])) {

	$firstname = escape($_POST['firstname']);
	$lastname = escape($_POST['lastname']);
	// $post_image = $_FILES['post_image']['name'];
	// $post_image_temp = $_FILES['post_image']['tmp_name'];

	$username = escape($_POST['username']);
	$password = escape($_POST['password']);
	$email = escape($_POST['email']);

	$query = "UPDATE users SET ";
	$query .= "user_firstname = '{$firstname}', ";
	$query .= "user_lastname = '{$lastname}', ";
	$query .= "username = '{$username}', ";
	$query .= "user_password = '{$password}', ";
	$query .= "user_email = '{$email}' ";
	$query .= "WHERE username = '{$username}'";

	$edit_user_query = mysqli_query($connection, $query);

	confirm($edit_user_query);
}

?>

<div id="wrapper">
    <!-- Navigation -->
    <?php include 'include/admin_navigation.php';?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Welcome to Profile</h1>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="" class="form-control" name="username" value="<?php echo $username; ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
        <?php include 'include/admin_footer.php';?>