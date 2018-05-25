<?php include "include/header.php";?>

<?php

if (isset($_POST['submit'])) {
// use wordwrap() if lines are longer than 70 characters

	$to = 'chrismaryme@yahoo.co.uk';
	$subject = wordwrap(escape($_POST['subject']), 70);
	$msg = escape($_POST['message_body']);
	$clean_msg = str_replace('/r/n', '<br>', $msg);
	$header = "From: " . escape($_POST['email']);

	mail($to, $subject, $clean_msg, $header);

	echo "<h4 class='text-center'>Your message has been sent.</h4>";

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

                <h1>Contact Us</h1>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                         <div class="form-group">
                            <label for="email" class="">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control">
                        </div>
                         <div class="form-group">
                            <label for="message_boy">Message: </label>
                             <textarea name="message_body" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>

                        <input type="submit" name="submit" id="btn-login" class="btn btn-lg btn-block btn-primary" value="Send">
                    </form>


                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "include/footer.php";?>
