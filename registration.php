<?php include "include/header.php";?>

<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {

	$username = escape($_POST['username']);
	$firstname = escape($_POST['firstname']);
	$lastname = escape($_POST['lastname']);
	$email = escape($_POST['email']);
	$password = escape($_POST['password']);

	$error = [

		'username' => '',
		'email' => '',
		'password' => '',
	];

	if (strlen($username) < 4) {
		$error['username'] = "Username must be at least 5 characters long.";
	}

	if ($username === '') {
		$error['username'] = "Username field can not be empty.";
	}

	if (usernameExists($username)) {
		$error['username'] = "Username already exists.";
	}

	if ($email === '') {
		$error['email'] = "Email field can not be empty.";
	}

	if (usernameExists($email)) {
		$error['email'] = "Email already in use. You can login<a href='index.php'>here</a>";
	}
	if ($password === '') {
		$error['password'] = "Password field can not be empty.";
	}

	// CHECK FOR REGISTRATION INPUT ERRORS
	foreach ($error as $key => $value) {
		//REGISTER AND LOGIN USER IF NO ERRORS
		if (empty($value)) {
			unset($error[$key]);
			// loginUser($username, $password);
		}
	} //end foreach

	if (empty($error)) {
		registerUser($username, $firstname, $lastname, $email, $password);
		loginUser($username, $password);
	}
}

?>

    <!-- Navigation -->

    <?php include "include/navigation.php";?>


    <!-- Page Content -->
    <div class="container">

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">

                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" autocomplete="on" value="<?php echo
isset($username) ? $username : '' ?>">
                            <p class="bg-danger"><?php echo isset($error['username']) ? $error['username'] : ''; ?></p>
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Frist Name" value="<?php echo
isset($firstname) ? $firstname : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" value="<?php echo
isset($lastname) ? $lastname : '' ?>">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" value="<?php echo
isset($email) ? $email : '' ?>">
                            <p class="bg-danger"><?php echo isset($error['email']) ? $error['email'] : ''; ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <p class="bg-danger"><?php echo isset($error['password']) ? $error['password'] : ''; ?></p>
                        </div>

                        <input type="submit" name="register" id="btn-login" class="btn btn-lg btn-block btn-primary" value="Register">
                    </form>


                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "include/footer.php";?>
