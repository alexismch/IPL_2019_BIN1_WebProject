<?php
	require_once ("models/config.php");
	
	require_once (PATH_VIEWS."global/head.php");
	
	switch ($_GET['page']) {
		case "error" :
			require_once (PATH_CONTROLLERS."errorController.php");
			$page = new errorController($db);
			break;
		
		case "login" :
			require_once (PATH_CONTROLLERS."loginController.php");
			$page = new LoginController($db);
			break;
			
		case "register" :
			require_once (PATH_CONTROLLERS."registerController.php");
			$page = new registerController($db);
			break;
			
		case "category" :
			require_once (PATH_CONTROLLERS."categoryController.php");
			$page = new categoryController($db);
			break;
			
		case "question" :
			require_once (PATH_CONTROLLERS."questionController.php");
			$page = new questionController($db);
			break;
			
		case "search" :
			require_once (PATH_CONTROLLERS."searchController.php");
			$page = new searchController($db);
			break;
			
		case "user" :
			require_once (PATH_CONTROLLERS."userController.php");
			$page = new userController($db);
			break;
			
		case "index" :
		default :
			require_once (PATH_CONTROLLERS."indexController.php");
			$page = new indexController($db);
		break;
	}
	require_once (PATH_VIEWS."global/menu.php");
	$page->run();
	
	require_once (PATH_VIEWS."global/footer.php");