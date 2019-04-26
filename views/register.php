<?php
	if (isset($errorMessage)) {
		echo '<div class="alert alert-danger alert-dismissible fade in">';
		echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
		echo '<strong>Attention!</strong> '.$errorMessage;
		echo '</div>';
	}
?>
<div class="register">
    <div class="register-section">
        <form class="register-form" action="/register" method="POST">
            <h2>S'inscrire</h2>
            <div class="form-section" id="name-section">
                <input type="text" name="name" id="name" autocomplete="off" required <?php if (isset($_POST['name'])) echo 'value ="'.$_POST['name'].'"';?>>
                <label for="name">Nom</label>
            </div>
            <div class="form-section" id="firstname-section">
                <input type="text" name="firstname" id="firstname" autocomplete="off" required <?php if (isset($_POST['firstname'])) echo 'value ="'.$_POST['firstname'].'"';?>>
                <label for="firstname">Prénom</label>
            </div>
            <div class="form-section" id="username-section">
                <input type="text" name="username" id="username" autocomplete="off" required <?php if (isset($_POST['username'])) echo 'value ="'.$_POST['username'].'"';?>>
                <label for="username">Nom d'utilisateur</label>
            </div>
            <div class="form-section" id="passwd-section">
                <input type="password" name="passwd" id="passwd" autocomplete="off" required>
                <label for="passwd">Mot de passe</label>
            </div>
            <div class="form-section" id="passwd-verify-section">
                <input type="password" name="passwd-verify" id="passwd-verify" autocomplete="off" required>
                <label for="passwd-verify">Verif. mot de passe</label>
            </div>
            <div class="form-section" id="mail-section">
                <input type="text" name="mail" id="mail" autocomplete="off" required <?php if (isset($_POST['mail'])) echo 'value ="'.$_POST['mail'].'"';?>>
                <label for="mail">Adresse mail</label>
            </div>
            <div id="submit-section">
                <button type="submit" name="register">S'inscrire</button>
            </div>
            <div id="login-section">
                <a href="/login">Déjà inscrit ?</a>
            </div>
        </form>
    </div>
</div>