<?php include 'include/header.php';?>
    <!-- Navigation -->
   <?php include 'include/navigation.php';?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php

if (isset($_GET['p_id'])) {

	$post_id = escape($_GET['p_id']);

	$view_query = "UPDATE posts SET post_views = post_views + 1 WHERE post_id = $post_id";
	$send_query = mysqli_query($connection, $view_query);
	confirm($send_query);

	// SHOWING ALL POSTS TO ADMIN ONLY //
	if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
		$query = "SELECT * FROM posts WHERE post_id = $post_id ";
		// SHOWING ONLY PUBLISHED POSTS TO EVERYONE ELSE //
	} else {
		$query = "SELECT * FROM posts WHERE post_id = $post_id AND post_status = 'published'";
	}

	$posts_query = mysqli_query($connection, $query);

	if (mysqli_num_rows($posts_query) < 1) {
		echo "<h2 class='text-center bg-info'>There isn't any post available.</h2>";
	} else {

		while ($row = mysqli_fetch_assoc($posts_query)) {
			$post_title = $row['post_title'];
			$post_author = $row['post_author'];
			$post_date = $row['post_date'];
			$post_image = $row['post_image'];
			$post_content = $row['post_content'];

			?>


             <h1 class="page-header">
                    L.A Upholstery
                    <small class='text-muted'>Posts</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <?php echo $post_title; ?>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="<?php echo imagePlaceholder($post_image) ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <hr>

              <?php }

		?>

                <!-- Blog Comments -->
                <?php

		if (isset($_POST['create_comment'])) {
			$post_id = escape($_GET['p_id']);

			$comment_author = $_SESSION['username'];
			$comment_email = $_SESSION['email'];
			$comment_content = escape($_POST['comment_content']);

			if (!empty($comment_content)) {

				$query = "INSERT INTO comments (comment_post_id, comment_date, comment_author, comment_email, comment_content, comment_status) ";
				$query .= "VALUES ($post_id, now(), '{$comment_author}', '{$comment_email}', '{$comment_content}', 'waiting for approval')";

				$comment_query = mysqli_query($connection, $query);

				if (!$comment_query) {
					die("Query Failed : " . mysqli_error($connection));
				}
			} else {
				echo "<script>alert('Fields can not be empty');</script>";
			}
		}

		?>

                <!-- Comments Form -->

                <?php
// Get username for comment author
		if (isset($_SESSION['username'])) {
			$username = $_SESSION['username'];

			?>
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                        <div class="form-group">
                            <label for="comment_author">Posting as</label>
                            <input class="form-control" type="text" name="comment_author" value="<?php echo $username; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Comment :</label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>
                    <?php
} else {
			?>
                <p class="lead">You must be logged in to leave a comment.</p>

    <?php
}
		?>

                <!-- Posted Comments -->

 <?php

		$query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} AND comment_status = 'Approved' ";
		$query .= "ORDER BY comment_id DESC";
		$show_comments = mysqli_query($connection, $query);

		if (!$show_comments) {
			die("Query Failed : " . mysqli_error($connection));
		}

		while ($row = mysqli_fetch_array($show_comments)) {
			$comment_date = $row['comment_date'];
			$comment_author = $row['comment_author'];
			$comment_content = $row['comment_content'];

			?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?></h4>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <p><?php echo $comment_content; ?></p>
                    </div>
                </div>
<?php }
	}} else {
	header("Location: index.php");
}
?>

            </div>
            <?php include 'include/sidebar.php';?>
        </div>
        <!-- /.row -->

        <hr>

<?php include 'include/footer.php'?>