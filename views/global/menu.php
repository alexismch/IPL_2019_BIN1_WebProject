<header>
    <div class="head-navbar">
        <div class="logo">
            <img src="<?php echo PATH_ASSETS."images/iconeGrey.png" ?>">
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
        <button class="account">
            <?php
	            if (isset($_SESSION['isConnected']) && $_SESSION['isConnected']) echo '<a href="/logout">Déconnexion</a>';
                else echo '<a href="/login">Connexion</a>';
            ?>
        </button>
    </div>
</header>
<?php
	if (isset($_SESSION['code'])) {
        switch (substr($_SESSION['code'], 0, 1)) {
            case "S":
                $strongMessage = "Succès";
                $class = "alert-success";
                switch (substr($_SESSION['code'], 1, 1)) {
                    case "0":
	                    $message = "Vous vous êtes bien connecté...";
	                    break;
	                    
                    case "1":
	                    $message = "Vous vous êtes bien déconnecté...";
	                    break;
                    
                    case "2":
	                    $message = "Vous vous êtes bien inscrit...";
	                    break;
	                    
                    default:
                        $message = "Tout s'est bien passé...";
                }
	            break;
            
            case "E":
                $strongMessage = "Attention";
                $class = "alert-danger";
                switch (substr($_SESSION['code'], 1, 1)) {
                    case "0":
	                    $message = "Vous étiez déjà connecté...";
	                    break;
	                    
                    case "1":
                        $message = "Vous devez être connecté pour pouvoir voter...";
                        break;
	                    
                    default:
                        $message = "Une erreur est survenue...";
                }
                break;
        }
		echo '<div class="alert '.$class.' alert-dismissible fade in">';
		    echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
		    echo '<strong>'.$strongMessage.'!</strong> '.$message;
		echo '</div>';
		unset($_SESSION['code']);
    }
?>