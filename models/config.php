<?php
	/*
	 * Define paths for MVC
	 */
	session_start();
	define('PATH_VIEWS', 'views/');
	define('PATH_CONTROLLERS', 'controllers/');
	define('PATH_MODELS', 'models/');
	define('PATH_ASSETS', 'http://'.$_SERVER['HTTP_HOST'].'/'.PATH_VIEWS);
	
	/*
	 * Autoload classes
	 */
	function autoLoadClass($class) {
		require_once (PATH_MODELS.'classes/'.$class.'.class.php');
	}
	spl_autoload_register('autoLoadClass');
	
	$global['db'] = Db::getInstance();
	$global['fn'] = new GlobalFunctions();