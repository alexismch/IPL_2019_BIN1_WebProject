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
        foreach ($this->_answers as $key => $value) {
            $isCorrect = $correctAnswer == $value['answer_id'];
            $for = false;
            $against = false;
	        if (isset($this->_answersVoted) && isset($this->_answersVoted[$value['answer_id']])) {
                if ($this->_answersVoted[$value['answer_id']] == 1) $for = true;
                else $against = true;
            }
            echo '<div class="answer">';
                echo '<div class="mark-correct">';
	                $a = 'data-toggle="tooltip" data-placement="top"'.(($isCorrect) ? 'class="selected" title="C\'est la bonne réponse"': 'title="C\'est une réponse normale"');
	                if ($isOwner) $a = 'href="/answer/'.$value['answer_id'].'/vote/correct" data-toggle="tooltip" data-placement="top"'.(($isCorrect) ? ' class="owned selected" title="Enlever le marquage de bonne réponse"': ' class="owned" title="Marquer comme bonne réponse"');
	                echo '<a '.$a.'><span class="glyphicon glyphicon-check"></span></a>';
                echo '</div>';
                echo '<div class="vote">';
                    echo '<a href="/answer/'.$value['answer_id'].'/vote/up"'.(($for) ? ' class="selected" title="Enlever le vote"' : ' title="Voter pour"').' data-toggle="tooltip" data-placement="top"><span class="glyphicon glyphicon-thumbs-up"></span></a>';
                    echo '<span>'.$value['nbrVotes'].'</span>';
                    echo '<a href="/answer/'.$value['answer_id'].'/vote/down"'.(($against) ? ' class="selected" title="Enlever le vote"' : ' title="Voter contre"').' data-toggle="tooltip" data-placement="bottom"><span class="glyphicon glyphicon-thumbs-down"></span></a>';
                echo '</div>';
                echo '<div class="content">';
                    echo '<h4>de <a href="/user/'.$value['username'].'">'.$value['username'].'</a></h4>';
                    echo '<p>'.$value['subject'].'</p>';
                echo '</div>';
            echo '</div>';
            echo '<div class="horizontal-separator"></div>';
        }
    ?>
</div>