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
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name='submit' class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                </button>
                </span>
            </div>
        </form> <!-- search form -->
        <!-- /.input-group -->
    </div>




    <!-- Login Form -->
<div class="well">

    <?php if (isset($_SESSION['role'])): ?>


    <h4>Logged in as <?php echo $_SESSION['username'] ?></h4>
    <a href="/cms/include/logout.php" class="btn btn-primary">Logout</a>

    <?php else: ?>

    <h4>Login</h4>

    <form method="post" action="">
        <div class="form-group">
            <input name="username" type="text" class="form-control" placeholder="Enter Username">
        </div>

          <div class="input-group">
            <input name="password" type="password" class="form-control" placeholder="Enter Password">
            <span class="input-group-btn">
               <button class="btn btn-primary" name="login" type="submit">Submit
               </button>
            </span>
           </div>
           <div class="form-group text-center">
                <a href="forgot_password.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>
            </div>
    </form>
<?php endif;?>
</div>
        <!-- /.input-group -->



    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
$query = "SELECT * FROM categories";
$categories_query_sidebar = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($categories_query_sidebar)) {
	$cat_title = $row['cat_title'];
	$cat_id = $row['cat_id'];

	echo "<li><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";
}
?>
                </ul>
            </div>

        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
   <?php include 'widget.php';?>

</div>
