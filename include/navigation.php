<?php if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>
    <nav class="navbar navbar-nav navbar-expand-md navbar-dark bg-dark mb-5" role="navigation">
        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="/cms">Lebon CMS</a>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories</a>
                        <div class="dropdown-menu" id="cat-dropdown">


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

	echo "<a class='{$category_class} dropdown-item' href='/cms/category/{$cat_id}'>{$cat_title}</a>";
}

?>
    </div>
</li>
<?php
if (!isLoggedIn()): ?>

                    <li class="nav-item">
                        <a class="nav-link" href='/cms/login'>Login</a>
                    </li>
                    <li class='<?php echo $registration_class; ?> nav-item'><a class="nav-link" href="/cms/registration">Registration</a></li>
<?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href='/cms/admin'>Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href='/cms/include/logout.php'>Logout</a>
                    </li>
<?php endif;?>


                    <li class="nav-item"><a class="nav-link" href="/cms/contact">Contact</a></li>
<?php
if (isset($_SESSION['role'])) {
	if (isset($_GET['p_id'])) {
		$the_post_id = escape($_GET['p_id']);
		echo "<li lass='nav-item'><a class='nav-link' href='/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
	}
}
?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
