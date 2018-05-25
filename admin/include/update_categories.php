 <form action="" method="post">
    <div class="form-group">
        <label for="cat_title">Edit Category</label>
<?php
if (isset($_GET['update'])) {

	$cat_id_to_update = escape($_GET['update']);

	$query = "SELECT * FROM categories WHERE cat_id = $cat_id_to_update ";
	$update_category = mysqli_query($connection, $query);

	while ($row = mysqli_fetch_assoc($update_category)) {
		$cat_id = $row['cat_id'];
		$cat_title = $row['cat_title'];

		?>

        <input value='<?php if (isset($cat_title)) {echo $cat_title;}?>' class="form-control" type="text" name="cat_title">

<?php }

}
?>
<?php // UPDATE Query

if (isset($_POST['update'])) {

	$cat_title_update = escape($_POST['cat_title']);

	$stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");

	mysqli_stmt_bind_param($stmt, 'si', $cat_title_update, $cat_id_to_update);

	mysqli_stmt_execute($stmt);

	if (!$stmt) {
		die("QUERY FAILED" . mysqli_error($connection));
	}

	mysqli_stmt_close($stmt);

	redirect("categories.php");

}

?>

        </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="update" value="Update">
        </div>

</form>