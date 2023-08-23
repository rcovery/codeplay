<!-- TODO fazer uma navbar melhor -->

<nav class="nav_parent">
    <div>
        <a href="/">
            <img class="codeplay_logo" title="Logo" alt="Logo" src="/img/logo.png"></img>
        </a>
    </div>

    <div>
        <form action="/" method="GET">
            <input class="search_box color" type="text" name="search" value="<?= isset($_GET["search"]) ? $_GET['search'] : '' ?>" placeholder="Search"></input>
        </form>
    </div>
    <div class="nav_menu_button_parent">
        <?php if (isset($authenticatedUser['id'])) : ?>
            <div class="nav_menu_button" onclick="dropdown()">
                <span class="dropdown_bar"></span>
                <span class="dropdown_bar"></span>
                <span class="dropdown_bar"></span>
            </div>
        <?php else : ?>
            <a href="/login">Login</a>
        <?php endif; ?>
    </div>
</nav>