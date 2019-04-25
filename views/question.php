<div class="question">
    <h1 class="title"><?php echo $this->_question['title']?></h1>
    <h4 class="author">par <a href="/user/<?php echo $this->_question['username']?>"><?php echo $this->_question['username']?></a>... le <?php echo $this->_question['creation_date'] ?></h4>
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
    </div>
</div>