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
			$cats = $request->fetchAll();
			$request->closeCursor();
			return $cats;
		}
		
		public function getCategory($referer) {
			$request = $this->_db->prepare("SELECT * FROM class_not_found.categories c WHERE c.link_referer = :referer");
			$request->bindValue('referer', $referer, PDO::PARAM_STR);
			$request->execute();
			$cat = $request->fetch();
			$request->closeCursor();
			return $cat;
		}
		
		public function getCategoryById($category_id){
            $request = $this->_db->prepare("SELECT c.name,c.link_referer FROM class_not_found.categories c WHERE c.category_id = :category_id");
            $request->bindValue("category_id",$category_id,PDO::PARAM_INT);
            $request->execute();
		    $cat = $request->fetch();
			$request->closeCursor();
			return $cat;
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
			$quests = $request->fetchAll();
			$request->closeCursor();
			return $quests;
		}

        public function getQuestionsSearch($keyWord){#find all the question who contain the keyWord
            $request= $this->_db->prepare("SELECT q.*
							FROM class_not_found.questions q
							WHERE q.title LIKE '%$keyWord%'
	  					ORDER BY q.creation_date DESC");


            $request->execute();
	        $quests =  $request->fetchAll();
	        $request->closeCursor();
			return $quests;
        }
        
        public function getQuestionsUser($userID){
            $request= $this->_db->prepare("SELECT q.*
							FROM class_not_found.questions q
							WHERE q.user_id=:userID
	  					ORDER BY q.creation_date DESC");

            $request->bindValue("userID",$userID,PDO::PARAM_INT);
            $request->execute();
            $quests =  $request->fetchAll();
	        $request->closeCursor();
			return $quests;
        }
        
		public function getQuestion($id) {
			$request = $this->_db->prepare("SELECT q.*, u.username, c.name AS category_name
					FROM class_not_found.questions q, class_not_found.categories c, class_not_found.users u
					WHERE q.question_id = :id AND c.category_id = q.category_id AND q.user_id = u.user_id");
			$request->bindValue('id', $id, PDO::PARAM_INT);
			$request->execute();
			$quest =  $request->fetch();
			$request->closeCursor();
			return $quest;
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
			$return =  $request->fetchAll();
			$request->closeCursor();
			return $return;
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
			$result = [];
			foreach ($resultTemp AS $key => $value) {
				$result[$value['answer_id']] = $value['value'];
			}
			$request->closeCursor();
			return $result;
		}
		
        public function getUser($username) {
            $request = $this->_db->prepare("SELECT * FROM class_not_found.users u WHERE u.username = :username");
            $request->bindValue('username', $username, PDO::PARAM_STR);
            $request->execute();
            $user = $request->fetch();
            if ($user == null) return null;
            $user = new User($user['user_id'], $user['name'], $user['firstname'], $user['username'], $user['email'], $user['passwd'], $user['isLocked'], $user['isAdmin']);
	        $request->closeCursor();
	        return $user;
        }
        
        public function getOwnerByAnswer($answerId) {
			$request = $this->_db->prepare("SELECT u.username FROM class_not_found.users u, class_not_found.questions q, class_not_found.answers a
					WHERE a.answer_id = :answerId
					AND q.question_id = a.question_id
					AND u.user_id = q.user_id");
			$request->bindValue("answerId", $answerId, PDO::PARAM_INT);
			$request->execute();
			$username = $request->fetch()['username'];
	        $request->closeCursor();
	        return $username;
        }
        
        public function getQuestionByAnswer($answerId) {
	        $request = $this->_db->prepare("SELECT q.question_id FROM class_not_found.questions q, class_not_found.answers a
					WHERE a.answer_id = :answerId
					AND q.question_id = a.question_id");
	        $request->bindValue("answerId", $answerId, PDO::PARAM_INT);
	        $request->execute();
	        $id = $request->fetch()['question_id'];
	        $request->closeCursor();
	        return $id;
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
	        $request->closeCursor();
        }
		
		public function autoChangeStateQuestionOf($answerId) {
			$request = $this->_db->prepare("UPDATE class_not_found.questions q, (SELECT a.question_id
					                                    FROM class_not_found.answers a
					                                    WHERE a.answer_id = :answerId) AS questionId
					SET q.state = IF(q.state = 'd', 'd', IF(q.correct_answer_id IS NULL, 'o', 's'))
					WHERE q.question_id = questionId.question_id");
			$request->bindValue('answerId', $answerId, PDO::PARAM_INT);
			$request->execute();
			$request->closeCursor();
		}
		
		public function changeStateQuestion($questionId, $state) {
			$request = $this->_db->prepare("UPDATE class_not_found.questions q SET q.state = :state WHERE q.question_id = :questionId");
			$request->bindValue('state', $state, PDO::PARAM_STR_CHAR);
			$request->bindValue('questionId', $questionId, PDO::PARAM_INT);
			$request->execute();
			$request->closeCursor();
		}
        
        public function addAnswer($questionId, $answer) {
			if (strlen($answer) < 20) return false;
			$request = $this->_db->prepare("INSERT INTO class_not_found.answers (creation_date, subject, question_id, user_id)
					VALUES (NOW(), :answer, :questionId, :userId)");
			$request->bindValue("answer", nl2br(htmlspecialchars($answer)), PDO::PARAM_STR);
			$request->bindValue("questionId", $questionId, PDO::PARAM_INT);
			$user = unserialize($_SESSION['user']);
			$request->bindValue("userId", $user->getId(), PDO::PARAM_INT);
			$request->execute();
	        $request->closeCursor();
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
	        $request->closeCursor();
        }

        public function setDuplicated($question_id, $referer_question_id){
            $request=("UPDATE questions SET referer_question_id = :refererId WHERE question_id = :questionId");
            $ps = $this->_db->prepare($request);
            $ps->bindValue('refererId', $referer_question_id, PDO::PARAM_INT);
            $ps->bindValue('questionId', $question_id, PDO::PARAM_INT);
            $ps->execute();
            $this->changeStateQuestion($question_id, 'd');
		    return true;
        }
        
        public function setOpen($question_id){
            $request=("UPDATE questions SET referer_question_id = NULL, correct_answer_id=NULL WHERE question_id = :questionId");
            $ps = $this->_db->prepare($request);
            $ps->bindValue('questionId', $question_id, PDO::PARAM_INT);
            $ps->execute();
            $this->changeStateQuestion($question_id, 'o');

            return true;
        }
        
        public function deleteVotes($question_id){
            $query=("DELETE FROM votes  WHERE votes.answer_id IN (SELECT answer_id FROM answers WHERE question_id= :question_id)");
            $ps=$this->_db->prepare($query);
            $ps->bindValue('question_id',$question_id,PDO::PARAM_INT);
            $ps->execute();
            return true;
        }
        
        public  function setCorrectAnswer($question_id){
		    $query="UPDATE questions SET correct_answer_id=null ";
		    $ps=$this->_db->prepare($query);
		    $ps->execute();
		    return true;
        }
        
        public function deleteAnswers($question_id){
            $query=("DELETE FROM answers WHERE answers.question_id= :question_id");
            $ps=$this->_db->prepare($query);
            $ps->bindValue('question_id',$question_id,PDO::PARAM_INT);
            $ps->execute();
            return true;
        }
        
        public function deleteQuestion($question_id){
		    $request=("DELETE FROM questions WHERE questions.question_id= :question_id");
		    $ps=$this->_db->prepare($request);
		    $ps->bindValue('question_id',$question_id,PDO::PARAM_INT);
		    if($this->setCorrectAnswer($question_id)){
		        if($this->deleteVotes($question_id)){
		            if($this->deleteAnswers($question_id)){
                        $ps->execute();
                        return true;
                    }
                }
            }

		    return false;

        }
        
        public function insertUser($name, $firstname, $email, $username, $pwd) {
			if ($username === "all") return "Vous ne pouvez choisir ce nom d'utilisateur...";
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
        
        public function getAllUsers(){
            $query='SELECT u.* from class_not_found.users u ORDER BY u.username ASC ';
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
        
        public function addQuestion($title, $category, $subject) {
			$user = unserialize($_SESSION['user']);
			$request = $this->_db->prepare("INSERT INTO class_not_found.questions (title, category_id, subject, creation_date, user_id) VALUES (:title, :cat, :subject, NOW(), :userId)");
			$request->bindValue('title', nl2br(htmlspecialchars($title)), PDO::PARAM_STR);
			$request->bindValue('cat', $category, PDO::PARAM_INT);
			$request->bindValue('subject', nl2br(htmlspecialchars($subject)), PDO::PARAM_STR);
			$request->bindValue('userId', $user->getId(), PDO::PARAM_INT);
			$request->execute();
			$request->closeCursor();
			$request = $this->_db->prepare("SELECT q.question_id FROM class_not_found.questions q WHERE q.title = :title");
			$request->bindValue('title', $title, PDO::PARAM_STR);
			$request->execute();
			$id = $request->fetch()['question_id'];
			$request->closeCursor();
			return (int) $id;
        }
        
        public function editQuestion($id, $title, $category, $subject, $state) {
			$request = $this->_db->prepare("UPDATE class_not_found.questions q
					SET q.title = :title, q.subject = :subject, q.state = :state, q.category_id = :category
					WHERE q.question_id = :questionId");
			$request->bindValue('title', nl2br(htmlspecialchars($title)), PDO::PARAM_STR);
			$request->bindValue('subject', nl2br(htmlspecialchars($subject)), PDO::PARAM_STR);
			$request->bindValue('state', $state, PDO::PARAM_STR_CHAR);
			$request->bindValue('category', $category, PDO::PARAM_INT);
			$request->bindValue('questionId', $id, PDO::PARAM_INT);
			$request->execute();
			$request->closeCursor();
        }
	}