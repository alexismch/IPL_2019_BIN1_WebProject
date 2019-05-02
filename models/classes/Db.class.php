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
		
		public function getCategory($referer) {
			$request = $this->_db->prepare("SELECT * FROM class_not_found.categories c WHERE c.link_referer = :referer");
			$request->bindValue('referer', $referer, PDO::PARAM_STR);
			$request->execute();
			return $request->fetch();
		}
		
		public function getQuestions() {
			$type = func_get_arg(0);
			if (!empty($type)) {
				switch ($type) {
					case "cat":
						$referer = func_get_arg(1);
						$request = $this->_db->prepare("SELECT q.question_id, q.title, q.subject, u.username
							FROM class_not_found.questions q, class_not_found.categories c, class_not_found.users u
							WHERE c.link_referer = :referer
							AND c.category_id = q.category_id
							AND u.user_id = q.user_id
							ORDER BY q.creation_date DESC");
						$request->bindValue('referer', $referer, PDO::PARAM_STR);
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

        public function getQuestionsSearch($keyWord){#find all the question who contain the keyWord
            $request= $this->_db->prepare("SELECT q.*
							FROM class_not_found.questions q
							WHERE q.title LIKE '%$keyWord%'
	  					ORDER BY q.creation_date DESC");


            $request->execute();
            return $request->fetchAll();
        }
        
        public function getQuestionsUser($userID){
            $request= $this->_db->prepare("SELECT q.*
							FROM class_not_found.questions q
							WHERE q.user_id=$userID
	  					ORDER BY q.creation_date DESC");


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
			$request = $this->_db->prepare("SELECT DISTINCT a.*, u.username, coalesce(COUNT(vF.value), 0) AS nbrVotesF, coalesce(COUNT(vA.value), 0) AS nbrVotesA
					FROM class_not_found.answers a
					         JOIN class_not_found.users u ON u.user_id = a.user_id
					         LEFT JOIN class_not_found.votes vF ON vF.answer_id = a.answer_id AND vF.value > 0
					         LEFT JOIN class_not_found.votes vA ON vA.answer_id = a.answer_id AND vA.value < 0
					WHERE a.question_id = :questionId
					GROUP BY a.answer_id");
			$request->bindValue('questionId', $questionId, PDO::PARAM_INT);
			$request->execute();
			return $request->fetchAll();
		}
		
		public function getAnswersVoted($questionId) {
			$request = $this->_db->prepare("SELECT  v.answer_id, v.value
				FROM class_not_found.votes v, class_not_found.answers a
				WHERE v.answer_id = a.answer_id
				AND a.question_id = :questionId
				AND v.user_id = :userId");
			$request->bindValue("questionId", $questionId, PDO::PARAM_INT);
			$user = unserialize($_SESSION['user']);
			$request->bindValue("userId", $user->getId(), PDO::PARAM_INT);
			$request->execute();
			$resultTemp = $request->fetchAll();
			foreach ($resultTemp AS $key => $value) {
				$result[$value['answer_id']] = $value['value'];
			}
			return $result;
		}
		
        public function getUser($username) {
            $request = $this->_db->prepare("SELECT * FROM class_not_found.users u WHERE u.username = :username");
            $request->bindValue('username', $username, PDO::PARAM_STR);
            $request->execute();
            $user = $request->fetch();
            if ($user == null) return null;
            $user = new User($user['user_id'], $user['name'], $user['firstname'], $user['username'], $user['email'], $user['passwd'], $user['isLocked'], $user['isAdmin']);
            return $user;
        }
        
        public function getOwnerByAnswer($answerId) {
			$request = $this->_db->prepare("SELECT u.username FROM class_not_found.users u, class_not_found.questions q, class_not_found.answers a
					WHERE a.answer_id = :answerId
					AND q.question_id = a.question_id
					AND u.user_id = q.user_id");
			$request->bindValue("answerId", $answerId, PDO::PARAM_INT);
			$request->execute();
			return $request->fetch()['username'];
        }
        
        public function getQuestionByAnswer($answerId) {
	        $request = $this->_db->prepare("SELECT q.question_id FROM class_not_found.questions q, class_not_found.answers a
					WHERE a.answer_id = :answerId
					AND q.question_id = a.question_id");
	        $request->bindValue("answerId", $answerId, PDO::PARAM_INT);
	        $request->execute();
	        return $request->fetch()['question_id'];
        }
        
        public function markCorrectAnswer($answerId) {
			$questionId = $this->getQuestionByAnswer($answerId);
			$request = $this->_db->prepare("UPDATE class_not_found.questions q, (SELECT q.correct_answer_id AS id
                                     FROM class_not_found.questions q
                                     WHERE q.question_id = :questionId) AS correctAnswer
					SET q.correct_answer_id = IF(correctAnswer.id IS NULL, :correctAnswer, IF(correctAnswer.id <> :correctAnswer, :correctAnswer, null))
					WHERE q.question_id = :questionId");
			$request->bindValue("questionId", $questionId, PDO::PARAM_INT);
			$request->bindValue("correctAnswer", $answerId, PDO::PARAM_INT);
			$request->execute();
			$this->autoChangeStateQuestionOf($answerId);
        }
		
		public function autoChangeStateQuestionOf($answerId) {
			$request = $this->_db->prepare("UPDATE class_not_found.questions q, (SELECT a.question_id
					                                    FROM class_not_found.answers a
					                                    WHERE a.answer_id = :answerId) AS questionId
					SET q.state = IF(q.state = 'd', 'd', IF(q.correct_answer_id IS NULL, 'o', 's'))
					WHERE q.question_id = questionId.question_id");
			$request->bindValue('answerId', $answerId, PDO::PARAM_INT);
			$request->execute();
		}
		
		public function changeStateQuestion($questionId, $state) {
			$request = $this->_db->prepare("UPDATE class_not_found.questions q SET q.state = :state WHERE q.question_id = :questionId");
			$request->bindValue('state', $state, PDO::PARAM_STR_CHAR);
			$request->bindValue('questionId', $questionId, PDO::PARAM_INT);
			$request->execute();
		}
        
        public function addAnswer($questionId, $answer) {
			if (strlen($answer) < 20) return false;
			$request = $this->_db->prepare("INSERT INTO class_not_found.answers (creation_date, subject, question_id, user_id)
					VALUES (NOW(), :answer, :questionId, :userId)");
			$request->bindValue("answer", htmlspecialchars($answer), PDO::PARAM_STR);
			$request->bindValue("questionId", $questionId, PDO::PARAM_INT);
			$user = unserialize($_SESSION['user']);
			$request->bindValue("userId", $user->getId(), PDO::PARAM_INT);
			$request->execute();
			return true;
        }
        
        public function voteForAnswer($answerId, $vote) {
			$request = $this->_db->prepare("INSERT INTO class_not_found.votes (votes.user_id, votes.answer_id, votes.value)
					VALUES (:userId, :answerId, :vote)
					ON DUPLICATE KEY UPDATE votes.user_id = :userId, votes.answer_id = :answerId, votes.value = if((
					  SELECT v.value as value FROM class_not_found.votes v WHERE v.user_id = :userId AND v.answer_id = :answerId) = :vote,
					  0, :vote)");
			$user = unserialize($_SESSION['user']);
			$request->bindValue("userId", $user->getId(), PDO::PARAM_INT);
			$request->bindValue("answerId", $answerId, PDO::PARAM_INT);
			$request->bindValue("vote", $vote, PDO::PARAM_INT);
			$request->execute();
        }

        public function setDuplicated($question_id, $referer_question_id){
            $request=("UPDATE questions SET referer_question_id=$referer_question_id WHERE question_id= $question_id");
            $ps=$this->_db->prepare($request);
            $ps->execute();
		    return true;
        }
        
        public function deleteVotes($question_id){
            $query=("DELETE FROM votes WHERE votes.answer_id=$question_id");
            $ps=$this->_db->prepare($query);
            $ps->execute();
            return true;
        }
        
        public function deleteAnswers($question_id){
            $query=("DELETE FROM answers WHERE answers.question_id=$question_id");
            $ps=$this->_db->prepare($query);
            $ps->execute();
            return true;
        }
        
        public function deleteQuestion($question_id){
		    $request=("DELETE FROM questions WHERE questions.question_id=$question_id");
		    $ps=$this->_db->prepare($request);
		    $ps->execute();
		    return true;
        }
        
        public function insertUser($name, $firstname, $email, $username, $pwd) {
            $query = "INSERT INTO class_not_found.users (users.name,users.firstname,users.username,users.email,users.passwd) values (:name,:firstname,:username,:email,:pwd)";
            $ps = $this->_db->prepare($query);
            $ps->bindValue('name', $name);
            $ps->bindValue('firstname', $firstname);
            $ps->bindValue('username', $username);
            $ps->bindValue('email', $email);
            $ps->bindValue('pwd', password_hash($pwd, PASSWORD_BCRYPT));
            try {
	            $ps->execute();
            } catch (PDOException $error) {
            	$msg = $error->getMessage();
            	if (strpos($msg, 'username')) return "Nom d'utilisateur déjà utilisé...";
	            else if (strpos($msg, 'email')) return "Adresse mail déjà utilisée...";
	            else return "Une erreur est survenue...";
            }
            return true;
        }
        
        public function setLocked($id,$state){
		    $query="UPDATE users SET isLocked=$state WHERE user_id= $id ";

		    $ps=$this->_db->prepare($query);
		    $ps->execute();
		    return true;
        }
        
        public function setAdmin($id,$state){
            $query="UPDATE users SET isAdmin=$state WHERE user_id= $id ";

            $ps=$this->_db->prepare($query);
            $ps->execute();
            return true;
        }
        
        public function getAllUsersName(){
            $query='SELECT u.username from class_not_found.users u ORDER BY u.username DESC ';
            $ps=$this->_db->prepare($query);
            $ps->execute();
            return $ps;
        }

        public function username_exist($username) {
            $query = 'SELECT * from users WHERE username=:username';
            $ps = $this->_db->prepare($query);
            $ps->bindValue(':username',$username);
            $ps->execute();
            return ($ps->rowcount() != 0);
        }
	}