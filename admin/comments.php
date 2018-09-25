<?php include 'include/admin_header.php';?>
<header class="admin-header">
    <!-- TOP Navigation -->
   <?php include 'include/admin_top_navigation.php';?>
</header>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row my-3">
        <div class="col-lg-12 text-center">
        <h1 class="page-header">Welcome to Comments
             <small>
<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>
                </small>
        </h1>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-xl-2">
            <?php include 'include/admin_side_navigation.php';?>
        </div>
        <div class="col-xl-10">
            <?php
            	include 'include/view_all_comments.php';
            ?>
        </div>
    </div>
</div>
            <!-- /.container-fluid -->

<?php include 'include/admin_footer.php';?>
