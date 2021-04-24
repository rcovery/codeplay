<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Codeclub Test</title>
</head>

<body>
    <center>
        <?php if(!isset($_SESSION["id"])) : ?>
            <a href="View/register.php">Register</a>
            <a href="View/login.php">Login</a>
        <?php endif ?>
        <?php if(isset($_SESSION["id"])) : ?>
            <a href="View/logout.php">Logout</a>
            <a href="View/newpost.php">Criar uma postagem</a>
        <?php endif ?>
    </center>
</body>

</html>