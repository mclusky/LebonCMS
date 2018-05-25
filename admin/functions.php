<?php

function redirect($location) {
	header("Location: {$location}");
	exit;
}

function ifIsMethod($method = null) {
	if ($_SERVER['REQUEST_METHOD'] === strtoupper($method)) {
		return true;
	}

	return false;
}

// *************** CHECK USER ROLE ******************************//
function isLoggedIn() {

	if (isset($_SESSION['role'])) {
		return true;
	} else {
		return false;
	}
}
// ******************************************************************//

//*************** CHECK LOGIN CREDENTIALS AND REDIRECT ***************//
function userLoggedInRedirect($location) {
	isLoggedIn() ? redirect($location) : '';
}
// *******************************************************************//

// *********************** DISPLAY NUMBER OF ONLINE USERS *************//
function onlineUsers() {

	if (isset($_GET['onlineusers'])) {

		global $connection;

		if (!$connection) {
			session_start();
			include '../include/db.php';

			$session = session_id();
			$time = time();
			$time_out_secs = 10;
			$time_out = $time - $time_out_secs;

			$query = "SELECT * FROM users_online WHERE session = '$session'";
			$send_query = mysqli_query($connection, $query);
			$count = mysqli_num_rows($send_query);

			if ($count == NULL) {
				mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
			} else {
				mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
			}

			$users_online = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
			echo $count_users = mysqli_num_rows($users_online);
		}
	}
}
// ******* CALL IT ****** //
onlineUsers();
// ************************************************************************** //

// *************** CONFIRM CONNECTION TO DATABASE *************************** //
function confirm($result) {
	global $connection;

	if (!$result) {
		die("Query Failed : " . mysqli_error($connection));
	}
}
// ************************************************************************** //

// *************************** EDIT/UPDATE CMS *********************************** //
function insertCategories() {
	global $connection;
	if (isset($_POST['submit'])) {

		$title = escape($_POST['cat_title']);

		if ($title === "" || empty($title)) {
			echo "This field should not be empty";
		} else {

			$stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?)");

			mysqli_stmt_bind_param($stmt, 's', $title);

			mysqli_stmt_execute($stmt);

			if (!$stmt) {
				die("QUERY FAILED");
			}
		}
		mysqli_stmt_close($stmt);
	}

}

function deleteCategories() {
	global $connection;

	if (isset($_GET['delete'])) {
		$cat_id_to_delete = escape($_GET['delete']);
		$query = "DELETE FROM categories WHERE cat_id = {$cat_id_to_delete} ";
		$delete_query = mysqli_query($connection, $query);
		header("Location: categories.php");

	}
}

function populateCategories() {

	global $connection;

	$query = "SELECT * FROM categories";
	$categories_query = mysqli_query($connection, $query);

	while ($row = mysqli_fetch_assoc($categories_query)) {
		$cat_title = $row['cat_title'];
		$cat_id = $row['cat_id'];
		echo "<tr>
            <td>{$cat_id}</td>
            <td>{$cat_title}</td>
            <td><a class='btn btn-info' href='categories.php?update=${cat_id}'>Edit</a></td>
            <td><a class='btn btn-danger' href='categories.php?delete=${cat_id}'>Delete</a></td>
        </tr>";

	}
}

function updateStatus($options, $value) {
	global $connection;

	$query = "UPDATE posts SET post_status = '{$options}' WHERE post_id = {$value} ";
	$update_post_status = mysqli_query($connection, $query);

	return $update_post_status;
}
// ******************************************************************* //

// ****************** COUNT ROWS IN SELECTED TABLE ******************** //
function countDetails($table) {
	global $connection;

	$query = "SELECT * FROM {$table}";
	$select_all = mysqli_query($connection, $query);
	confirm($select_all);

	return $select_all;

}
// ******************************************************************** //

// ***************** GETTING DATA FOR ADMIN GRAPHS ******************** //
function getTableData($table, $column, $status) {
	global $connection;

	$query = "SELECT * FROM {$table} WHERE {$column} = '{$status}' ";
	$result = mysqli_query($connection, $query);

	confirm($result);

	return mysqli_num_rows($result);
}
// ******************************************************************* //

// ********** PROTECT AGAINST SQL INJECIONS *************** //
function escape($string) {
	global $connection;
	return mysqli_real_escape_string($connection, trim($string));

}
// *************************************************************** //

// ******************* CHECK IF USER IS ADMIN***************** //
function is_admin($username = '') {
	global $connection;

	$query = "SELECT user_role FROM users WHERE username = '{$username}'";
	$result = mysqli_query($connection, $query);
	confirm($result);

	$row = mysqli_fetch_array($result);

	return $row['user_role'] === 'admin' ? true : false;
}

// ************* VERIFY IF CREDENTIALS ALREADY EXIST **************//
function usernameExists($username) {

	global $connection;

	$query = "SELECT username FROM users WHERE username = '{$username}'";
	$result = mysqli_query($connection, $query);
	confirm($result);

	return mysqli_num_rows($result) > 0 ? true : false;

}

function emailExists($email) {
	global $connection;

	$query = "SELECT user_email FROM users WHERE user_email = '{$email}'";
	$result = mysqli_query($connection, $query);
	confirm($result);

	return mysqli_num_rows($result) > 0 ? true : false;
}
// ***************************************************************** //

// ************REGISTER USER AFTER CREDENTIALS CHECK**************** //
function registerUser($username, $firstname, $lastname, $email, $password) {
	global $connection;

	$username = escape($_POST['username']);
	$firstname = escape($_POST['firstname']);
	$lastname = escape($_POST['lastname']);
	$email = escape($_POST['email']);
	$password = escape($_POST['password']);

	$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

	$query = "INSERT INTO users (username, user_firstname, user_lastname, user_email, user_password, user_role) ";
	$query .= "VALUES('{$username}', '{$firstname}', '{$lastname}', '{$email}', '{$password}', 'subscriber' )";
	$register_user = mysqli_query($connection, $query);
	confirm($register_user);

}

function loginUser($username, $password) {
	global $connection;

	$username = escape($username);
	$password = escape($password);

	$query = "SELECT * FROM users WHERE username = '{$username}' ";
	$login_user = mysqli_query($connection, $query);

	confirm($login_user);

	while ($row = mysqli_fetch_array($login_user)) {

		$db_id = $row['user_id'];
		$db_password = $row['user_password'];
		$db_username = $row['username'];
		$db_firstname = $row['user_firstname'];
		$db_lastname = $row['user_lastname'];
		$db_role = $row['user_role'];
		$db_email = $row['user_email'];

		//Decrypting Password using crypted password form database
		// $login_password = crypt($login_password, $db_password);

		if (password_verify($password, $db_password)) {

			session_start();

			$_SESSION['username'] = $db_username;
			$_SESSION['firstname'] = $db_firstname;
			$_SESSION['lastname'] = $db_lastname;
			$_SESSION['role'] = $db_role;

			redirect('/cms/admin/');

		} else {

			return false;
		}
	}

}

?>