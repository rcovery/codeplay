<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>CodePlay :: Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../assets/css/global.css">
</head>

<body>
    <?php
        include("navbar.php");
        require(dirname(__FILE__) . "/../Controller/User.php");
        include(dirname(__FILE__) . "/../Controller/Session.php");

        if((new Session())->loadSession()){
            header("location: ../index.php");
        }
        
        $pass = true;
        $data = [
            ":username" => $_POST["user"] ?? null,
            ":password" => $_POST["password"] ?? null
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

    <div id="main_form">
        <form method="POST" action="login.php">
            <div class="formpage">
                <div id="form_title">
                    <img id="imglogo" src="../assets/images/logo.png">
                    <p class="pixel large title">CodePlay</p>
                </div>

                <input class="input_7huy5 color" maxlength="25" type="text" name="user" placeholder="Usuário" required>

                <input class="input_7huy5 color" type="password" name="password" placeholder="Senha" required>

                <input class="checkbox" type="checkbox" name="keep_logged">
                <label id="logged" class="color">Me manter logado</label>

                <div class="btn-rgst">
                    <a href="register.php">Criar uma conta</a>
                </div>

                <button class="btn full" type="submit">ACESSAR</button>
            </div>
        </form>
    </div>

    <script src="../assets/js/script.js"></script>
</body>

</html>
