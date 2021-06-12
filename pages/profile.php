<?php
	session_start();
	require_once(dirname(__FILE__) . "/../Controller/Post.php");
	require_once(dirname(__FILE__) . "/../Controller/User.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Codeplay :: Profile</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../assets/css/global.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="perfil.css">
</head>
<body>
	<?php
		include("navbar.php");

		$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

		if (isset($_GET['success']) && $_GET['success']='1') {
            (new View("Sucesso!"))->success();
        }

		$user = (new User())->getUser($_GET['id']);

		if (!isset($_GET['id']) || empty($_GET['id'])) header("location: /index.php");
	?>

	<div class="flex_block">
		<div class="main_page">
			<form method="POST" action="profile.php">
				<div class="card">
					<div class="space">
						<div class="card-header">
							<img src="<?= $user['pic_path'] ?>" alt="">
							<h1 class="username"><?= $user['username'] ?></h1>
						</div>
						<div class="card">
							<?php if($_GET['id'] == $id): ?>
								<i class="right-corner color bi bi-pencil-fill"></i>
							<?php endif; ?>

							<div class="card-group">
								<div class="flex_block vertical">
									<p class="field">NOME DE USUÁRIO</p>
									<h2 class="color"><?= $user['username'] ?></h2>
								</div>
							</div>
							<br>
							<div class="card-group">
								<div class="flex_block vertical">
									<p class="field">BIO</p>
									<h2 class="color"><?= $user['bio'] ?></h2>
								</div>
							</div>

							<!-- <div class="card-group">
								<div class="flex_block vertical">
									<p class="field">NOME DE USUÁRIO</p>
									<h2>Meu Nome</h2>
								</div>
								<?php if($_GET['id'] == $id): ?>
									<button type="submit" class="btn no_margin">Editar</button>
								<?php endif; ?>
							</div>
							<br>
							<div class="card-group">
								<div class="flex_block vertical">
									<p class="field">BIO</p>
									<h2>Diga mais sobre você</h2>
								</div>
								<?php if($_GET['id'] == $id): ?>
									<button type="submit" class="btn no_margin">Editar</button>
								<?php endif; ?>
							</div> -->
						</div>
					</div>
				</div>
			</form>

			<div class="card">
				<table class="history">
					<thead>
						<tr>
							<td class="larger field">Publicação</td>
							<td class="field selected">Data</td>
							<td class="field">Curtidas</td>
							<?php if($_GET['id'] == $id): ?>
								<td class="field">Ações</td>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach((new Post())->history("post_date", 'ASC', $_GET['id']) as $post): ?>
							<tr>
								<td class="larger">
									<a style="text-decoration: none;" class="flex_block color" href="post.php?id=<?= $post['ID_post'] ?>">
										<div class="block_image_78ajoe">
											<img src="<?= $post['post_files'] ?>thumb/thumbnail.dat">
										</div>
										<div class="flex_block vertical left">
											<p><?= (strlen($post['post_title']) > 25) ? substr($post['post_title'], 0, 25) . "..." : $post['post_title'] ?></p>
											<br>
											<p><?= $post['post_views'] ?> views</p>
										</div>
									</a>
								</td>
								<td class="color selected"><?= $post['post_date'] ?></td>
								<td class="color"><?= $post['post_likes'] ?></td>
								<?php if($_GET['id'] == $id): ?>
									<td>
										<a href="newpost.php?edit=<?= $post['ID_post'] ?>"><i class="color bi bi-pencil-fill"></i></a>
										&nbsp;
										<a href="javascript:void(0)" onclick="confirm_modal(<?= $post['ID_post'] ?>)"><i class="color bi bi-trash"></i></a>
									</td>
								<?php endif; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div id="black_screen_of_decision">
		<div class="confirm delete">
		    <p>Tem certeza?</p>
		    <div>
			    <button onclick="document.getElementById('black_screen_of_decision').classList.remove('active')">CANCELAR</button>
			    <button onclick="delete_info('post', delete_modal_last_id)">SIM</button>
			</div>
		</div>
	</div>

	<br>

	<script src="../assets/js/script.js"></script>
</body>
</html>