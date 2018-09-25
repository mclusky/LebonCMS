<?php use PHPMailer\PHPMailer\Exception;?>
<?php use PHPMailer\PHPMailer\PHPMailer;?>
<?php require "./vendor/autoload.php";?>
<?php include "include/header.php";?>
<?php

if (!ifIsMethod('get') && !isset($_GET['forgot'])) {
	redirect('index');
}

$emailSent = '';

if (ifIsMethod('post')) {

	if (isset($_POST['recover-submit'])) {

		$email = escape($_POST['email']);
		$len = 50;
		$token = bin2hex(openssl_random_pseudo_bytes($len));

		if (emailExists($email)) {
			$query = "UPDATE users SET token = '{$token}' WHERE user_email = ? ";

			if ($stmt = mysqli_prepare($connection, $query)) {
				mysqli_stmt_bind_param($stmt, "s", $email);

				mysqli_stmt_execute($stmt);

				mysqli_stmt_close($stmt);

				// **********************************************************//
				// ************* CONFIGURE PHPMAILER *************************//
				// **********************************************************//
				$mail = new PHPMailer();

				//Server settings
				$mail->isSMTP();
				$mail->Host = Config::SMTP_HOST;
				$mail->SMTPAuth = true;
				$mail->Username = Config::SMTP_USER;
				$mail->Password = Config::SMTP_PASSWORD;
				$mail->SMTPSecure = 'tls';
				$mail->Port = Config::SMTP_PORT;
				$mail->isHTML(true);
				$mail->CharSet = 'UTF-8';

				$mail->setFrom('chris@gmail.com', 'Chris Lebon CMS');
				$mail->addAddress($email);
				$mail->Subject = 'Password Reset.';
				$mail->Body = "<h3>Please click on the link to reset your password.</h3>
					<a href='http://localhost/cms/reset_password.php?email={$email}&token={$token}'>Reset</a>";

				if ($mail->send()) {
					$emailSent = true;

				} else {
					echo "Failed to send email.";
				}
			}

		}

	}

}

?>

<!-- Page Content -->
<div class="container">

	<?php if (!($emailSent)): ?>
        <div class="row text-center">
            <div class="col-lg-6 mx-lg-auto">
                <div class="card">
                    <div class="card-body">
                       <div class="card-header text-center ">
                       		<h3><i class="fa fa-lock fa-4x"></i></h3>
                        	<h2 class="card-title">Forgot Password?</h2>
                        	<p>You can reset your password here.</p>
                       </div>
                        <form id="register-form" role="form" autocomplete="off" class="form" method="post" action="">
                                <div class="form-group">
                                    <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
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
        <?php else: ?>
        <div class="row">
	        <div class="col text-center">
	        	<div class="card card-body">
					<h2 class="card-title">A link to reset your password has been sent.</h2>
					<a href="/cms"><i class="fa fa-home"></i> Home Page</a>
	        	</div>
	     	</div>
        </div>

		<?php endif;?>

    <hr>

    <?php include "include/footer.php";?>

</div> <!-- /.container -->
