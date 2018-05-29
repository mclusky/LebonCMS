<?php

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