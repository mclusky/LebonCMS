<?php include 'include/header.php';?>
    <!-- Navigation -->
   <?php include 'include/navigation.php';?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

if (isset($_GET['category'])) {
	$cat_id = escape($_GET['category']);

// SHOWING ALL POSTS ONLY TO ADMIN //
	if ($_SESSION && is_admin($_SESSION['username'])) {

		$stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");

		// SHOWING ONLY PUBLISHED POSTS TO EVERYONE ELSE //
	} else {
		$stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ? ");

		$published = 'published';
	}

	// PREPARED STATEMENTS //
	if (isset($stmt1)) {

		mysqli_stmt_bind_param($stmt1, "i", $cat_id);

		mysqli_stmt_execute($stmt1);

		mysqli_stmt_store_result($stmt1);

		mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

		$stmt = $stmt1;

	} else {

		mysqli_stmt_bind_param($stmt2, "is", $cat_id, $published);

		mysqli_stmt_execute($stmt2);

		mysqli_stmt_store_result($stmt2);

		mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

		$stmt = $stmt2;
	}

	//GET CATEGORY NAME
	$statement = mysqli_prepare($connection, "SELECT cat_title FROM categories WHERE cat_id = ?");
	mysqli_stmt_bind_param($statement, "i", $cat_id);

	mysqli_stmt_execute($statement);

	mysqli_stmt_store_result($statement);

	mysqli_stmt_bind_result($statement, $cat_title);

	mysqli_stmt_fetch($statement);

	if (mysqli_stmt_num_rows($stmt) === 0) {
		echo "<h2 class='text-center'>There isn't any post available for that category.</h2><hr>";
		echo "<a href='/cms/index' class='btn btn-outline-info'><i class='fal fa-hand-point-left'></i> Home Page</a>";
	} else {
		?>
		<h1>Showing posts for category : <?php echo $cat_title; ?></h1>

	<?php mysqli_stmt_close($statement);
	}

	while (mysqli_stmt_fetch($stmt)):

	?>



                <!-- First Blog Post -->
                <h2>
                    <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="/cms/author/<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                </p>
                <p> <i class="fal fa-clock"></i> <?php echo $post_date; ?></p>
                <hr>
                <a href="/cms/post/<?php echo $post_id; ?>"><img class="img-fluid" src="/cms/images/<?php echo $post_image; ?>" alt=""></a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <i class="far fa-chevron-double-right"></i></a>

                <hr>

    <?php endwhile;
	// CLOSE PREPARED STEMENTS //
	mysqli_stmt_close($stmt);

} else {
	redirect('index.php');
}
?>


            </div>
            <?php include 'include/sidebar.php';?>
        </div>
        <!-- /.row -->

        <hr>

<?php include 'include/footer.php'?>