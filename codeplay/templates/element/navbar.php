<?php $this->start('navbar'); ?>
<nav class="top-nav">
    <div class="top-nav-title">
        <a href="<?= $this->Url->build('/') ?>">
            <img class="codeplay_logo" title="Logo" alt="Logo" src="/img/logo.png"></img>
        </a>
    </div>

    <div>
        <form action="/" method="GET">
            <input class="search_box color" type="text" name="search" value="<?= isset($_GET["search"]) ? $_GET['search'] : '' ?>" placeholder="Search"></input>
        </form>
    </div>

    <!-- TODO if not logged, show only login button -->
	<!-- <div id="btn" onclick="dropdown()">
		<span class="dropdown"></span>
		<span class="dropdown"></span>
		<span class="dropdown"></span>
	</div> -->
</nav>
<?php $this->end(); ?>