 <?php

if (isset($_POST['create_user'])) {

	$firstname = escape($_POST['firstname']);
	$lastname = escape($_POST['lastname']);
	$user_role = escape($_POST['user_role']);
	// $post_image = $_FILES['post_image']['name'];
	// $post_image_temp = $_FILES['post_image']['tmp_name'];

	$username = escape($_POST['username']);
	$password = escape($_POST['password']);
	$email = escape($_POST['email']);

	$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

	$query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_password, user_email) ";

	$query .= "VALUES('{$firstname}','{$lastname}','{$user_role}','{$username}','{$password}','{$email}') ";

	$create_user_query = mysqli_query($connection, $query);

	confirm($create_user_query);

	echo "<p class='bg-success lead'>User Created. " . " " . "Back to <a href='users.php'>Users</a></p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<div class="form-group">
		<label for="firstname">First Name</label>
		<input type="text" class="form-control" name="firstname">
	</div>
	<div class="form-group">
		<label for="lastname">Last Name</label>
		<input type="text" class="form-control" name="lastname">
	</div>
	<div class="form-group">
		<select name="user_role" id="">
			<option value="subscriber">Select Option</option>
			<option value="admin">Admin</option>
			<option value="subscriber">Subscriber</option>
		</select>
	</div>
	<div class="form-group">
		<label for="username">Username</label>
		<input type="" class="form-control" name="username">
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" class="form-control" name="password">
	</div>
	<div class="form-group">
		<label for="email">Email</label>
		<input type="email" class="form-control" name="email">
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_user" value="Add">
	</div>

</form>