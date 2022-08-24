<?php
	require_once(dirname(__FILE__) . "/../Controller/Likes.php");

	if (!empty($_POST['ID_post_FK']) && !empty($_POST['ID_user_FK'])) {
		(new Likes())->like($_POST['ID_post_FK'], $_POST['ID_user_FK']);
	} else {
		echo "<script>window.history.back();</script>";
	}
?>