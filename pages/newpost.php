<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodePlay :: Nova postagem</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/form.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/global.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/navbar.css">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>

<body>
    <?php
        include("navbar.php");
        require(dirname(__FILE__) . "/../Controller/Post.php");
        include(dirname(__FILE__) . "/../Controller/Session.php");

        if(!(new Session())->loadSession()){
            header("location: ../pages/login.php");
        }

        $pass = true;
        $data = [
            ":post_title" => $_POST["title"] ?? null,
            ":post_content" => $_POST["description"] ?? null
        ];

        if (isset($_GET["edit"]) && !empty($_GET['edit'])) {
            $postdata = (new Post())->getPost($_GET['edit']);

            if ($_SESSION['id'] != $postdata['ID_user_FK']) {
                header("location: newpost.php");
            }

            $data[":ID_post"] = $_GET['edit'];
            $data["original_title"] = $postdata['post_title'];
            $data["edit"] = true;
        }

        $files = [
            "thumb" => $_FILES["thumb"] ?? null,
            "source" => $_FILES["source_files"] ?? null
        ];

        foreach (array_values($data) as $info){
            if (empty($info)) $pass = false;
        }

        if (!isset($data['edit'])){
            foreach (array_values($files) as $info){
                if (empty($info)) $pass = false;
            }
        }

        if ($pass){
            if (empty($files['thumb']['name']) && empty($files['source']['name'][0])) $files = null;

            !isset($data['edit'])
            ? (new Post())->createPost($data, $files)
            : (new Post())->updatePost($data, $files);

            // header("location: ../index.php");
        }
    ?>
    
    <div id="main_form">
        <form id="post_form" method="POST" action="newpost.php<?= isset($data['edit']) ? '?edit='.$_GET["edit"] : '' ?>" enctype="multipart/form-data">
            <span class="information_btn" onclick="openModal('information')"><b>i</b></span>
            <div class="card">
                <div id="form_title">
                    <img id="imglogo" src="../assets/images/logo.png">
                    <p class="pixel large title">CodePlay</p>
                </div>
                
                <input class="input_7huy5" type="text" name="title"
                value="<?= $postdata['post_title'] ?? ''; ?>" placeholder="Título da postagem" required maxlength="150">
                
                <textarea id="editor" class="input_7huy5 description" type="text" name="description"
                value="" placeholder="Fale sobre seu código" required><?= $postdata['post_content'] ?? ''; ?></textarea>
                
                <div class="upload_buttons">
                    <div>
                        <label for="file" class="upload_btn">
                            <img title="Logo" id="src_files" class="upload_icons" src="../assets/images/file.png">
                            <p class="file_label">Upload files!</p>
                        </label>
                        <input id="file" name="source_files[]" type="file" accept=".html, .css, .js, image/png, image/jpeg, image/jpg" hidden multiple onchange="
                            update_file_input('sources')
                        " <?= !isset($data['edit']) ? 'required' : ''; ?>/>
                    </div>
                    <div>
                        <label for="thumb" class="upload_btn">
                            <img class="upload_icons" id="thumb_logo" src="../assets/images/thumb.png">
                            <p class="file_label" id="thumb_name">Upload thumb!</p>
                        </label>
                        <input id="thumb" name="thumb" type="file" accept="image/png, image/jpeg, image/jpg" hidden onchange="
                            update_file_input('thumb')
                        " <?= !isset($data['edit']) ? 'required' : ''; ?>/>
                    </div>
                </div>
                
                <div class="btn">
                    <button type="submit">POSTAR</button>
                </div>
            </div>
        </form>
    </div>

    <div id='information'>
        <span class="information_btn" onclick="closeModal('information')">&#10006;</span>
        <br>
        <p>[+] Tamanhos de arquivos suportados:<br>
        &nbsp;&nbsp;&nbsp;&nbsp;.html/.css/.js > 20kb<br>
        &nbsp;&nbsp;&nbsp;&nbsp;.png/.jpg/.jpeg > 100kb
        </p>
        <br>
        <p>[+] O código fonte deve conter um arquivo "index.html".</p>
        <br>
        <p>[+] Ao atualizar os arquivos da postagem, os arquivos antigos serão removidos!</p>
    </div>

    <script src="../assets/js/script.js"></script>
    <script>
        $('#editor').summernote({
        placeholder: 'Fale sobre seu código',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    </script>
</body>

</html>