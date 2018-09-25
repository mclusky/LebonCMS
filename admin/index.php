
<?php include 'include/admin_header.php';?>
<header class="admin-header">
    <!-- TOP Navigation -->
   <?php include 'include/admin_top_navigation.php';?>
</header>
<!--PAGE CONTAINER-->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row p-3">
        <div class="col-lg-12">
            <h1 class="page-header text-center">
               Welcome to Admin
                <small><?php echo $_SESSION['username']; ?></small>
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3">
            <!-- Side Navigation -->
           <?php include 'include/admin_side_navigation.php';?>
        </div>
        <div class="col-lg-9">
<div class="container-fluid">
    <div class="row p-3">
        <div class="col-xl-3 col-md-6">
            <div class="card border-primary">
                <div class="card-header text-white bg-primary">
                    <div class="row">
                        <div class="col-3">
                            <i class="far fa-file-alt fa-4x"></i></i>
                        </div>
                        <div class="col-9 text-right">
    <?php
    $posts_count = mysqli_num_rows(countDetails('posts'));
    echo "<div class='huge'>{$posts_count}</div>";
    ?>

                            <div>Posts</div>
                        </div>
                    </div>
                </div>
                <a href="posts.php">
                    <div class="card-footer text-primary clearfix">
                        <span class="float-left">View Details</span>
                        <span class="float-right"><i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>


        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-success">
                <div class="card-header text-white bg-success">
                    <div class="row">
                        <div class="col-3">
                            <i class="far fa-comments fa-4x"></i>
                        </div>
                        <div class="col-9 text-right">
    <?php
    $comments_count = mysqli_num_rows(countDetails('comments'));
    echo "<div class='huge'>{$comments_count}</div>";
    ?>

                          <div>Comments</div>
                        </div>
                    </div>
                </div>
                <a href="comments.php">
                    <div class="card-footer clearfix text-success">
                        <span class="float-left">View Details</span>
                        <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-warning">
                <div class="card-header text-white bg-warning">
                    <div class="row">
                        <div class="col-3">
                            <i class="far fa-user fa-4x"></i>
                        </div>
                        <div class="col-9 text-right">
    <?php
    $users_count = mysqli_num_rows(countDetails('users'));
    echo "<div class='huge'>{$users_count}</div>";
    ?>

                            <div> Users</div>
                        </div>
                    </div>
                </div>
                <a href="users.php">
                    <div class="card-footer clearfix text-warning">
                        <span class="float-left">View Details</span>
                        <span class="float-right"><i class="fa fa-arrow-circle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-danger">
                <div class="card-header text-white bg-danger">
                    <div class="row">
                        <div class="col-3">
                            <i class="far fa-list fa-4x"></i>
                        </div>
                        <div class="col-9 text-right">
    <?php
    $categories_count = mysqli_num_rows(countDetails('categories'));
    echo "<div class='huge'>{$categories_count}</div>";
    ?>
                             <div>Categories</div>
                        </div>
                    </div>
                </div>
                <a href="categories.php">
                    <div class="card-footer text-danger clearfix">
                        <span class="float-left">View Details</span>
                        <span class="float-right"><i class="fa fa-arrow-circle-right"></i>
                        </span>
                    </div>
                </a>
            </div>
    </div>
</div>
                <!-- /.row -->


<?php
// ******GETTING DATA FOR GRAPHS***** //
$published_posts = getTableData('posts', 'post_status', 'published');

$draft_posts = getTableData('posts', 'post_status', 'draft');

$waiting_comments = getTableData('comments', 'comment_status', 'waiting for approval');

$subscribers = getTableData('users', 'user_role', 'subscriber');

?>
                <div class="row mt-3">
                    <div class="col-12">
                <script type="text/javascript">

                google.charts.load('current', { 'packages': ['bar'] });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    const data = google.visualization.arrayToDataTable([
                        ['Data', 'Count'],


<?php

$elements_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Pending Comments', 'Users', 'Subscribers', 'Categories'];

$elements_count = [$posts_count, $published_posts, $draft_posts, $comments_count, $waiting_comments, $users_count, $subscribers, $categories_count];

$len = count($elements_count);
for ($i = 0; $i < $len; $i++) {
	echo "['{$elements_text[$i]}'" . ", " . "{$elements_count[$i]}],";
}

?>



                    ]);

                    const options = {
                        chart: {
                            title: '',
                            subtitle: '',
                        }
                    };

                    const chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                    chart.draw(data, google.charts.Bar.convertOptions(options));
                }
                </script>
        <div id="columnchart_material" class="p-3 mx-auto" style="height: 500px;"></div>

                </div>
                </div>
            </div>
        </div>
            <!-- /.container-fluid -->
    </div><!-- END ROW -->
</div><!--END PAGE CONATINER-->

<?php include 'include/admin_footer.php';?>
