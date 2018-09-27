<?php include 'include/admin_header.php';?>
<header class="admin-header">
    <!-- TOP Navigation -->
   <?php include 'include/admin_top_navigation.php';?>
</header>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-3 p-0 pr-2 pr-lg-0">
            <?php include 'include/admin_side_navigation.php';?>
        </div>
        <div class="col-lg-9 row mt-3">
            <div class="col-12 text-center mb-5">
                <h1 class="page-header">Welcome to Comments
                     <small>
        <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>
                        </small>
                </h1>
            </div>
            <div class="col-12">
                <?php
                	include 'include/view_all_comments.php';
                ?>
            </div>
        </div>
    </div>
</div>
            <!-- /.container-fluid -->

<?php include 'include/admin_footer.php';?>
