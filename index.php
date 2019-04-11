<?php
	require_once ("models/config.php");
	
	require_once (PATH_VIEWS."global/head.php");
	
	if (!isset($_GET['page'])) $_GET['page'] = "index";
	switch ($_GET['page']) {
		case "error" :
			$page = pageError($global, $_SERVER['REDIRECT_STATUS']);
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
	function pageError($global, $code) {
		require_once (PATH_CONTROLLERS."errorController.php");
		return new errorController($global, $code);
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
		require_once (PATH_CONTROLLERS."categoryController.php");
		try {
			return new categoryController($global);
		} catch (Error $error) {
			return pageError($global, $error->getMessage());
		}
	}
	
	function pageQuestion($global) {
		require_once (PATH_CONTROLLERS."questionController.php");
		try {
			return new questionController($global);
		} catch (Error $error) {
			return pageError($global, $error->getMessage());
		}
	}
	
	function pageSearch($global) {
		require_once (PATH_CONTROLLERS."searchController.php");
		return new searchController($global);
	}
	
	function pageUser($global) {
		require_once (PATH_CONTROLLERS."userController.php");
		return new userController($global);
	}
	
	function pageIndex($global) {
		require_once (PATH_CONTROLLERS."indexController.php");
		return new indexController($global);
	}
	
	function pageAnswer($global) {
		require_once(PATH_CONTROLLERS . "answerController.php");
		return new answerController($global);
	}