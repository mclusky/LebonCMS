<?php

if (isset($_POST['create_post'])) {

	$post_author = $_SESSION['username'];

	$post_title = escape($_POST['post_title']);
	$post_category = escape($_POST['post_category']);
	$post_status = escape($_POST['post_status']);

	$post_image = escape($_FILES['post_image']['name']);
	$post_image_temp = escape($_FILES['post_image']['tmp_name']);

	$post_tags = escape($_POST['post_tags']);
	$post_content = escape($_POST['post_content']);
	$post_date = date('d-m-y');
	// $post_comment_count = 4;

	move_uploaded_file($post_image_temp, "../images/$post_image");

	$query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";

	$query .= "VALUES({$post_category},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}') ";

	$create_post_query = mysqli_query($connection, $query);

	confirm($create_post_query);

	$post_created = mysqli_insert_id($connection);

	echo "<p class='bg-success lead'>Post Created. <a href='../post.php?p_id={$post_created}'>View Post</a> or <a href='posts.php'>Back to Posts</a></p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="post_title">Post Title</label>
		<input type="text" class="form-control" name="post_title">
	</div>
	<div class="form-group">
		<label for="post_category">Category</label>
		<select name="post_category" id="post_category" class="form-control">
<?php

$query = "SELECT * FROM categories";
$select_category = mysqli_query($connection, $query);
confirm($select_category);

while ($row = mysqli_fetch_assoc($select_category)) {
	$cat_id = $row['cat_id'];
	$cat_title = $row['cat_title'];

	echo "<option value='{$cat_id}'>{$cat_title}</option>";
}

?>

		</select>
	</div>
	<div class="form-group">
		<label for="post_status">Post Status</label>
		<select name="post_status" id="" class="form-control">
			<option value="draft">Draft</option>
			<option value="published">Publish</option>
		</select>
	</div>
	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" class="form-control" name="post_image">
	</div>
	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags">
	</div>
	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="body" cols="30" rows="10"></textarea>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_post" value="publish">
	</div>

</form>