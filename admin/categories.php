
<?php include 'include/admin_header.php';?>
    <div id="wrapper">



        <!-- Navigation -->
       <?php include 'include/admin_navigation.php';?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Welcome to Categories
                            <small>
<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>
                             </small>
                        </h1>
                        <div class="col-sm-6">
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
                        <div class="col-sm-6">
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
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include 'include/admin_footer.php';?>