<?php include 'include/admin_header.php';?>
<header class="admin-header">
    <!-- TOP Navigation -->
   <?php include 'include/admin_top_navigation.php';?>
</header>
<!--PAGE CONTAINER-->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-3 p-0 pr-lg-2 pr-0">
            <?php include 'include/admin_side_navigation.php'; ?>
        </div>
        <div class="col-lg-9 row mt-3">
            <div class="col-12 text-center mb-5">
                <h1 class="page-header">
                   Welcome to Categories
                    <small>
    <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>
                     </small>
                </h1>
            </div>




            <div class="col-lg-6">
<?php insertCategories();?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="cat_title">Category Title</label>
                    <input class="form-control" type="text" name="cat_title">
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                </div>

            </form>

<?php
if (isset($_GET['update'])) {
$cat_id = escape($_GET['update']);
include 'include/update_categories.php';
}

?>
        </div><!-- Category form -->
        <div class="col-lg-6">
            <div class="table-responsive">
                <table class='table table-bordered table-hover'>
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Category Title</th>
                        </tr>
                    </thead>
                    <tbody>

<?php populateCategories();?>
<?php deleteCategories();?>

                    </tbody>
            </table>
            </div>
        </div>

                <!-- /.row -->

        </div>
    </div>
</div>    <!-- /.container-fluid -->



<?php include 'include/admin_footer.php';?>
