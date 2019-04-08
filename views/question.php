<div class="question">
    <h1 class="title"><?php echo $this->_question['title']?></h1>
    <h4 class="author">par <a href="/user/<?php echo $this->_question['username']?>"><?php echo $this->_question['username']?></a>... le <?php echo $this->_question['creation_date'] ?></h4>
    <button class="category"><a href="/category/<?php echo $this->_global['fn']->clean($this->_question['category_name'])?>"><?php echo $this->_question['category_name']?></a></button>
    <p><?php echo $this->_question['subject']?></p>
</div>
<div class="horizontal-separator"></div>
<div class="answers">
    <?php
        foreach ($this->_answers as $key => $value) {
            echo '<div class="answer">';
                echo '<div class="vote">';
                    echo '<a href="/answer/'.$value['answer_id'].'/vote/up"><span class="glyphicon glyphicon-thumbs-up"></span></a>';
                    echo '<span>'.$value['nbrVotes'].'</span>';
                    echo '<a href="/answer/'.$value['answer_id'].'/vote/down"><span class="glyphicon glyphicon-thumbs-down"></span></a>';
                echo '</div>';
                echo '<div>';
                    echo '<h4>de <a href="/user/'.$value['username'].'">'.$value['username'].'</a></h4>';
                    echo '<p>'.$value['subject'].'</p>';
                echo '</div>';
            echo '</div>';
            echo '<div class="horizontal-separator"></div>';
        }
    ?>
</div>