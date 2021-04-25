<?php
    require("../Controller/User.php");
    include("../Controller/Session.php");
    session_start();

    if((new Session())->loadSession()){
        header("location: /codeclub/index.php");
    }
    
    $pass = true;
    $data = [
        "username" => $_POST["user"] ?? null,
        "password" => $_POST["password"] ?? null
    ];

    foreach (array_values($data) as $info){
        if (!isset($info)) $pass = false;
    }

    $data["keep_logged"] = $_POST["keep_logged"] ?? null;

    if ($pass == true){
        if ((new User())->login($data)) {
            header("location: ../index.php");
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>CodePlay :: Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../assets/css/form.css">
</head>

<body class="color">
    <?php include("navbar.php"); ?>

    <div id="main_form">
        <form method="POST" action="login.php">
            <div class="card color">
                <div id="form_title">
                    <img id="imglogo" src="../assets/images/logo.png">
                    <p class="color pixel large title">CodePlay</p>
                </div>

                <input class="color input_style" type="text" name="user" placeholder="Usuário" required>

                <input class="color input_style" type="password" name="password" placeholder="Senha" required>

                <input class="checkbox" type="checkbox" name="keep_logged">
                <label id="logged" class="color">Me manter logado</label>

                <div class="btn-rgst">
                    <a class="color" href="register.php">Criar uma conta</a>
                </div>

                <div class="btn color">
                    <button type="submit">ACESSAR</button>
                </div>
            </div>
        </form>
    </div>

    <script src="../assets/js/script.js"></script>
</body>

</html>
