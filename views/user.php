<div class=" user">
    <h2>fiche de: <?php echo $this->_user->getName(); ?> <?php echo $this->_user->getFirstName(); ?></h2>

    <p>
        <?php
            foreach($this->_questions as $i =>$question){
                echo'<a href="/question/' .$question['question_id'].'/'.$this->_global['fn']->clean($question['title']) . '">' . $question['title'] . '</a></br>';
            }

        ?>
    </p>
    <?php if($_SESSION['isAdmin']){?>
    <form action="?action=suspendre" method="post">
        <input type="hidden" id="suspendre" name="suspendre" value="Suspendre">
        <input type="submit" value="send">
    </form>
    <p><?php echo $notification; ?></p>
<?php }?>






</div>