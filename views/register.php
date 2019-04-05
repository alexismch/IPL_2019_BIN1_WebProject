
	/**
	 * Created by PhpStorm.
	 * User.class: alexismichiels
	 * Date: 2019-03-21
	 * Time: 15:35
	 */

    <section div class="Sing_in">
        <h2>Register</h2>
        <p>Inscription.</p>
        <div id="notification"><?php echo $notification; ?></div>
        <div class="formulaire_inscription">
            <form action="?action=login" method="post">

                <p> Nom: <input type="text" name="nom" /></p>
                <p> prenom: <input type="text" name="prenom" /></p>






                <p>pseudo : <input type="text" name="nom_dutilisateur" /></p>
                <p>Mot de passe : <input type="password" name="motdepasse" /></p>
                <p> Verification du mot de passe: <input type="password" name="motdepasse_verif" /></p>
                <p> e-mail: <input type="text" name="mail" /></p>
                <p><input type="submit" name="form_login" value="S'inscrire"></p>
            </form>
        </div>
    </section>
