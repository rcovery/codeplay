<link rel="stylesheet" type="text/css" href="/codeclub/assets/css/navbar.css">

<span id="rgb_top_bar"></span>

<div id="navbar1991">
	<a href="/codeclub/"><img title="Logo" alt="Logo" src="/codeclub/assets/images/logo.png"></img></a>

	<form action="" method="GET">
		<input class="search_box" type="text" name="search" placeholder="Search"></input>
	</form>

	<div id="btn" onclick="dropdown()">
		<span class="dropdown"></span>
		<span class="dropdown"></span>
		<span class="dropdown"></span>
	</div>
</div>

<div class="dropdown_menu">
	<div style="text-align: right;">
		<div class="theme_switcher" onclick="toggle_theme(this)"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		viewBox="0 0 292.299 292.299"
		 xml:space="preserve"><path d="M153.699,292.138C68.95,292.138,0,223.185,0,138.439C0,79.742,32.675,27.002,85.28,0.807
				c2.369-1.174,5.215-0.718,7.077,1.144c1.864,1.864,2.345,4.711,1.183,7.074C83.941,28.527,79.077,49.496,79.077,71.33
				c0,77.972,63.432,141.407,141.395,141.407c22.08,0,43.247-4.978,62.942-14.777c2.366-1.177,5.213-0.721,7.074,1.141
				c1.873,1.867,2.342,4.714,1.177,7.073C265.61,259.195,212.738,292.138,153.699,292.138z"/>
			</svg>
		</div>
	</div>
    <?php if(!isset($_SESSION["id"])) : ?>
        <a href="/codeclub/View/register.php">Registro</a>
        <a href="/codeclub/View/login.php">Login</a>
    <?php endif ?>
    <?php if(isset($_SESSION["id"])) : ?>
    	<a href="/codeclub/View/newpost.php">Criar uma postagem</a>
        <a href="/codeclub/View/logout.php">Logout</a>
    <?php endif ?>
</div>

<div class="fade disabled" onclick="dropdown()"></div>