<?php if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms">Lebon CMS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown" id="cat-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories <span class="caret"></span></a>
                        <ul class="dropdown-menu">


<?php

$query = "SELECT * FROM categories";
$categories_query = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($categories_query)) {
	$cat_title = $row['cat_title'];
	$cat_id = $row['cat_id'];

	$category_class = '';
	$registration_class = '';
	$registration = 'registration.php';

	$page_name = basename($_SERVER['PHP_SELF']);

	if (isset($_GET['category']) && $_GET['category'] === $cat_id) {
		$category_class = 'active';
	} elseif ($page_name === $registration) {
		$registration_class = 'active';
	}

	echo "<li class='{$category_class}'><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";
}

?>
    </ul>
</li>
<?php
if (!isLoggedIn()): ?>

                    <li>
                        <a href='/cms/login'>Login</a>
                    </li>
<?php else: ?>
                    <li>
                        <a href='/cms/admin'>Admin</a>
                    </li>
                    <li>
                        <a href='/cms/logout.php'>Logout</a>
                    </li>
<?php endif;?>

                    <li class='<?php echo $registration_class; ?>'><a href="/cms/registration">Registration</a></li>
                    <li><a href="/cms/contact.php">Contact</a></li>
<?php
if (isset($_SESSION['role'])) {
	if (isset($_GET['p_id'])) {
		$the_post_id = escape($_GET['p_id']);
		echo "<li><a href='/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
	}
}
?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>