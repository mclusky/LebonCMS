<?php include 'include/header.php';?>
    <!-- Navigation -->
   <?php include 'include/navigation.php';?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php

if (isset($_GET['page'])) {
	$page = escape($_GET['page']);
} else {
	$page = '';
}

if ($page === '' || $page === 1) {
	$page_1 = 0;
} else {
	$page_1 = ($page * 5) - 5;
}

// SHOWING ALL POSTS ONLY TO ADMIN //
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
	$post_query_count = "SELECT * FROM posts";
	$query_display = "SELECT * FROM posts LIMIT $page_1, 5";
	// SHOWING ONLY PUBLISHED POSTS TO EVERYONE ELSE //
} else {
	$query_display = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $page_1, 5";
	$post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
}

$get_count = mysqli_query($connection, $post_query_count);
$count = mysqli_num_rows($get_count);

if ($count < 1) {
	echo "<h2 class='text-center bg-info'>No Published Post Yet</h2>";

} else {
	$count = ceil($count / 5);

	$posts_query = mysqli_query($connection, $query_display);

	while ($row = mysqli_fetch_assoc($posts_query)) {
		$post_id = $row['post_id'];
		$post_title = $row['post_title'];
		$post_author = $row['post_author'];
		$post_date = $row['post_date'];
		$post_image = $row['post_image'];
		$post_content = substr($row['post_content'], 0, 100);
		$post_status = $row['post_status'];

		?>


                <!-- First Blog Post -->
                <h2>
                    <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author/<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><i class="fal fa-clock"></i> <?php echo $post_date; ?></p>
                <hr>
                <a href="post/<?php echo $post_id; ?>"><img class="img-fluid" src="<?php echo imagePlaceholder($post_image); ?>" alt=""></a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post/<?php echo $post_id; ?>">Read More <i class="far fa-chevron-double-right"></i></a>

                <hr>

              <?php }}?>


            </div>
            <?php include 'include/sidebar.php';?>
        </div>
        <!-- /.row -->

        <hr>

        <nav class="navbar">
            <ul class="list-inline">
                <?php

for ($i = 1; $i <= $count; $i++) {
	if ($i == $page) {
		echo "<li class='list-inline-item mr-3'><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
	} else {
		echo "<li class='list-inline-item mr-3'><a href='index.php?page={$i}'>{$i}</a></li>";
	}
}

?>
            </ul>
        </nav>

<?php include 'include/footer.php'?>
