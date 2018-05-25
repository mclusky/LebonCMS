
<?php include 'include/admin_header.php';?>
    <div id="wrapper">

        <!-- Navigation -->
       <?php include 'include/admin_navigation.php';?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Welcome to Admin
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->


                <!-- /.row -->

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
<?php
$posts_count = mysqli_num_rows(countDetails('posts'));
echo "<div class='huge'>{$posts_count}</div>";
?>

                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <div class='huge'>
<?php
$comments_count = mysqli_num_rows(countDetails('comments'));
echo "<div class='huge'>{$comments_count}</div>";
?>

                     </div>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <div class='huge'>

<?php
$users_count = mysqli_num_rows(countDetails('users'));
echo "<div class='huge'>{$users_count}</div>";
?>

                    </div>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class='huge'>
<?php
$categories_count = mysqli_num_rows(countDetails('categories'));
echo "<div class='huge'>{$categories_count}</div>";
?>
                        </div>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i>
                    </span>
                    <div class="clearfix"></div>
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
                <div class="row">
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
        <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>

                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include 'include/admin_footer.php';?>