<?php
	class LoginController{
		private $_db;
		
	    public function __construct($db) {
			$this->_db = $db;
		    require_once (PATH_VIEWS."heads/loginHead.php");
	    }
	
	    public function run() {
	        # Si un distrait écrit ?action=login en étant déjà authentifié
	        if (!empty($_SESSION['authentifie'])) {
	            header("Location: index.php?action=admin"); # redirection HTTP vers l'action login
	            die();
	        }
	
	        # Variables HTML dans la vue
	        $notification='';
	
	        # L'utilisateur s'est-il bien authentifié ?
	        if (empty($_POST)) {
	            # L'utilisateur doit remplir le formulaire
	            $notification='Authentifiez-vous';
	        } elseif (($_POST['nomdutilisateur']!='C' || $_POST['motdepasse']!='3PO')) {
	            # L'authentification n'est pas correcte
	            $notification='Vos données d\'authentification ne sont pas correctes.';
	        } else {
	            # L'utilisateur est bien authentifié
	            # Une variable de session $_SESSION['authenticated'] est créée
	            $_SESSION['authentifie'] = 'autorise';
	            $_SESSION['login'] = $_POST['nomdutilisateur'];
	            # Redirection HTTP pour demander la page admin
	            header("Location: index.php?action=admin");
	            die();
	        }
	
	
	        require_once(PATH_VIEWS.'login.php');
	    }
	
	}