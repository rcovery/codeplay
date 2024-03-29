<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>CodePlay :: Registro</title>
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
            ":email" => $_POST["email"] ?? null,
            ":username" => $_POST["user"] ?? null,
            ":password" => $_POST["password"] ?? null,
            ":lgpd" => $_POST["lgpd"] ?? null
        ];

        foreach (array_values($data) as $info){
            if (!isset($info)) $pass = false;
        }

        if ($pass == true){
            (new User())->createUser($data);
        }
    ?>
    
    <div id="main_form">
        <form method="POST" action="register.php">
            <div class="formpage">
                <div id="form_title">
                    <img id="imglogo" src="../assets/images/logo.png">
                    <p class="pixel large title">CodePlay</p>
                </div>

                <input class="input_7huy5 color" type="text" name="email"
                value="<?= ($_POST["email"] ?? '');?>" placeholder="Email" required>

                <input class="input_7huy5 color" maxlength="25" type="text" name="user"
                value="<?= ($_POST["user"] ?? '');?>" placeholder="Login" required>

                <input class="input_7huy5 color" type="password" name="password" placeholder="Senha" required>

                <input class="checkbox" type="checkbox" name="lgpd" required>
                <label id="logged" class="color">Li e aceito os <a href="../termos.docx">Termos de uso</a> e <a href="../privacidade.docx">Política de privacidade.</a></label>
                <br>
                <input class="checkbox" type="checkbox" name="lgpd">
                <label id="logged" class="color">Aceito receber atualizações de jogos novos.</label>

                <div class="btn-rgst">
                    <a href="login.php">Já tem uma conta? Faça login</a>
                </div>

                <button class="btn full" type="submit">REGISTRAR</button>
            </div>
        </form>
    </div>

    <script src="../assets/js/script.js"></script>
</body>

</html>