
<?php include 'include/admin_header.php';?>

<?php

if (!is_admin($_SESSION['username'])) {
	redirect('index.php');
}

?>
<header class="admin-header">
    <!-- TOP Navigation -->
   <?php include 'include/admin_top_navigation.php';?>
</header>
<!--PAGE CONTAINER-->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12 text-center my-3">
        <h1 class="page-header">Welcome to Users
            <small>
<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>
            </small>
        </h1>
		</div>
		<div class="col-lg-3">
			<!-- SIDE Navigation -->
		   <?php include 'include/admin_side_navigation.php';?>
		</div>
		<div class="col-lg-9">

<?php

if (isset($_GET['source'])) {

$source = escape($_GET['source']);
} else {
$source = '';
}

switch ($source) {
case 'add_user':
include 'include/add_user.php';
break;
case 'edit_user':
include 'include/edit_user.php';
break;

default:
include 'include/view_all_users.php';
break;
}
?>

		</div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php include 'include/admin_footer.php';?>
