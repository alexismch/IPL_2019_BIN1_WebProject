<div class="search">
    <h1 class="title">Résultat: <?php echo $notification?></h1>


    <?php

        foreach ($_questions as $i => $question){
            echo'<a href="/question/' .$question['question_id'].'/'. $cleanTitle . '">' . $question['title'] . '</a>';

        }



    ?>
</div>
