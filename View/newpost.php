<?php
    require("../Controller/Post.php");
    include("../Controller/Session.php");
    session_start();

    if(!(new Session())->loadSession()){
        header("location: ../View/login.php");
    }
    
    $pass = true;
    $data = [
        "post_title" => $_POST["title"] ?? null,
        "post_content" => $_POST["description"] ?? null
    ];

    $files = [
        "thumb" => $_FILES["thumb"] ?? null,
        "source" => $_FILES["source_files"] ?? null
    ];

    foreach (array_values($data) as $info){
        if (empty($info)) $pass = false;
    }

    foreach (array_values($files) as $info){
        if (empty($info)) $pass = false;
    }

    if ($pass){
        (new Post())->createPost($data, $files);
    } else {
        (new View("Você deve preencher todos os campos!"))->warning();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodePlay :: Nova postagem</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/form.css">
</head>

<body class="color">
    <button style="position:absolute;" onclick="toggle_theme()">Dark</button>
    <div id="main_form">
        <form method="POST" action="newpost.php" enctype="multipart/form-data">
            <div class="card color">
                <div id="form_title">
                    <img class="imglogin" src="../assets/images/logo.png">
                    <p class="color pixel large title">CodePlay</p>
                </div>
                
                <input class="color input_style" type="text" name="title"
                value="" placeholder="Título da postagem">
                
                <textarea class="color input_style description" type="text" name="description"
                value="" placeholder="Fale sobre seu código"></textarea>
                
                <div class="upload_buttons">
                    <div>
                        <label for="file" class="upload_btn">
                            <img title="Logo" class="upload_icons" src="../assets/images/file.png">
                            <p id="file_names">Upload files!</p>
                        </label>
                        <input id="file" name="source_files[]" type="file" accept=".html, .css, .js, image/png, image/jpeg, image/jpg" hidden multiple onchange="
                            update_file_input(this.value, 'file_names')
                        "/>
                    </div>
                    <div>
                        <label for="thumb" class="upload_btn">
                            <img class="upload_icons" src="../assets/images/thumb.png">
                            <p id="file_name">Upload thumb!</p>
                        </label>
                        <input id="thumb" name="thumb" type="file" accept="image/png, image/jpeg, image/jpg" hidden onchange="
                            update_file_input(this.value, 'file_name')
                        "/>
                    </div>
                </div>
                
                <div class="btn color">
                    <button type="submit">POSTAR</button>
                </div>
            </div>
        </form>
    </div>

    <script src="../assets/js/script.js"></script>
</body>

</html>