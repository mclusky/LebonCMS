
<?php
$user = $_SESSION['username'];

if (is_admin($user)) {
	$query = "SELECT posts.post_title, posts.post_id, posts.post_category_id, posts.post_author, posts.post_date, ";
	$query .= "posts.post_image, posts.post_tags, posts.post_content, posts.post_status, posts.post_comment_count, posts.post_views, ";
	$query .= "categories.cat_id, categories.cat_title FROM posts LEFT JOIN ";
	$query .= "categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";
	$query_posts = mysqli_query($connection, $query);

	while ($row = mysqli_fetch_assoc($query_posts)) {
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
		$cat_id = $row['cat_id'];
		$cat_title = $row['cat_title'];

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
echo "<td><input type='submit' value='Delete' class='btn btn-danger delete' data-id={$post_id} name='delete'></td>";
		?>
	</form>

        <?php

		echo "</tr>";

		?>
        </tbody>
    </table>
</form>
<?php

	}

} else {

	echo "Noooooooooo";

	$query = "SELECT posts.post_title, posts.post_id, posts.post_category_id, posts.post_author, posts.post_date, ";
	$query .= "posts.post_image, posts.post_tags, posts.post_content, posts.post_status, posts.post_comment_count, posts.post_views, ";
	$query .= "categories.cat_id, categories.cat_title FROM posts LEFT JOIN ";
	$query .= "categories ON posts.post_category_id = categories.cat_id WHERE posts.post_author = ? ORDER BY posts.post_id DESC";

	$stmt = mysqli_prepare($connection, $query);
	if ($stmt) {

		mysqli_stmt_bind_param($stmt, 's', $user);

		mysqli_stmt_execute($stmt);

		mysqli_stmt_bind_result($stmt, $post_title, $post_id, $post_category_id, $post_author, $post_date, $post_image, $post_tags, $post_content, $post_status, $post_comment_count, $post_views, $cat_id, $cat_title);

		mysqli_stmt_fetch($stmt);

		mysqli_stmt_close($stmt);
	}
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
        <td class='post-img'><img class='img-thumbnail' src='../images/$post_image' alt=''</td>
        <td>{$post_tags}</td>
        <td>{$post_date}</td>

        <td><a href='post_comments.php?id={$post_id}'>{$comment_count}</a></td>

        <td>{$post_views}</td>
        <td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
	?>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
		<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
		<?php
echo "<td><input type='submit' value='Delete' class='btn btn-danger delete' data-id={$post_id} name='delete'></td>";
	?>
	</form>

        <?php

	echo "</tr>";

	?>
        </tbody>
    </table>
</form>