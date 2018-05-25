  <?php

include 'delete_modal.php';

if (isset($_POST['checkboxArray'])) {

	forEach ($_POST['checkboxArray'] as $value) {
		$bulk_options = $_POST['bulk_options'];
		switch ($bulk_options) {
		case 'published':
			confirm(updateStatus($bulk_options, $value));
			break;
		case 'draft':
			confirm(updateStatus($bulk_options, $value));
			break;
		case 'delete':
			$query = "DELETE FROM posts WHERE post_id = {$value} ";
			$delete_post = mysqli_query($connection, $query);
			confirm($delete_post);
			break;
		case 'clone':

			$query = "SELECT * FROM posts WHERE post_id = {$value} ";
			$select_clone_post = mysqli_query($connection, $query);
			confirm($select_clone_post);

			while ($row = mysqli_fetch_array($select_clone_post)) {
				$post_title = $row['post_title'];
				$post_category_id = $row['post_category_id'];
				$post_author = $row['post_author'];
				$post_date = $row['post_date'];
				$post_image = $row['post_image'];
				$post_tags = $row['post_tags'];
				$post_content = $row['post_content'];
				$post_status = $row['post_status'];
			}

			$query = "INSERT INTO posts(post_title, post_category_id, post_author, post_date, post_image, post_tags, post_content, post_status) ";
			$query .= "VALUES ('{$post_title}', {$post_category_id}, '{$post_author}', '{$post_date}', '{$post_image}', '{$post_tags}', '{$post_content}', '{$post_status}')";

			$clone_post = mysqli_query($connection, $query);
			confirm($clone_post);

			break;
		}
	}

}
?>


<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div class="row form-group">
            <div id="bulkOptionsContainer" class="col-sm-4">
                <select name="bulk_options" id="" class="form-control">
                    <option value="">Select Options</option>
                    <option value="published">Publish</option>
                    <option value="draft">Draft</option>
                    <option value="delete">Delete</option>
                    <option value="clone">Clone</option>
                </select>
            </div>
            <div class="col-sm-4">
                <input type="submit" name="submit" value="Apply" class="btn btn-success">
                <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
            </div>
        </div>
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllBoxes"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Date</th>
                <th>Comments</th>
                <th>Views</th>
            </tr>
        </thead>
        <tbody>

<?php

// $query = "SELECT * FROM posts ORDER BY post_id DESC";
$query = "SELECT posts.post_title, posts.post_id, posts.post_category_id, posts.post_author, posts.post_date, ";
$query .= "posts.post_image, posts.post_tags, posts.post_content, posts.post_status, posts.post_comment_count, posts.post_views, ";
$query .= "categories.cat_id, categories.cat_title FROM posts LEFT JOIN ";
$query .= "categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";

$posts_query = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($posts_query)) {
	$post_title = $row['post_title'];
	$post_id = $row['post_id'];
	$post_category_id = $row['post_category_id'];
	$post_author = $row['post_author'];
	$post_date = $row['post_date'];
	$post_image = $row['post_image'];
	$post_tags = $row['post_tags'];
	$post_content = $row['post_content'];
	$post_status = $row['post_status'];
	$post_comment_count = $row['post_comment_count'];
	$post_views = $row['post_views'];
	$cat_title = $row['cat_title'];
	$cat_id = $row['cat_id'];

	$query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
	$query_comments = mysqli_query($connection, $query);
	$comment_count = mysqli_num_rows($query_comments);

	echo "<tr>
        <td><input type='checkbox' class='checkboxes' name='checkboxArray[]' value='{$post_id}'></td>
        <td>{$post_id}</td>
        <td>{$post_author}</td>
        <td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>
        <td>{$cat_title}</td>
        <td>{$post_status}</td>
        <td class='post-img'><img class='img-responsive img-thumbnail' src='../images/$post_image' alt=''</td>
        <td>{$post_tags}</td>
        <td>{$post_date}</td>

        <td><a href='post_comments.php?id={$post_id}'>{$comment_count}</a></td>

        <td>{$post_views}</td>
        <td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
	?>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
		<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
		<?php
echo "<td><input type='submit' value='Delete' class='btn btn-danger' name='delete'></td>";

	?>
	</form>

        <?php

	echo "</tr>";

}

?>
        </tbody>
    </table>
</form>

<?php

if (isset($_POST['delete'])) {
	$post_to_delete = escape($_POST['post_id']);
	$query = "DELETE FROM posts WHERE post_id = {$post_to_delete} ";
	$delete_query = mysqli_query($connection, $query);
	redirect('/cms/admin/posts.php');
}

?>
