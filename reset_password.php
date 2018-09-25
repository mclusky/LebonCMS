<?php include "include/header.php";?>


<?php

if (!isset($_GET['email']) && !isset($_GET['token'])) {
	redirect('index');
}

//********************* GETTING DATABASE USER DETAILS *************************//
//*****************************************************************************//
$token_sent = escape($_GET['token']);
$email_sent = escape($_GET['email']);
$query = "SELECT username, user_email, token FROM users WHERE token=?";

if ($stmt = mysqli_prepare($connection, $query)) {

	mysqli_stmt_bind_param($stmt, 's', $token_sent);

	mysqli_stmt_execute($stmt);

	mysqli_stmt_bind_result($stmt, $username, $user_email, $token);

	mysqli_stmt_fetch($stmt);

	mysqli_stmt_close($stmt);

	if ($token_sent !== $token || $email_sent !== $user_email) {
		redirect('index');
	}

	//************************CHECKING AND VALIDATING NEW PASSWORD *************************//
	//**************************************************************************************//
	if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {

		if ($_POST['password'] !== $_POST['confirmPassword']) {
			echo "<h2 class='bg-danger text-center'>Passwords Do Not Match.</h2>";
		} else {
			// ************ UPDATE DATABASE *************//

			// HASHING NEW PASSWORD //
			$new_password = escape($_POST['password']);
			$new_password = password_hash($new_password, PASSWORD_BCRYPT, array('cost' => 12));

			$query = "UPDATE users SET token = '', user_password = ? WHERE user_email = ?";
			if ($stmt1 = mysqli_prepare($connection, $query)) {

				mysqli_stmt_bind_param($stmt1, 'ss', $new_password, $email_sent);

				mysqli_stmt_execute($stmt1);

				if (mysqli_stmt_affected_rows($stmt1) >= 1) {

					mysqli_stmt_close($stmt1);

					redirect('/cms/login');

				}
			}

		}
	}

}

?>
 <!-- Navigation -->

    <?php include "include/navigation.php";?>


<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="text-center card-body">
                    <div class="card-header">
                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        <h2 class="text-center card-title">Forgot Password?</h2>
                        <p>You can reset your password here.</p>
                    </div>
                    <form id="register-form" role="form" autocomplete="off" class="form" method="post" action="">
                        <div class="input-group">
                            <input id="password" name="password" placeholder="New Password" class="form-control"  type="password">
                        </div>
                        <div class="input-group">
                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" class="form-control"  type="password">
                        </div>
                        <div class="form-group">
                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                        </div>
                        <input type="hidden" class="hide" name="token" id="token" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <?php include "include/footer.php";?>

</div> <!-- /.container -->

