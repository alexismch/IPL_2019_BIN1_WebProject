<?php
	require_once ("models/config.php");
	
	require_once (PATH_VIEWS."global/head.php");
	
	if (!isset($_GET['page'])) $_GET['page'] = "index";
	switch ($_GET['page']) {
		case "error" :
			$code_array = parse_ini_file(PATH_MODELS."code.ini", true);
			$page = pageError($global, $code_array[$_SERVER['REDIRECT_STATUS']], $_SERVER['REDIRECT_STATUS']);
			break;
		
		case "login" :
			$page = pageLogin($global);
			break;
			
		case "register" :
			$page = pageRegister($global);
			break;
			
		case "category" :
			$page = pageCategory($global);
			break;
			
		case "question" :
			$page = pageQuestion($global);
			break;
			
		case "search" :
			$page = pageSearch($global);
			break;
			
		case "user" :
			$page = pageUser($global);
			break;
			
		case "index" :
			$page = pageIndex($global);
			break;
			
		case "answer" :
			$page = pageAnswer($global);
			break;
			
		case "logout" :
			unset($_SESSION['form']);
			unset($_SESSION['user']);
			unset($_SESSION['isConnected']);
			$_SESSION['code'] = "S1";
			header("Location: ".$_SESSION['referer']);
			exit();
			break;
			
		default :
			$page = pageError($global, $_SERVER['REDIRECT_STATUS']);
	}
	require_once (PATH_VIEWS."global/menu.php");
	$page->run();
	
	require_once (PATH_VIEWS."global/footer.php");
	
	  #############################
	 # Functions to create pages #
	#############################
	function pageError($global, $msg, $code) {
		unset($_SESSION['form']);
		require_once (PATH_CONTROLLERS."errorController.php");
		return new errorController($global, $msg, $code);
	}
	
	function pageLogin($global) {
		require_once (PATH_CONTROLLERS."loginController.php");
		return new LoginController($global);
	}
	
	function pageRegister($global) {
		require_once (PATH_CONTROLLERS."registerController.php");
		return new registerController($global);
	}
	
	function pageCategory($global) {
		unset($_SESSION['form']);
		require_once (PATH_CONTROLLERS."categoryController.php");
		try {
			return new categoryController($global);
		} catch (Error $error) {
			return pageError($global, "Catégorie inexistante...", $error->getMessage());
		}
	}
	
	function pageQuestion($global) {
		unset($_SESSION['form']);
		require_once (PATH_CONTROLLERS."questionController.php");
		try {
			return new questionController($global);
		} catch (Error $error) {
			return pageError($global, "Question inexistante...", $error->getMessage());
		}
	}
	
	function pageSearch($global) {
		unset($_SESSION['form']);
		require_once (PATH_CONTROLLERS."searchController.php");
		return new searchController($global);
	}
	
	function pageUser($global) {
		unset($_SESSION['form']);
		require_once (PATH_CONTROLLERS."userController.php");
		try {
			return new userController($global);
		} catch (Error $error) {
			return pageError($global, $error->getMessage(), $error->getCode());
		}
	}
	
	function pageIndex($global) {
		unset($_SESSION['form']);
		require_once (PATH_CONTROLLERS."indexController.php");
		return new indexController($global);
	}
	
	function pageAnswer($global) {
		require_once(PATH_CONTROLLERS . "answerController.php");
		return new answerController($global);
	}