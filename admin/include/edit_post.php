<?php

if (isset($_GET['p_id'])) {

	$post_edit_id = escape($_GET['p_id']);
}

$query = "SELECT * FROM posts WHERE post_id = $post_edit_id ";
$select_post_by_id = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_post_by_id)) {
	$post_title = $row['post_title'];
	$post_category_id = $row['post_category_id'];
	$post_author = $row['post_author'];
	$post_date = $row['post_date'];
	$post_image = $row['post_image'];
	$post_tags = $row['post_tags'];
	$post_content = $row['post_content'];
	$post_status = $row['post_status'];
	$post_comment_count = $row['post_comment_count'];
	$post_views = $row['post_views'];

}

if (isset($_POST['update_post'])) {
	$post_category_id = escape($_POST['post_category']);
	$post_title = escape($_POST['post_title']);
	$post_image = escape($_FILES['post_image']['name']);
	$post_image_temp = escape($_FILES['post_image']['tmp_name']);
	$post_tags = escape($_POST['post_tags']);
	$post_content = escape($_POST['post_content']);
	$post_status = escape($_POST['post_status']);

	move_uploaded_file($post_image_temp, "../images/$post_image");

	if (empty($post_image)) {
		$query = "SELECT * FROM posts WHERE post_id = $post_edit_id ";
		$select_image = mysqli_query($connection, $query);

		while ($row = mysqli_fetch_array($select_image)) {
			$post_image = $row['post_image'];
		}
	}

	$query = "UPDATE posts SET ";
	$query .= "post_title = '{$post_title}', ";
	$query .= "post_category_id = '{$post_category_id}', ";
	$query .= "post_date = now(), ";
	$query .= "post_status = '{$post_status}', ";
	$query .= "post_tags = '{$post_tags}', ";
	$query .= "post_content = '{$post_content}', ";
	$query .= "post_image = '{$post_image}' ";
	$query .= "WHERE post_id = $post_edit_id";

	$update_post = mysqli_query($connection, $query);

	confirm($update_post);

	echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$post_edit_id}'>View Post</a> or <a href='posts.php'>Back to Posts</a></p>";

}

if (isset($_POST['reset_views'])) {
	$query = "UPDATE posts SET post_views = 0 WHERE post_id = $post_edit_id";
	$reset_views_query = mysqli_query($connection, $query);
	confirm($reset_views_query);
}

?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="post_title">Post Title</label>
		<input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
	</div>
	<div class="form-group">
		<label for="category">Category</label>
		<select name="post_category" id="post_category" class="form-control">
			<?php

$query = "SELECT * FROM categories";
$select_category = mysqli_query($connection, $query);
confirm($select_category);

while ($row = mysqli_fetch_assoc($select_category)) {
	$cat_id = $row['cat_id'];
	$cat_title = $row['cat_title'];

	if ($cat_id === $post_category_id) {
		echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
	} else {
		echo "<option value='{$cat_id}'>{$cat_title}</option>";
	}
}

?>

		</select>
	</div>

	<div class="form-group">
		<label for="status">Status</label>
		<select name="post_status" id="" class="form-control">
		<option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
<?php if ($post_status === 'published') {
	echo "<option value='draft'>draft</option>";
} else {
	echo "<option value='published'>publish</option>";
}
?>
		</select>
	</div>
	<div class="form-group">
		<img class="img-fluid" width=200 src="../images/<?php echo $post_image; ?>" alt="">
		<label for="post_image">Post Image</label>
		<input type="file" class="form-control p-2" name="post_image">
	</div>
	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
	</div>
	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content; ?></textarea>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-warning" name="reset_views"  value="Reset Views">
		<input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
	</div>

</form>
