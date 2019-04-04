<?php
	class Db {
		private static $instance = null;
		private $_db;
		
		/**
		 * Db constructor.
		 */
		private function __construct() {
			$ini_array = parse_ini_file(PATH_MODELS."config.ini", true);
			$config['host'] = $ini_array['db']['host']; // Database host
			$config['dbname'] = $ini_array['db']['name']; // Database name
			$config['user'] = $ini_array['db']['user']; // Database username
			$config['pass'] = $ini_array['db']['passwd']; // Database passwd
			$pdo_options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); // PDO options
			
			try {
				$this->_db = new PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'], $config['user'], $config['pass'], $pdo_options); // Create connexion with Database
			} catch (Exception $e) {
				exit('Error : '.$e->getMessage()); // Stop script and show Error
			}
		}
		
		/**
		 * @return instance of Db
		 */
		public static function getInstance() {
			if (is_null(self::$instance))
				self::$instance = new Db();
			return self::$instance;
		}
		
		public function getCategories() {
			$request = $this->_db->prepare("SELECT * FROM class_not_found.categories cat ORDER BY cat.category_id");
			$request->execute();
			return $request->fetchAll();
		}
		
		public function getQuestions() {
			$type = func_get_arg(0);
			if (!empty($type)) {
				switch ($type) {
					case "cat":
						$cat_name = func_get_arg(1);
						$request = $this->_db->prepare("SELECT q.* FROM class_not_found.questions q, class_not_found.categories c
							WHERE c.name = :cat_name
							AND c.category_id = q.category_id
							ORDER BY q.creation_date DESC");
						$request->bindValue('cat_name', $cat_name);
						break;
						
					case "last":
						$request = $this->_db->prepare("SELECT q.question_id, q.title, q.subject, u.username FROM class_not_found.questions q, class_not_found.users u
							WHERE u.user_id = q.user_id
							ORDER BY q.creation_date DESC
							LIMIT 3");
						break;
					
					default:
						return;
				}
			} else {
				$request = $this->_db->prepare("SELECT * FROM class_not_found.questions q ORDER BY q.creation_date DESC");
			}
			$request->execute();
			return $request->fetchAll();
		}
	}