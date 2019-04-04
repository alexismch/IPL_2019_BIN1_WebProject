<?php
	require_once ("models/config.php");
	
	require_once (PATH_VIEWS."global/head.php");
	
	if (!isset($_GET['page'])) $_GET['page'] = "index";
	switch ($_GET['page']) {
		case "error" :
			require_once (PATH_CONTROLLERS."errorController.php");
			$page = new errorController($global);
			break;
		
		case "login" :
			require_once (PATH_CONTROLLERS."loginController.php");
			$page = new LoginController($global);
			break;
			
		case "register" :
			require_once (PATH_CONTROLLERS."registerController.php");
			$page = new registerController($global);
			break;
			
		case "category" :
			require_once (PATH_CONTROLLERS."categoryController.php");
			$page = new categoryController($global);
			break;
			
		case "question" :
			require_once (PATH_CONTROLLERS."questionController.php");
			$page = new questionController($global);
			break;
			
		case "search" :
			require_once (PATH_CONTROLLERS."searchController.php");
			$page = new searchController($global);
			break;
			
		case "user" :
			require_once (PATH_CONTROLLERS."userController.php");
			$page = new userController($global);
			break;
			
		case "index" :
		default :
			require_once (PATH_CONTROLLERS."indexController.php");
			$page = new indexController($global);
		break;
	}
	require_once (PATH_VIEWS."global/menu.php");
	$page->run();
	
	require_once (PATH_VIEWS."global/footer.php");