<header>
    <div class="head-navbar">
        <div class="logo">
            <img src="<?php echo PATH_ASSETS."images/iconeGrey.png" ?>">
            <div class="name">
                <a href="/">ClassNotFound</a>
            </div>
        </div>
        <div class="search-box">
            <form id="search-bar" method="get" action="/search" >
                <button class="submit-search" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                <input name="key" class="search" type="text" placeholder="Rechercher..." autocomplete="off">
            </form>
        </div>
        <button class="account">
            <a href="/login">Connexion</a>
        </button>
    </div>
</header>