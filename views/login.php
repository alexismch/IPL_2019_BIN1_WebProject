<?php
    if (isset($errorMessage)) {
        echo '<div class="alert alert-danger alert-dismissible fade in">';
            echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
            echo '<strong>Attention!</strong> '.$errorMessage;
        echo '</div>';
    }
?>
<div class="login">
    <div class="login-section">
        <form class="login-form" method="POST">
            <h2>Se connecter</h2>
            <div class="form-section" id="username-section">
                <input type="text" name="username" id="username" autocomplete="off" required>
                <label for="username">Nom d'utilisateur</label>
            </div>
            <div class="form-section" id="passwd-section">
                <input type="password" name="passwd" id="passwd" required>
                <label for="passwd">Mot de passe</label>
            </div>
            <div id="submit-section">
                <button type="submit" name="login">Connexion</button>
            </div>
            <div id="register-section">
                <a href="/register">Pas encore inscrit ?</a>
            </div>
        </form>
    </div>
</div>