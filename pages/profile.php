<?php
	session_start();
	require_once(dirname(__FILE__) . "/../Controller/Post.php");
	require_once(dirname(__FILE__) . "/../Controller/User.php");
	require_once(dirname(__FILE__) . "/../Controller/Session.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Codeplay :: Profile</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../assets/css/global.css">
</head>
<body>
	<?php
		include("navbar.php");

		//if (!isset($_GET['id']) || empty($_GET['id'])) header("location: /index.php");
		if(!(new Session())->loadSession()){
            header("location: ../pages/login.php");
        }

        $pass = false;
        $data = [
            ":username" => $_POST["username"] ?? null,
            ":bio" => $_POST["bio"] ?? null
        ];

        $files = [
        	"pic" => $_FILES['pic'] ?? null
        ];

        foreach (array_values($data) as $info){
            if (!empty($info)) $pass = true;
        }

        foreach (array_values($files) as $info){
            if (!empty($info)) $pass = true;
        }

        if ($pass) {
        	$data[":ID_user"] = $_GET['id'];
        	if ((new User())->updateProfile($data, $files)){
        		header("location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&success=1");
        	}
        }

		if (isset($_GET['success']) && $_GET['success']='1') {
            (new View("Sucesso!"))->success();
        }

        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
		$user = (new User())->getUser($_GET['id']);
	?>

	<div class="flex_block">
		<div class="main_page">
			<form method="POST" action="profile.php?id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
				<div class="card">
					<div class="space">
						<?php if($_GET['id'] == $id): ?>
							<a href="javascript:void(0)" onclick="show_form()" class="text_hiddenform"><i class="right-corner color bi bi-pencil-fill"></i></a>

							<a href="javascript:void(0)" onclick="show_form()" class="input_hiddenform hidden"><i class="right-corner color bi bi-x-lg"></i></a>
						<?php endif; ?>
						<div class="card-header">
							<label for="pic" class="upload_btn">
	                            <img src="<?= $user['pic_path'] ?>" title="profile_pic">
	                        </label>
                        	<input id="pic" name="pic" type="file" accept="image/png, image/jpeg, image/jpg" disabled hidden/>
							
							<h1 class="username"><?= $user['username'] ?></h1>
						</div>
						<div class="card">
							<div class="card-group">
								<div class="flex_block vertical">
									<p class="field">NOME DE USUÁRIO</p>
									<h2 class="color text_hiddenform"><?= $user['username'] ?></h2>
									<input maxlength="25" value="<?= $user['username'] ?>" class="input_hiddenform hidden input_7huy5 color" type="text" name="username">
								</div>
							</div>
							<br>
							<div class="card-group">
								<div class="flex_block vertical">
									<p class="field">BIO</p>
									<h2 class="color text_hiddenform"><?= $user['bio'] ?></h2>
									<input maxlength="100" value="<?= $user['bio'] ?>" class="input_hiddenform hidden input_7huy5 color" type="text" name="bio">
								</div>
							</div>
						</div>

						<button id="save_button" type="submit" class="btn hidden">SALVAR</button>
					</div>
				</div>
			</form>

			<div class="card" style="overflow-x:auto">
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