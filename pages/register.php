<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>CodePlay :: Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../assets/css/form.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/global.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/navbar.css">
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
            ":password" => $_POST["password"] ?? null
        ];

        foreach (array_values($data) as $info){
            if (!isset($info)) $pass = false;
        }

        if ($pass == true){
            $register = new User();
            if($register->createUser($data)){
                // header("location: ../index.php");
            }
        }
    ?>
    
    <div id="main_form">
        <form method="POST" action="register.php">
            <div class="card  ">
                <div id="form_title">
                    <img id="imglogo" src="../assets/images/logo.png">
                    <p class="pixel large title">CodePlay</p>
                </div>

                <input class="input_7huy5" type="text" name="email"
                value="<?= ($_POST["email"] ?? '');?>" placeholder="Email" required>

                <input class="input_7huy5" type="text" name="user"
                value="<?= ($_POST["user"] ?? '');?>" placeholder="Login" required>

                <input class="input_7huy5" type="password" name="password" placeholder="Senha" required>

                <div class="btn-rgst">
                    <a href="login.php">Já tem uma conta? Faça login</a>
                </div>

                <div class="btn">
                    <button type="submit">REGISTRAR</button>
                </div>
            </div>
        </form>
    </div>

    <script src="../assets/js/script.js"></script>
</body>

</html>