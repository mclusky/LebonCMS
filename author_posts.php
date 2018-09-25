<?php include 'include/header.php';?>
    <!-- Navigation -->
   <?php include 'include/navigation.php';?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php

if (isset($_GET['author'])) {

	$author = escape($_GET['author']);

}?>

                <h1 class="page-header mb-3">
                    All Posts by
                    <small><?php echo $author; ?></small>
                </h1>
<?php

$query = "SELECT * FROM posts WHERE post_author = '{$author}' ";
$posts_query = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($posts_query)) {
	$post_title = $row['post_title'];
	$post_id = $row['post_id'];
	$post_date = $row['post_date'];
	$post_image = $row['post_image'];
	$post_content = substr($row['post_content'], 0, 100);

	?>

                <!-- First Blog Post -->
                <h2>
                    <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p><i class="fal fa-clock"></i> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-fluid" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <i class="far fa-chevron-double-right"></i></a>
                <hr>

              <?php }?>

            </div>
            <?php include 'include/sidebar.php';?>
        </div>
        <!-- /.row -->

        <hr>

<?php include 'include/footer.php'?>