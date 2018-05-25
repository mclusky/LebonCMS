
<?php include 'include/admin_header.php';?>
    <div id="wrapper">



        <!-- Navigation -->
       <?php include 'include/admin_navigation.php';?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    <h1 class="page-header">Welcome to Comments
                         <small>
<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>
                            </small>
                    </h1>

<?php

if (isset($_GET['source'])) {

	$source = escape($_GET['source']);
} else {
	$source = '';
}

switch ($source) {
case 'add_post':
	include 'include/add_comm.php';
	break;
case 'edit_post':
	include 'include/edit_post.php';
	break;

default:
	include 'include/view_all_comments.php';
	break;
}

?>








                </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include 'include/admin_footer.php';?>