<header>
    <div class="head-navbar">
        <div class="logo">
            <img alt="logo" src="<?php echo PATH_ASSETS."images/iconeGrey.png" ?>">
            <div class="name">
                <a href="/">ClassNotFound</a>
            </div>
        </div>
        <div class="search-box">
            <form id="search-bar" method="GET" action="/search" >
                <button class="submit-search" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                <input name="key" class="search" type="text" placeholder="Rechercher..." autocomplete="off" required>
            </form>
        </div>
        <div class="menu-buttons">
            <button class="account">
		        <?php
			        if (isset($_SESSION['isConnected']) && $_SESSION['isConnected']) {
				        $user = unserialize($_SESSION['user']);
				        echo '<a href="/logout">Déconnexion</a><span class="connected-user">'.$user->getUsername().'</span>';
			        }
			        else echo '<a href="/login">Connexion</a>';
		        ?>
            </button>
            <button class="ask">
                <a href="/question/add">Poser</a><span class="ask-question">une question</span>
            </button>
        </div>
    </div>
</header>
<?php
	if (isset($_SESSION['code'])) {
		$code_array = parse_ini_file(PATH_MODELS."code.ini", true);
		$codeType = substr($_SESSION['code'], 0, 1);
		$code = substr($_SESSION['code'], 1, 2);
		$message = $code_array[$codeType][$code];
		if ($codeType === "S") {
		    $strongMessage = "Succès";
			$class = "alert-success";
		} else if ($codeType === "E") {
			$strongMessage = "Attention";
			$class = "alert-danger";
        }
		
		echo '<div class="alert '.$class.' alert-dismissible fade in">';
		    echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
		    echo '<strong>'.$strongMessage.'!</strong> '.$message;
		echo '</div>';
		unset($_SESSION['code']);
    }
?>