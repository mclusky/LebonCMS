 <?php include 'include/admin_header.php';?>
    <div id="wrapper">



        <!-- Navigation -->
       <?php include 'include/admin_navigation.php';?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    <h1 class="page-header">Welcome to Comments</h1>
           <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>In Response to</th>
                                <th>Approve</th>
                                <th>Reject</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>

<?php
if (isset($_GET['id'])) {

	$post_id = escape($_GET['id']);

	$query = "SELECT * FROM comments WHERE comment_post_id = {$post_id}";
	$comments_query = mysqli_query($connection, $query);

	while ($row = mysqli_fetch_assoc($comments_query)) {
		$comment_id = $row['comment_id'];
		$comment_post_id = $row['comment_post_id'];
		$comment_author = $row['comment_author'];
		$comment_email = $row['comment_email'];
		$comment_date = $row['comment_date'];
		$comment_content = substr($row['comment_content'], 0, 10);
		$comment_status = $row['comment_status'];

		$query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
		$comment_post_response = mysqli_query($connection, $query);

		while ($row = mysqli_fetch_assoc($comment_post_response)) {
			$post_id = $row['post_id'];
			$post_title = $row['post_title'];

			echo "<tr>
                <td>{$comment_id}</td>
                <td>{$comment_author}</td>
                <td>{$comment_date}</td>
                <td>{$comment_content}</td>
                <td>{$comment_email}</td>
                <td>{$comment_status}</td>


                <td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>


                <td><a href='post_comments.php?approve=$comment_id&id=" . $_GET['id'] . "'>Approve</a></td>
                <td><a href='post_comments.php?reject=$comment_id&id=" . $_GET['id'] . "'>Reject</a></td>
                <td><a href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] . "'>Delete</a></td>

            </tr>";
		}
	}
}
?>
                        </tbody>

                    </table>

<?php
// Approve, delete and reject comments

if (isset($_GET['delete'])) {
	$comment_to_delete = escape($_GET['delete']);
	$query = "DELETE FROM comments WHERE comment_id = {$comment_to_delete} ";
	$delete_query = mysqli_query($connection, $query);
	header("Location: post_comments.php?id=" . $_GET['id'] . "");
}

if (isset($_GET['reject'])) {
	$comment_to_reject = escape($_GET['reject']);
	$query = "UPDATE comments SET comment_status = 'Rejected' WHERE comment_id = {$comment_to_reject}";
	$reject_query = mysqli_query($connection, $query);
	header("Location: post_comments.php?id=" . $_GET['id'] . "");
}

if (isset($_GET['approve'])) {
	$comment_to_approve = escape($_GET['approve']);
	$query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = {$comment_to_approve} ";
	$approve_query = mysqli_query($connection, $query);
	header("Location: post_comments.php?id=" . $_GET['id'] . "");
}

?>


                </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include 'include/admin_footer.php';?>