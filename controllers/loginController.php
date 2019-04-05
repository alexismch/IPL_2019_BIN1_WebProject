<?php
	class LoginController{
		private $_global;
		
		public function __construct($global) {
			$this->_global = $global;
		    require_once (PATH_VIEWS."heads/loginHead.php");
	    }
	
	    public function run(){

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
	        } elseif (!$this->_global['db']->valider_utilisateur($_POST['username'],$_POST['pwd'])) {
	            # L'authentification n'est pas correcte
	            $notification='Vos données d\'authentification ne sont pas correctes.';
	        } else {
	            # L'utilisateur est bien authentifié
	            # Une variable de session $_SESSION['authenticated'] est créée
	            $_SESSION['authentifie'] = 'autorise';
	            $_SESSION['login'] = $_POST['username'];
	            # Redirection HTTP pour demander la page admin
	            header("Location: index.php?action=admin");
	            die();
	        }
	
	
	        require_once(PATH_VIEWS.'login.php');
	    }
	
	}