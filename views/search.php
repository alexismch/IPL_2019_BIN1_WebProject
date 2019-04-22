<div class="search">
    <h1 class="title">Résultat: <?php echo $notification?></h1>

    <?php

    foreach ($this->_questions as $i => $question){
            echo'<a href="/question/' .$question['question_id'].'/'.$this->_global['fn']->clean($question['title']) . '">' . $question['title'] . '</a>';#changer le cleantitle///

        }



    ?>
</div>
