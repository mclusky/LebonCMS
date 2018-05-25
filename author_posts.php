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

}

$query = "SELECT * FROM posts WHERE post_author = '{$author}' ";
$posts_query = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($posts_query)) {
	$post_title = $row['post_title'];
	$post_id = $row['post_id'];
	$post_date = $row['post_date'];
	$post_image = $row['post_image'];
	$post_content = substr($row['post_content'], 0, 100);

	?>


            <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <?php echo $author; ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>

              <?php }?>

            </div>
            <?php include 'include/sidebar.php';?>
        </div>
        <!-- /.row -->

        <hr>

<?php include 'include/footer.php'?>