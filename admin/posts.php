
<?php include 'include/admin_header.php';?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Navigation -->
               <?php include 'include/admin_top_navigation.php';?>
            </div>
        </div>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12 text-center">
                    <h1 class="page-header">Welcome to Posts
                        <small>
<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>
                        </small>
                    </h1>
                    </div>
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

                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

<?php include 'include/admin_footer.php';?>
