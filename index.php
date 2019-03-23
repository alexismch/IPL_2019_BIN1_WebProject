<?php
	require_once ("models/config.php");
	
	require_once (PATH_VIEWS."global/head.php");
	
	switch ($_GET['page']) {
		case "error" :
			require_once (PATH_CONTROLLERS."errorController.php");
			break;
		
		case "login" :
			require_once (PATH_CONTROLLERS."loginController.php");
			break;
			
		case "register" :
			require_once (PATH_CONTROLLERS."registerController.php");
			break;
			
		case "category" :
			require_once (PATH_CONTROLLERS."categoryController.php");
			break;
			
		case "question" :
			require_once (PATH_CONTROLLERS."questionController.php");
			break;
			
		case "search" :
			require_once (PATH_CONTROLLERS."searchController.php");
			break;
			
		case "user" :
			require_once (PATH_CONTROLLERS."userController.php");
			break;
			
		case "index" :
		default :
			require_once (PATH_CONTROLLERS."indexController.php");
			break;
	}
	
	require_once (PATH_VIEWS."global/footer.php");