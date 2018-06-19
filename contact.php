<?php include "include/header.php";?>
<?php
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
			$toEmail = 'chrismaryme@yahoo.co.uk';
			$subject = "Contact request from '{$name}'";
			$body = "<h2>Contact Request</h2>
				<h4>Name</h4><p>'{$name}'</p>
				<h4>Email</h4><p>{$email}</p>
				<h4>Message</h4><p>'{$message}'</p>";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: '{$name}' <'{$email}'>" . "\r\n";

			if (mail($toEmail, $subject, $body, $headers)) {
				$msg = "Form Submitted";
				$msgClass = "alert-success";
				redirect('/cms');

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
					<?php if($msg !== ''): ?>
						<div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
					<?php endif; ?>
        		<div class="row">
            			<div class="col-xs-6 col-xs-offset-3">
                			<div class="form-wrap">

               				 	<h1>Contact Us</h1>
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
								<button class="btn btn-info" name="submit" ype="submit" value="Submit">Submit</button>

						</form>
         				</div>
            			</div>
       			 </div>
    		</div>
	</section>


        <hr>
        <?php include "include/footer.php";?>
