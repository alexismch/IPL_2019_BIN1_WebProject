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
						$request = $this->_db->prepare("SELECT q.*
							FROM class_not_found.questions q, class_not_found.categories c
							WHERE c.name = :cat_name
							AND c.category_id = q.category_id
							ORDER BY q.creation_date DESC");
						$request->bindValue('cat_name', $cat_name, PDO::PARAM_STR);
						break;
						
					case "nbr":
						$nbr = func_get_arg(1);
						$request = $this->_db->prepare("SELECT q.question_id, q.title, q.subject, u.username
							FROM class_not_found.questions q, class_not_found.users u
							WHERE u.user_id = q.user_id
							ORDER BY q.creation_date DESC
							LIMIT :nbr");
						$request->bindValue('nbr', $nbr, PDO::PARAM_INT);
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
		
		public function getQuestion($id) {
			$request = $this->_db->prepare("SELECT q.*, u.username, c.name AS category_name
					FROM class_not_found.questions q, class_not_found.categories c, class_not_found.users u
					WHERE q.question_id = :id AND c.category_id = q.category_id AND q.user_id = u.user_id");
			$request->bindValue('id', $id, PDO::PARAM_INT);
			$request->execute();
			return $request->fetch();
		}
		
		public function getAnswers($questionId) {
			$request = $this->_db->prepare("SELECT SUM(v.value) AS nbrVotes, a.*, u.username
				FROM class_not_found.votes v, class_not_found.answers a, class_not_found.users u
				WHERE a.question_id = :questionId
				AND v.answer_id = a.answer_id
				AND a.user_id = u.user_id
				GROUP BY answer_id
				ORDER BY a.creation_date");
			$request->bindValue('questionId', $questionId, PDO::PARAM_INT);
			$request->execute();
			return $request->fetchAll();
		}
		
        public function select_user() {
            $query = 'SELECT * FROM user ORDER BY no ASC';
            $ps = $this->_db->prepare($query);
            $ps->execute();
            $tableau = array();
            while ($row = $ps->fetch()) {
                $tableau[] = new User($row->no,$row->username,$row->pwd);
            }
            # var_dump($tableau);
            return $tableau;
        }
        
        public function valider_utilisateur($username,$pwd) {
            $query = 'SELECT mdp from user WHERE username=:username';
            $ps = $this->_db->prepare($query);
            $ps->bindValue(':username',$username);
            $ps->execute();
            if ($ps->rowcount() == 0)
                return false;
            $hash = $ps->fetch()->pwd;
            return password_verify($pwd, $hash);
        }
        
        public function insert_utilisateur($username,$pwd) {
            $query = 'INSERT INTO user (username,pwd) values (:username,:pwd)';
            $ps = $this->_db->prepare($query);
            $ps->bindValue(':username',$username);
            $ps->bindValue(':pwd',$pwd);
            return $ps->execute();
        }
        
        public function username_exist($username) {
            $query = 'SELECT * from user WHERE username=:username';
            $ps = $this->_db->prepare($query);
            $ps->bindValue(':username',$username);
            $ps->execute();
            return ($ps->rowcount() != 0);
        }
	}