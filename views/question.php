<div class="question">
    <?php
        if(!empty($_SESSION['isConnected'])&&$_SESSION['isAdmin']) {
            ?>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Duplicate">Dupliquer</button>
                <div class="modal fade" id="Duplicate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="duplicate_Question">Dupliquer la question</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="duplicate-form" action="" method="POST">
                                    <div class="form-section" id="url-section">
                                        <label for="Question_id">Identifiant de la question:</label>
                                        <input type="number" min="0"  name="refererId" id="Question_id" >
                                        <input type="submit" name="duplicate" class="Dubliquer"/>
                                    </div>
                                </form>
                            </div>
            
                        </div>
                    </div>
                </div>
            
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Delete">Supprimer</button>
                <div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="Delete_Question">supprimer la question</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="duplicate-form" action="" method="POST">
                                    <div class="form-section" id="supprimer-section">
                                        <input type="submit" name="delete" value="supprimer"/>
                                    </div>
                                </form>
                            </div>
            
                        </div>
                    </div>
                </div>
            <?php
        }

        if ($isOwner) {
            ?>
                <div class="modal fade" id="myModal" role="dialog" style="transform: translateY(25%)">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Modifier la question</h4>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="/update/question/<?php echo $this->_question['question_id']?>">
                                    <div>
                                        <input name="title" value="<?php echo $this->_question['title']?>">
                                    </div>
                                    <div>
                                    
                                    </div>
                                    <div>
                                        <textarea name="subject"><?php echo $this->_question['subject']?></textarea>
                                    </div>
                                    <div>
                                        <button type="submit">Modifier</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
    
                    </div>
                </div>
	        <?php
        }
    ?>
    <h1 class="title"><?php echo $this->_question['title']?></h1>
    <?php
        if ($isOwner) {
	        echo '<a data-toggle="modal" data-target="#myModal" class="modify-question"><span data-toggle="tooltip" title="Modifier la question" class="glyphicon glyphicon-cog" data-placement="right"></span></a>';
        }
    ?>
    <h4 class="author">par <a href="/user/<?php echo $this->_question['username']?>"><?php echo $this->_question['username']?></a>... le <?php echo $this->_question['creation_date'] ?></h4>
    <button class="state <?php echo ($this->_question['state'] === 'o') ? 'open': 'closed'?>"><?php $code_array = parse_ini_file(PATH_MODELS."code.ini", true); echo $code_array['Q'][$this->_question['state']]?></button>
    <button class="category"><a href="/category/<?php echo $this->_global['fn']->clean($this->_question['category_name'])?>"><?php echo $this->_question['category_name']?></a></button>
    <p><?php echo $this->_question['subject']?></p>
</div>
<div class="horizontal-separator"></div>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<div class="answers">
    <?php
        if (empty($this->_answers)) echo '<div class="no-answer"><h4>Il n\'y a actuellement aucunes réponses...</h4></div>';
        else {
	
	        foreach ($this->_answers as $key => $value) {
		        $isCorrect = $correctAnswer == $value['answer_id'];
		        $for = false;
		        $against = false;
		        if (isset($this->_answersVoted) && isset($this->_answersVoted[$value['answer_id']])) {
			        if ($this->_answersVoted[$value['answer_id']] == 1) $for = true;
			        else if ($this->_answersVoted[$value['answer_id']] == -1) $against = true;
		        }
		        echo '<div class="answer">';
                    echo '<div class="mark-correct">';
                        $a = 'data-toggle="tooltip" data-placement="top"' . (($isCorrect) ? 'class="selected" title="C\'est la bonne réponse"' : 'title="C\'est une réponse normale"');
                        if ($isOwner) $a = 'href="/answer/mark/' . $value['answer_id'] . '/correct" data-toggle="tooltip" data-placement="top"' . (($isCorrect) ? ' class="owned selected" title="Enlever le marquage de bonne réponse"' : ' class="owned" title="Marquer comme bonne réponse"');
                        echo '<a ' . $a . '><span class="glyphicon glyphicon-check"></span></a>';
                    echo '</div>';
                    echo '<div class="vote">';
                        echo '<a href="/answer/vote/' . $value['answer_id'] . '/up"' . (($for) ? ' class="for selected" title="Enlever le vote"' : ' title="Voter pour"') . ' data-toggle="tooltip" data-placement="top"><span class="glyphicon glyphicon-thumbs-up"></span></a>';
                            echo '<span class="nbVotesF">' . $value['nbrVotesF'] . '</span>';
		                    echo '<div class="horizontal-separator-mini"></div>';
		                    echo '<span>' . $value['nbrVotesA'] . '</span>';
                        echo '<a href="/answer/vote/' . $value['answer_id'] . '/down"' . (($against) ? ' class="against selected" title="Enlever le vote"' : ' title="Voter contre"') . ' data-toggle="tooltip" data-placement="bottom"><span class="glyphicon glyphicon-thumbs-down"></span></a>';
                    echo '</div>';
                    echo '<div class="content">';
                        echo '<h4>de <a href="/user/' . $value['username'] . '">' . $value['username'] . '</a></h4>';
                        echo '<p>' . $value['subject'] . '</p>';
                    echo '</div>';
		        echo '</div>';
		        echo '<div class="horizontal-separator"></div>';
	        }
        }
    ?>
    <div class="add-answer">
        <?php
            if ($this->_question['state'] === 'd') {
                ?>
                    <h4>Vous ne pouvez rajouter une réponse à une question dupliquée !</h4>
	            <?php
            } else {
                ?>
                <h4>Ajoutez une réponse !</h4>
                <form id="add-answer" method="POST" action="/answer/add/<?php echo $this->_question['question_id']?>">
                    <input type="hidden" name="questionId" value="<?php echo $this->_question['question_id']?>">
                    <div id="answer-section">
                        <textarea name="answer" placeholder="Soyez clair et précis..." minlength="20" required></textarea>
                    </div>
                    <div id="submit-section">
                        <button type="submit" name="add-answer" value="/answer/add/<?php echo $this->_question['question_id']?>">Ajouter</button>
                    </div>
                </form>
                <?php
            }
        ?>
    </div>
</div>