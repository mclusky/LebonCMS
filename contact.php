
<?php use PHPMailer\PHPMailer\Exception;?>
<?php use PHPMailer\PHPMailer\PHPMailer;?>
<?php require "./vendor/autoload.php";?>
<?php include "include/header.php";?>
<?php
// **************** SET UP .ENV AND PUSHER *******************//
$dotenv = $dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$options = array(
	'cluster' => 'eu',
	'encrypted' => true,
);
$pusher = new Pusher\Pusher(getenv('APP_KEY'), getenv('APP_SECRET'), getenv('APP_ID'), $options);
// ************************************************************//

$msg = '';
$msgClass = '';

if (filter_has_var(INPUT_POST, 'submit')) {
	$name = htmlspecialchars($_POST['name']);
	$email = htmlspecialchars($_POST['email']);
	$message = htmlspecialchars($_POST['message']);

	if (!empty($email) && !empty($name) && !empty($message)) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			$msg = "Please use a valid email.";
			$msgClass = 'alert-danger';
		} else {
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

			$mail->setFrom('chris@gmail.com', $name);
			$mail->addAddress($email);
			$mail->Subject = 'Contact from CMS';
			$mail->Body = $message;

			if ($mail->send()) {
				$emailSent = true;
				$msg = "Your form was submitted";
				$msgClass = "alert-success";
				$data['message'] = $name;
				$pusher->trigger('contacted', 'new_message', $data);

			} else {
				$msg = "Your form was not submitted";
				$msgClass = "alert-danger";
			}
		}

	} else {
		$msg = "Please fill in all fields.";
		$msgClass = 'alert-danger';
	}
}

?>
    <?php include "include/navigation.php";?>

	<section id="login">
    		<div class="container">
					<?php if ($msg !== ''): ?>
						<div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
					<?php endif;?>
        		<div class="row">
            			<div class="col-12">
               			<h1 class="text-center">Contact Us</h1>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="m-3 p-5">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" class="form-control" name="name" value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
							</div>
							<div class="form-group">
								<label for="">Email</label>
								<input type="email" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
							</div>
							<div class="form-group">
								<label for="message">Message</label>
								<textarea name="message" id="" cols="30" rows="10" class="form-control" ><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
								</div>
								<button class="btn btn-info btn-block" name="submit" ype="submit" value="Submit">Submit</button>

						</form>
            			</div>
       			 </div>
    		</div>
	</section>


        <hr>
        <?php include "include/footer.php";?>
