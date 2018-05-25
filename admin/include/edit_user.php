 <?php

if (isset($_GET['user_to_edit'])) {
	$user_id = escape($_GET['user_to_edit']);

	$query = "SELECT * FROM users WHERE user_id = $user_id";
	$get_user_info = mysqli_query($connection, $query);

	while ($row = mysqli_fetch_assoc($get_user_info)) {
		$firstname = $row['user_firstname'];
		$lastname = $row['user_lastname'];
		$user_role = $row['user_role'];
		$username = $row['username'];
		$email = $row['user_email'];
	}

	if (isset($_POST['edit_user'])) {

		$firstname = escape($_POST['firstname']);
		$lastname = escape($_POST['lastname']);
		$user_role = escape($_POST['user_role']);
		// $post_image = $_FILES['post_image']['name'];
		// $post_image_temp = $_FILES['post_image']['tmp_name'];

		$username = escape($_POST['username']);
		$password = escape($_POST['password']);
		$email = escape($_POST['email']);

		if (!empty($password)) {

			$query_password = "SELECT user_password FROM users WHERE user_id = $user_id";
			$get_user = mysqli_query($connection, $query_password);

			confirm($get_user);

			$row = mysqli_fetch_array($get_user);

			$db_user_password = $row['user_password'];

			if ($db_user_password !== $password) {
				$hashed_password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
			}

			$query = "UPDATE users SET ";
			$query .= "user_firstname = '{$firstname}', ";
			$query .= "user_lastname = '{$lastname}', ";
			$query .= "user_role = '{$user_role}', ";
			$query .= "username = '{$username}', ";
			$query .= "user_password = '{$hashed_password}', ";
			$query .= "user_email = '{$email}' ";
			$query .= "WHERE user_id = {$user_id}";

			$edit_user_query = mysqli_query($connection, $query);

			confirm($edit_user_query);
			header("Location: users.php");
		} else {
			echo "<strong class='bg-danger'>Password Required</strong>";
		}

	}
} else {
	header("Location: index.php");
}
?>
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
		<select name="user_role" id="">
			<option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
			<?php
if ($user_role === 'Admin') {
	echo '<option value="subscriber">subscriber</option>';
} else {
	echo '<option value="admin">admin</option>;';
}
?>
		</select>
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
		<input type="submit" class="btn btn-primary" name="edit_user" value="Edit">
	</div>

</form>