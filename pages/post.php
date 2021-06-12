<?php
	session_start();
	require_once(dirname(__FILE__) . "/../Controller/Post.php");
	require_once(dirname(__FILE__) . "/../Controller/User.php");
	require_once(dirname(__FILE__) . "/../Controller/Likes.php");
	require_once(dirname(__FILE__) . "/message.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Codeplay :: Post</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../assets/css/global.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/navbar.css">
</head>
<body>
	<?php
		include("navbar.php");
		
		if (!isset($_GET["id"])) {
			(new View("Ocorreu um erro!"))->warning();
			header("location: newpost.php");
		} else {
			(new Post())->view($_GET["id"]);

			$result = (new Post())->getPost($_GET["id"]);
			$user = (new User())->getUser($result["ID_user_FK"]);
			$is_liked = (new Likes())->isLiked($_GET["id"], $result["ID_user_FK"]);
		}
	?>

	<div class="flex_block">
		<div class="main_page">
			<div class="block_image_78ajoe"><img id="game_thumb" src="<?= $result['post_files'] . "thumb/thumbnail.dat" ?>"></div>
			<div class="flex_block game_infos">
				<div>
					<a class="postpage" href="profile.php?id=<?= $user['ID_user'] ?>"><img class="profile_pic postpage" src="<?= $user["pic_path"]; ?>"></a>
					<div>
						<p class="postpage info" title="<?= $result["post_title"] ?>"><?= $result["post_title"] ?></p>
						<p class="postpage info color"><?= $user["username"] ?></p>
					</div>
				</div>
				<div>
					<a href="<?= $result['post_files']; ?>" target="_blank" class="act_button" id="playgame"><i class="bi bi-play-fill"></i> JOGAR</a>
					<?php if(isset($_SESSION['id']) && $_SESSION['id'] == $user['ID_user'] || isset($_SESSION['id']) && $_SESSION['is_admin'] == 1): ?>
						<a class="act_button" id="editgame" href="newpost.php?edit=<?= $result['ID_post']; ?>"><i class="bi bi-pencil"></i> EDIT</a>
					<?php endif; ?>
					<a href="<?= $result['post_files']; ?>source_code.zip" target="_blank" class="act_button" id="downloadgame"><i class="bi bi-cloud-download"></i></a>
				</div>
			</div>
			<div class="flex_block game_content">
				<div id="game_9ka83l" class="color">
					<div id="description_header">
						<p>Nº de visualizações <?= $result['post_views'] ?></p>
						<p>
							<i onclick="like_toggle(<?= $_GET['id'] ?>, <?= $_SESSION['id'] ?>, <?= $is_liked ?>)" id="like_star" class="bi bi-star-fill <?= $is_liked ? '' : 'bi-star' ?>"></i>
							<span id="like_number">
								<?= $result['post_likes'] ?>
							</span>
						</p>
					</div>
					<div id="game_description" class="color"><?= $result['post_content'] ?></div>
				</div>
				<div class="recommended">
					<p>Outros jogos</p>
					<?php foreach((new Post())->showcase("post_date", 'ASC', 15) as $game): ?>
						<a href="post.php?id=<?= $game['ID_post'] ?>" class="game_item">
							<div class="block_image_78ajoe">
								<img src="<?= $game['post_files'] ?>thumb/thumbnail.dat">
							</div>
							<div class="game_info">
								<strong class="color"><?= (strlen($game['post_title']) > 40) ? substr($game['post_title'], 0, 40) . "..." : $game['post_title'] ?></strong>
								<p class="color"><?= $user['username'] ?></p>
								<p class="views"><?= $game["post_views"] ?> views</p>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<script src="../assets/js/script.js"></script>
	<script>
		var is_liked = <?= empty($is_liked) ? 0 : 1 ?>
	</script>
</body>
</html>