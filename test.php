<?php include "include/header.php";?>
<?php
session_start();

echo loggedInUserId();
if (likedByUser(11)) {
	echo "User liked it";
} else {
	echo "Nope.";
}

?>