<?php
	require_once (PATH_VIEWS."heads/indexHead.php");

	require_once (PATH_VIEWS."global/menu.php");
	
	$categories = $db->getCategories();
	$randomCategories = array_rand($categories, 3);
	$lastQuestions = $db->getQuestions('last');

	require_once (PATH_VIEWS."index.php");