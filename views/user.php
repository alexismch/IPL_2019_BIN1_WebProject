<div class=" user">
    <h2>fiche de: <?php echo $this->_user->getName() ?> <?php echo $this->_user->getFirstName() ?> la plus belle personne</h2>

    <p>
        <?php
            foreach($this->_questions as $i =>$question){
                echo'<a href="/question/' .$question['question_id'].'/'.$this->_global['fn']->clean($question['title']) . '">' . $question['title'] . '</a></br>';
            }

        ?>
    </p>








</div>