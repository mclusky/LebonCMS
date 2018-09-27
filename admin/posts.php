<?php include 'include/admin_header.php';?>
<header class="admin-header">
    <!-- TOP Navigation -->
   <?php include 'include/admin_top_navigation.php';?>
</header>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">

        <div class="col-lg-3 p-0 pr-2 p-lg-0">
            <!--Side Nav -->
            <?php include 'include/admin_side_navigation.php';?>
        </div>
        <div class="col-lg-9 row mt-3">
            <div class="col-lg-12 text-center my-3">
                <h1 class="page-header">Welcome to Posts
                    <small>
        <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>
                    </small>
                </h1>
            </div>
            <div class="col-12">

<?php

if (isset($_GET['source'])) {

	$source = escape($_GET['source']);
} else {
	$source = '';
}

switch ($source) {
case 'add_post':
	include 'include/add_post.php';
	break;
case 'edit_post':
	include 'include/edit_post.php';
	break;

default:
	include 'include/view_posts.php';
	break;
}

?>
            </div>
        </div>
    </div>
                <!-- /.row -->
</div>
            <!-- /.container-fluid -->

<?php include 'include/admin_footer.php';?>
