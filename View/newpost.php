<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodePlay :: Nova postagem</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/form.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/global.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/navbar.css">
</head>

<body>
    <?php
        include("navbar.php");
        require("../Controller/Post.php");
        include("../Controller/Session.php");

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
        }
    ?>
    
    <div id="main_form">
        <form method="POST" action="newpost.php" enctype="multipart/form-data">
            <div class="card">
                <div id="form_title">
                    <img id="imglogo" src="../assets/images/logo.png">
                    <p class="pixel large title">CodePlay</p>
                </div>
                
                <input class="input_7huy5" type="text" name="title"
                value="" placeholder="Título da postagem" required maxlength="150">
                
                <textarea class="input_7huy5 description" type="text" name="description"
                value="" placeholder="Fale sobre seu código" required></textarea>
                
                <div class="upload_buttons">
                    <div>
                        <label for="file" class="upload_btn">
                            <img title="Logo" id="src_files" class="upload_icons" src="../assets/images/file.png">
                            <p class="file_label">Upload files!</p>
                        </label>
                        <input id="file" name="source_files[]" type="file" accept=".html, .css, .js, image/png, image/jpeg, image/jpg" hidden multiple onchange="
                            update_file_input('sources')
                        " required/>
                    </div>
                    <div>
                        <label for="thumb" class="upload_btn">
                            <img class="upload_icons" id="thumb_logo" src="../assets/images/thumb.png">
                            <p class="file_label" id="thumb_name">Upload thumb!</p>
                        </label>
                        <input id="thumb" name="thumb" type="file" accept="image/png, image/jpeg, image/jpg" hidden onchange="
                            update_file_input('thumb')
                        " required/>
                    </div>
                </div>
                
                <div class="btn">
                    <button type="submit">POSTAR</button>
                </div>
            </div>
        </form>
    </div>

    <script src="../assets/js/script.js"></script>
</body>

</html>