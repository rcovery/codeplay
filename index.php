<?php
    session_start();
    include(dirname(__FILE__) . "/Controller/Session.php");
    include(dirname(__FILE__) . "/Controller/Post.php");
    include(dirname(__FILE__) . "/Controller/User.php");
    $state = "on";
    if(!(new Session())->loadSession()){
        $state = "off";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>CodePlay :: Página principal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="assets/css/global.css">
    <link rel="stylesheet" type="text/css" href="assets/css/navbar.css">

    <!-- AOS JS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- SPLIDE JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
</head>

<body>
    <?php include("pages/navbar.php"); ?>
 
    <?php if (empty($_GET["search"])) : ?>
        <?php if ($state == 'off') : ?>
            <div class="header_landing" data-aos="fade-up">
            	<div>
            		<span class="gradient_line"></span>
        	    	<span class="flex_block emoji">&#10024;
                        <p class="header_text italic_text">&nbsp;somos a&nbsp;</p>
                    &#10024;</span>
                    <div class="cshadow relative_block">
                        <p class="header_text pixel custom_shadow">CODEPLAY</p>
        	    	    <p class="header_text pixel" style="position: relative;">CODEPLAY</p>
                    </div>
        	    	<span class="gradient_line"></span>
        	    </div>
            </div>

            <div class="block normal" data-aos="fade-up">
                <h1>Venha ser um gamer!</h1>
                <p>A Codeplay vai te ensinar a programar jogos digitais!</p>
            </div>

            <div class="block reverse" data-aos="fade-up">
                <h1>Aqui você pode jogar e aprender!</h1>
                <div class="showcase">
                  <div class="game_item" data-aos="flip-up">
                    <img src="assets/images/default_pic.png">
                    <p>"Zombie ipsum reversus ab viral inferno, nam rick grimes malum cerebro. De carne lumbering animata corpora quaeritis. Summus br..."</p>
                    <a class="gradient_button">JOGAR AGORA</a>
                  </div>
                  <div class="game_item" data-aos="flip-up">
                    <img src="assets/images/default_pic.png">
                    <p>"Zombie ipsum reversus ab viral inferno, nam rick grimes malum cerebro. De carne lumbering animata corpora quaeritis. Summus br..."</p>
                    <a class="gradient_button">JOGAR AGORA</a>
                  </div>
                  <div class="game_item" data-aos="flip-up">
                    <img src="assets/images/default_pic.png">
                    <p>"Zombie ipsum reversus ab viral inferno, nam rick grimes malum cerebro. De carne lumbering animata corpora quaeritis. Summus br..."</p>
                    <a class="gradient_button">JOGAR AGORA</a>
                  </div>
                </div>
            </div>

            <div class="block normal" data-aos="fade-up">
                <h1>Quem somos?</h1>
                <div class="flex_block who">
                    <img src="assets/images/default_pic.png">
                    <div class="who_quote">
                        <p>"A Codeplay é uma plataforma de ensino, planejada para o compartilhamento de conhecimento sobre programação focada em jogos digitais! Somos jovens desenvolvedores buscando abrir portas para os iniciantes em programação, criando um ambiente facil e estimulante para se programar jogos."
                        </p>
                        <p>"A plataforma em si não é apenas para iniciantes, aqui você pode divulgar toda sua experiência em relação aos jogos digitais! A Codeplay pode mostrar para todos que não precisa ter algum "Super-Poder" para programar! 😁"
                        </p>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <?php
                $viewed = (new Post())->showcase("post_views", "DESC");
                $date = (new Post())->showcase("post_date", "DESC");
                $likes = (new Post())->showcase("post_views", "DESC");
            ?>
            <h2 class="game_category">Jogos mais vistos</h2>
            <div class="splide" id="slide_one">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach($viewed as $game) : ?>
                            <a href="pages/post.php?id=<?= $game['ID_post'] ?>" class="splide__slide game_item" target="_blank">
                                <img src="<?= $game['post_files'] . "/thumb/thumbnail.dat"; ?>">
                                <p class="game_title"><?= substr($game["post_title"], 0, 20) . "..."; ?></p>
                                <span class="creator">By: <?= (new User())->getUser($game['ID_user_FK'])['username']; ?></span>
                                <span class="gameboy controller"><span></span></span>
                                <span class="gameboy btn"></span>
                                <span class="gameboy btn"></span>
                            </a>
                        <?php endforeach ; ?>
                    </ul>
                </div>
            </div>
            <h2 class="game_category">Jogos postados recentemente</h2>
            <div class="splide" id="slide_two">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach($date as $game) : ?>
                            <a href="pages/post.php?id=<?= $game['ID_post'] ?>" class="splide__slide game_item" target="_blank">
                                <img src="<?= $game['post_files'] . "/thumb/thumbnail.dat"; ?>">
                                <p class="game_title"><?= substr($game["post_title"], 0, 20) . "..."; ?></p>
                                <span class="creator">By: <?= (new User())->getUser($game['ID_user_FK'])['username']; ?></span>
                                <span class="gameboy controller"><span></span></span>
                                <span class="gameboy btn"></span>
                                <span class="gameboy btn"></span>
                            </a>
                        <?php endforeach ; ?>
                    </ul>
                </div>
            </div>
            <h2 class="game_category">Jogos mais curtidos</h2>
            <div class="splide" id="slide_three">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach($likes as $game) : ?>
                            <a href="pages/post.php?id=<?= $game['ID_post'] ?>" class="splide__slide game_item" target="_blank">
                                <img src="<?= $game['post_files'] . "/thumb/thumbnail.dat"; ?>">
                                <p class="game_title"><?= substr($game["post_title"], 0, 20) . "..."; ?></p>
                                <span class="creator">By: <?= (new User())->getUser($game['ID_user_FK'])['username']; ?></span>
                                <span class="gameboy controller"><span></span></span>
                                <span class="gameboy btn"></span>
                                <span class="gameboy btn"></span>
                            </a>
                        <?php endforeach ; ?>
                    </ul>
                </div>
            </div>
        <?php endif ; ?>

        <div class="block quote reverse" data-aos="fade-up">
            <span class="quote_icon">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 475.1 475.1" style="enable-background:new 0 0 475.1 475.1;" xml:space="preserve"><path class="st0" d="M164.4,219.3h-64c-7.6,0-14.1-2.7-19.4-8c-5.3-5.3-8-11.8-8-19.4v-9.1c0-20.2,7.1-37.4,21.4-51.7
        c14.3-14.3,31.5-21.4,51.7-21.4h18.3c4.9,0,9.2-1.8,12.8-5.4c3.6-3.6,5.4-7.9,5.4-12.8V54.8c0-4.9-1.8-9.2-5.4-12.8
        c-3.6-3.6-7.9-5.4-12.8-5.4h-18.3c-19.8,0-38.7,3.9-56.7,11.6c-18,7.7-33.5,18.1-46.7,31.3c-13.1,13.1-23.6,28.7-31.3,46.7
        C3.9,144,0,162.9,0,182.7v201c0,15.2,5.3,28.2,16,38.8c10.7,10.7,23.6,16,38.8,16h109.6c15.2,0,28.2-5.3,38.8-16
        c10.7-10.7,16-23.6,16-38.8V274.1c0-15.2-5.3-28.2-16-38.8C192.6,224.6,179.7,219.3,164.4,219.3z M459.1,235.3
        c-10.7-10.7-23.6-16-38.8-16h-64c-7.6,0-14.1-2.7-19.4-8c-5.3-5.3-8-11.8-8-19.4v-9.1c0-20.2,7.1-37.4,21.4-51.7
        c14.3-14.3,31.5-21.4,51.7-21.4h18.3c4.9,0,9.2-1.8,12.8-5.4c3.6-3.6,5.4-7.9,5.4-12.8V54.8c0-4.9-1.8-9.2-5.4-12.8
        c-3.6-3.6-7.9-5.4-12.8-5.4H402c-19.8,0-38.7,3.9-56.7,11.6c-18,7.7-33.5,18.1-46.7,31.3c-13.1,13.1-23.6,28.7-31.3,46.7
        c-7.7,18-11.6,36.9-11.6,56.7v201c0,15.2,5.3,28.2,16,38.8c10.7,10.7,23.6,16,38.8,16h109.6c15.2,0,28.2-5.3,38.8-16 c10.7-10.7,16-23.6,16-38.8V274.1C475.1,258.9,469.8,245.9,459.1,235.3z"/>
                </svg>
            </span>
            <p><b>Graças a essa plataforma, eu consegui criar o meu 1° jogo! - Cleitin</b></p>
            <p><b>A codeplay me ajudou a evoluir minha programação! 😃 - Fabrício</b></p>
            <p><b>Enfim um site onde eu possa aprender a desenvolver jogos gratuitamente! - Maria</b></p>
            <p><b>Antes de conhecer a codeplay eu enxergava a programação fora do meu alcance! 😍 - Fernanda</b></p>
            <span class="quote_icon flipped">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 475.1 475.1" style="enable-background:new 0 0 475.1 475.1;" xml:space="preserve"><path class="st0" d="M164.4,219.3h-64c-7.6,0-14.1-2.7-19.4-8c-5.3-5.3-8-11.8-8-19.4v-9.1c0-20.2,7.1-37.4,21.4-51.7
        c14.3-14.3,31.5-21.4,51.7-21.4h18.3c4.9,0,9.2-1.8,12.8-5.4c3.6-3.6,5.4-7.9,5.4-12.8V54.8c0-4.9-1.8-9.2-5.4-12.8
        c-3.6-3.6-7.9-5.4-12.8-5.4h-18.3c-19.8,0-38.7,3.9-56.7,11.6c-18,7.7-33.5,18.1-46.7,31.3c-13.1,13.1-23.6,28.7-31.3,46.7
        C3.9,144,0,162.9,0,182.7v201c0,15.2,5.3,28.2,16,38.8c10.7,10.7,23.6,16,38.8,16h109.6c15.2,0,28.2-5.3,38.8-16
        c10.7-10.7,16-23.6,16-38.8V274.1c0-15.2-5.3-28.2-16-38.8C192.6,224.6,179.7,219.3,164.4,219.3z M459.1,235.3
        c-10.7-10.7-23.6-16-38.8-16h-64c-7.6,0-14.1-2.7-19.4-8c-5.3-5.3-8-11.8-8-19.4v-9.1c0-20.2,7.1-37.4,21.4-51.7
        c14.3-14.3,31.5-21.4,51.7-21.4h18.3c4.9,0,9.2-1.8,12.8-5.4c3.6-3.6,5.4-7.9,5.4-12.8V54.8c0-4.9-1.8-9.2-5.4-12.8
        c-3.6-3.6-7.9-5.4-12.8-5.4H402c-19.8,0-38.7,3.9-56.7,11.6c-18,7.7-33.5,18.1-46.7,31.3c-13.1,13.1-23.6,28.7-31.3,46.7
        c-7.7,18-11.6,36.9-11.6,56.7v201c0,15.2,5.3,28.2,16,38.8c10.7,10.7,23.6,16,38.8,16h109.6c15.2,0,28.2-5.3,38.8-16 c10.7-10.7,16-23.6,16-38.8V274.1C475.1,258.9,469.8,245.9,459.1,235.3z"/>
                </svg>
            </span>
        </div>
    <?php else : ?>
        <?php
            $result = (new Post())->search($_GET["search"]);

            if ($result == []) {
                echo "
                    <div class='no_result'>
                        Nenhum resultado encontrado!
                    </div>
                ";
            } else {
                echo "<br>";
                echo "<div class='game_search'>";
                foreach ($result as $key => $value) {
                    echo "<a href='#' class='game_item'>";
                    echo "<img src=" . str_replace(" ", "%20", $value["post_files"]) . "/thumb/thumbnail.dat" . ">";
                    echo "<p>" . $value["post_title"] . "</p>";
                    echo "<p>Criado por *nome criador*</p>";
                    echo "</a>";
                }
                echo "</div>";
                echo "<br>";
            }
        ?>
    <?php endif ?>

    <footer>
        foooter end
    </footer>

    <script src="assets/js/script.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        new Splide( '#slide_one', {
            perPage: 4,
            gap: 30,
            autoWidth: true,
            type: 'loop'
        }).mount();
        new Splide( '#slide_two', {
            perPage: 4,
            gap: 30,
            autoWidth: true,
            type: 'loop'
        }).mount();
        new Splide( '#slide_three', {
            perPage: 4,
            gap: 30,
            autoWidth: true,
            type: 'loop'
        }).mount();
    </script>
    <!-- <script src="http://rcovery-mailer.herokuapp.com/rcoveryMail.js"></script> -->
</body>

</html>