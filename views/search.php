<div class="search">
    <h1 class="title">Résultat: <?php echo $notification?></h1>
    <table class="table table-bordered">
    <?php

    foreach ($this->_questions as $i => $question){
        echo'<tr>';
        echo'<td colspan=""><a href="/category/'.$this->_global['db']->getCategoryById($question['category_id'])['link_referer'].'">['.$this->_global['db']->getCategoryById($question['category_id'])['name'].']</a></td>';
        echo'<td><a href="/question/' .$question['question_id'].'/'.$this->_global['fn']->clean($question['title']) . '">' . $question['title'] . '</a></td> ';
        echo'</tr>';
        }



    ?>
    </table>
</div>
