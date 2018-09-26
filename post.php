<?php include 'include/header.php';?>
    <!-- Navigation -->
   <?php include 'include/navigation.php';?>

    <?php
//******************************//
// SELECT AND UPDATE POST LIKES //
//******************************//
if (isset($_POST['liked'])) {

	$post_id = $_POST['post_id'];
	$user_id = $_POST['user_id'];

	$query = "SELECT * FROM posts WHERE post_id = $post_id";
	$queryPost = mysqli_query($connection, $query);
	confirm($queryPost);
	$post = mysqli_fetch_array($queryPost);
	$likes = $post['likes'];

	$query = "UPDATE posts SET likes = $likes+1 WHERE post_id = $post_id";
	$queryLikes = mysqli_query($connection, $query);
	confirm($queryLikes);

	$query = "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)";
	$createLikes = mysqli_query($connection, $query);
	confirm($createLikes);

	exit();
}
//**********************************************//
// SELECT AND UPDATE POST UNLIKES/ DELETE LIKES//
//*********************************************//
if (isset($_POST['unliked'])) {

	$post_id = $_POST['post_id'];
	$user_id = $_POST['user_id'];

	$query = "SELECT * FROM posts WHERE post_id = $post_id";
	$queryPost = mysqli_query($connection, $query);
	confirm($queryPost);
	$post = mysqli_fetch_array($queryPost);
	$likes = $post['likes'];

	$query = "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id";
	$deleteLikes = mysqli_query($connection, $query);
	confirm($deleteLikes);

	$query = "UPDATE posts SET likes = $likes-1 WHERE post_id = $post_id";
	$queryLikes = mysqli_query($connection, $query);
	confirm($queryLikes);

	exit();
}
?>


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
                   Lebon CMS
                    <small class='text-muted'>smart and lightweight</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <?php echo $post_title; ?>
                </h2>
                <p class="lead">
                    by <a href="/cms/author/<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><i class="fal fa-clock"></i> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-fluid" src="<?php echo imagePlaceholder($post_image) ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <hr>
                <?php if (isLoggedIn()) {?>
                    <div class="row">
                        <div class="col-12">
                            <p id="likes">
                                <a href="post/<?php echo $post_id; ?>" class="<?php echo likedByUser($post_id) ? 'unlike' : 'like' ;?>" data-toggle='tooltip' data-placement='top' title="<?php echo likedByUser($post_id) ? 'You liked this' : 'Like it' ;?>">
                                    <i class="<?php echo likedByUser($post_id) ? 'fal fa-thumbs-down' : 'fal fa-thumbs-up'; ?>">
                                    </i>
                                    <?php echo likedByUser($post_id) ? 'Unlike' : 'Like' ;?>
                                </a>
                            </p>
                        </div>
                    </div>
                <?php }?>
                <div class="row">
                    <div class="col-12">
                         <p>Likes: <?php getLikes($post_id);?></p>
                    </div>
                </div>

            <?php }?>
                <!-- Blog Comments -->
            <?php

		if (isset($_POST['create_comment'])) {
			$post_id = escape($_GET['p_id']);

			$comment_author = $_SESSION['username'];
			$comment_email = $_SESSION['email'];
			$comment_content = escape($_POST['comment_content']);
			$comment_post_author = $post_author;

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
                <div class="card card-body">
                    <h4 class="card-title">Leave a Comment:</h4>
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
                <p class="lead">You must <a href="/cms/login">Login</a> to leave a comment or to like this post.</p>

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
                <div class="media clearfix">
                    <a class="float-left" href="#">
                        <img class="media-object img-fluid mr-2" src="http://placehold.it/64x64" alt="">
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

<script>
    $(document).ready(() => {

    $("[data-toggle='tooltip']").tooltip();

    $('#likes a.like').on('click', function(e) {
        const post_id = <?php echo $post_id; ?>;
        const user_id = <?php echo loggedInUserId(); ?>;
        $.ajax({
            url: '/cms/post.php?p_id=<?php echo $post_id; ?>',
            type: 'post',
            data: {
                liked: 1,
                post_id: post_id,
                user_id: user_id
            }
        });
    });

    $('#likes a.unlike').on('click', function(e) {
        const post_id = <?php echo $post_id; ?>;
        const user_id = <?php echo loggedInUserId(); ?>;
        $.ajax({
            url: '/cms/post.php?p_id=<?php echo $post_id; ?>',
            type: 'post',
            data: {
                unliked: 1,
                post_id: post_id,
                user_id: user_id
            }
        });
    });
});
</script>
