<?php
// DELETE USERS OR MAKE ADMIN/SUBSCRIBER
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {

	if (isset($_GET['delete'])) {
		$user_to_delete = escape($_GET['delete']);
		$query = "DELETE FROM users WHERE user_id = {$user_to_delete} ";
		$delete_query = mysqli_query($connection, $query);
		header("Location: users.php");
	}

	if (isset($_GET['change_to_admin'])) {
		$user_to_admin = escape($_GET['change_to_admin']);
		$query = "UPDATE users SET user_role = 'admin' WHERE user_id = {$user_to_admin}";
		$make_admin_query = mysqli_query($connection, $query);
		header("Location: users.php");
	}

	if (isset($_GET['change_to_sub'])) {
		$user_to_sub = escape($_GET['change_to_sub']);
		$query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = {$user_to_sub} ";
		$make_sub_query = mysqli_query($connection, $query);
		header("Location: users.php");
	}
}

?>
		<div class="table-responsive">
           <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>

<?php

$query = "SELECT * FROM users";
$users_query = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($users_query)) {
	$user_id = $row['user_id'];
	$username = $row['username'];
	$user_password = $row['user_password'];
	$user_firstname = $row['user_firstname'];
	$user_lastname = $row['user_lastname'];
	$user_email = $row['user_email'];
	$user_image = $row['user_image'];
	$user_role = $row['user_role'];

	echo "<tr>
                <td>{$user_id}</td>
                <td>{$username}</td>
                <td>{$user_firstname}</td>
                <td>{$user_lastname}</td>
                <td>{$user_email}</td>
                <td>{$user_role}</td>
                <td><a class='btn btn-outline-primary' href='users.php?change_to_admin={$user_id}'>Make Admin</a></td>
                <td><a class='btn btn-outline-danger' href='users.php?change_to_sub={$user_id}'>Remove Admin</a></td>
                <td><a class='btn btn-outline-primary' href='users.php?source=edit_user&user_to_edit={$user_id}'>Edit</a></td>
                <td><a class='delete btn btn-outline-danger' href='users.php?delete={$user_id}'>Delete</a></td>
            </tr>";

}
?>
                        </tbody>

                    </table>
				</div>
