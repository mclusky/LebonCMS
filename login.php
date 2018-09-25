<?php include "include/header.php";?>


<?php

userLoggedInRedirect('/cms/admin');

if (ifIsMethod('post')) {
	if (isset($_POST['username']) && isset($_POST['password'])) {
		loginUser($_POST['username'], $_POST['password']);
	} else {
		redirect('/cms/login');
	}
}

?>

<!-- Navigation -->

<?php include "include/navigation.php";?>


<!-- Page Content -->
<div class="container">
	<div class="row">
		<div class="col-lg-6 mx-lg-auto">
			<div class="card">
				<div class="card-body">
					<div class="card-header text-center">
						<h3><i class="fa fa-user fa-4x"></i></h3>
						<h2 >Login</h2>
					</div>
					<form id="login-form" role="form" autocomplete="off" class="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class="form-group">
							<div class="input-group">
								<input name="username" type="text" class="form-control" placeholder="Enter Username">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<input name="password" type="password" class="form-control" placeholder="Enter Password">
							</div>
						</div>
						<div class="form-group">
							<input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<hr>

	<?php include "include/footer.php";?>

</div> <!-- /.container -->
