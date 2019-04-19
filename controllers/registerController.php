<?php
	class registerController {
		private $_global;
		
		public function __construct($global) {
			$this->_global = $global;
			require_once (PATH_VIEWS."heads/registerHead.php");
		}

        /**
         *
         */
        public function run(){
		    $notification='';
		    if(!empty($_POST['form_register'])) {
                if (empty($_POST)) {
                    $notification = 'enregistrer-vous';
                }
                elseif (empty($_POST(['nom']))) {
                    $notification = 'Completez votre nom';
                }
                 elseif (empty($_POST(['prenom']))) {
                    $notification = 'Completez votre prenom';
                } elseif (empty($_POST(['nom_dutilisateur']))) {
                    $notification = 'Completez votre nom d utilisateur';
                } elseif (empty($_POST(['motdepass']))) {
                    $notification = 'introduisez un mot de pass';
                } elseif (empty($_POST(['motdepass']))) {
                    $notification = 'introduisez un mot de pass';
                } elseif (empty($_POST(['mail']))) {
                    $notification = 'introduisez un mail';
                } else {
                    if ($this->_global->insert_utilisateur($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['nom_dutilisateur'], $_POST['motdepass'])) {
                        $notification = 'inscription validé';
                    } else {
                        $notification = 'l \'inscription n \' a pas pus ce faire';
                    }

                }
            }







            require_once(PATH_VIEWS.'register.php');
        }
	}
