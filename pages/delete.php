<?php
	require_once(dirname(__FILE__) . "/../Model/DB.php");
	require_once(dirname(__FILE__) . "/../Controller/Post.php");

	if (!empty($_POST['entity'])) {
		$options = [
			"entity" => $_POST['entity']
		];

		switch ($_POST['entity']) {
			case 'post':
				$options["data"] = [":ID_post" => $_POST["ID_post"]];
				$options["conditional"] = "ID_post = :ID_post";

				$post = (new Post())->getPost($_POST["ID_post"]);
				$folder = $post['post_files'];
				exec("rm -rf {$folder}");

				break;

			case 'user':
				$options["data"] = [":ID_user" => $_POST["ID_user"]];
				$options["conditional"] = "ID_user = :ID_user";

				break;
		}

		(new Database())->delete($options);
	} else {
		echo "<script>window.history.back();</script>";
	}
?>