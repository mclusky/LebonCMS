<?php
if (ifIsMethod('post')) {

	if (isset($_POST['login'])) {

		if (isset($_POST['username']) && isset($_POST['password'])) {

			loginUser($_POST['username'], $_POST['password']);
		} else {

			redirect('index');
		}
	}
}

?>

<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="card card-body">
        <h4 class="card-title">Blog Search</h4>
        <form action="search.php" method="post" class="form-inline">
            <div class="form-group">
                <input name="search" type="text" class="form-control mr-sm-2">
                <button name='submit' class="btn btn-primary " type="submit">
                    <i class="fal fa-search"></i>
                </button>
            </div>
        </form> <!-- search form -->
        <!-- /.input-group -->
    </div>




    <!-- Login Form -->
<div class="card card-body mt-2">

    <?php if (isset($_SESSION['role'])): ?>


    <h4 class="card-title">Logged in as <?php echo $_SESSION['username'] ?></h4>
    <a href="/cms/include/logout.php" class="btn btn-outline-primary">Logout</a>

    <?php else: ?>

    <h4 class="card-title">Login</h4>

    <form method="post" action="">
        <div class="form-group">
            <input name="username" type="text" class="form-control" placeholder="Enter Username">
        </div>

          <div class="input-group">
            <input name="password" type="password" class="form-control" placeholder="Enter Password">
            <button class="btn btn-primary" name="login" type="submit">Submit
            </button>
           </div>
           <div class="form-group text-center mt-2">
                <a href="forgot_password.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>
            </div>
    </form>
<?php endif;?>
</div>
        <!-- /.input-group -->



    <!-- Blog Categories Well -->
    <div class="card card-body mt-2">
        <h4 class="card-title">Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <div class="list-group">
                    <?php
$query = "SELECT * FROM categories";
$categories_query_sidebar = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($categories_query_sidebar)) {
	$cat_title = $row['cat_title'];
	$cat_id = $row['cat_id'];

	echo "<a class='list-group-item list-group-item-action list-group-item-light' href='/cms/category/{$cat_id}'>{$cat_title}</a>";
}
?>
                </div>
            </div>

        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
   <?php include 'widget.php';?>

</div>
