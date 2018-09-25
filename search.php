<?php include 'include/header.php';?>
    <!-- Navigation -->
   <?php include 'include/navigation.php';?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">



                <?php

if (isset($_POST['submit'])) {
	$search = escape($_POST['search']);
	$query = "SELECT * FROM posts WHERE post_tags LIKE '%$search' ";
	$search_query = mysqli_query($connection, $query);

	if (!$search_query) {
		die("Query failed" . mysqli_error($connection));
	}

	$count = mysqli_num_rows($search_query);

	if ($count === 0) {
		echo "<h1>NO RESULT</h1>";
	} else {
		?>
        <h1>Showing results for : <?php echo $search; ?></h1>

		<?php
while ($row = mysqli_fetch_assoc($search_query)) {
			$post_title = $row['post_title'];
			$post_author = $row['post_author'];
			$post_date = $row['post_date'];
			$post_image = $row['post_image'];
			$post_content = $row['post_content'];
			$post_id = $row['post_id'];

			?>

                <!-- First Blog Post -->
                <h2>
                    <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="/cms/author/<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><i class="fal fa-clock"></i> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-fluid" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="#">Read More <i class="far fa-chevron-double-right"></i></a>

                <hr>

              <?php }

	}
}
?>

            </div>
            <?php include 'include/sidebar.php';?>
        </div>
        <!-- /.row -->

        <hr>

<?php include 'include/footer.php';?>