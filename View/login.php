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
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../assets/css/form.css">
    <script src="../assets/js/script.js"></script>
</head>

<body class="color">
    <button style="position:absolute;" onclick="toggle_theme()">Dark</button>
    <div id="main_form">
        <form method="POST" action="login.php">
            <div class="card color">
                <div id="form_title">
                    <img class="imglogin" src="../assets/images/logo.png">
                    <p class="color pixel large title">CodePlay</p>
                </div>

                <input class="color input_style" type="text" name="user" placeholder="Usuário" required>

                <input class="color input_style" type="password" name="password" placeholder="Senha" required>

                <div class="btn-rgst">
                    <a class="color" href="register.php">Criar uma conta</a>
                </div>

                <div class="btn color">
                    <button type="submit">ACESSAR</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
