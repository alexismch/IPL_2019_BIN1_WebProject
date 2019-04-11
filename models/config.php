<?php
	/*
	 * Define paths for MVC
	 */
	session_start();
	define('PATH_VIEWS', 'views/');
	define('PATH_CONTROLLERS', 'controllers/');
	define('PATH_MODELS', 'models/');
	define('PATH_ASSETS', 'http://'.$_SERVER['HTTP_HOST'].'/'.PATH_VIEWS);
	define("HOSTNAME", $_SERVER['HTTP_HOST']);
	
	$referer = substr($_SERVER['HTTP_REFERER'], 0, strpos($_SERVER['HTTP_REFERER'], "?"));
	
	$_SERVER['HTTP_REFERER'] = (empty($referer)) ? $_SERVER['HTTP_REFERER'] : $referer;

	$statement = "http://".HOSTNAME.(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "/");
	
	if ($_SERVER['HTTP_REFERER'] === $statement) $_SERVER['HTTP_REFERER'] = "/";
	else $_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
	if (empty($_SESSION['referer'])) $_SESSION['referer'] = "/";
	
	/*
	 * Autoload classes
	 */
	function autoLoadClass($class) {
		require_once (PATH_MODELS.'classes/'.$class.'.class.php');
	}
	spl_autoload_register('autoLoadClass');
	
	$global['db'] = Db::getInstance();
	$global['fn'] = new GlobalFunctions();