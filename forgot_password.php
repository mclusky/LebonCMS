<?php include "include/header.php";?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
require "./vendor/autoload.php";
?>
<?php require "./classes/config.php";?>
<?php

$mail = new PHPMailer();

if (!ifIsMethod('get') && !isset($_GET['forgot'])) {
	redirect('index');
}

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

				$mail->setFrom('chrischatou@gmail.com', 'Chris Lebon');
				$mail->addAddress($email);
				$mail->Subject = 'This is a test.';
				$mail->Body = 'Body of email.';

				if ($mail->send()) {
					echo "Success!";
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

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "include/footer.php";?>

</div> <!-- /.container -->

