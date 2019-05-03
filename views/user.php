<div class=" user">



    <?php if(!empty($_SESSION['isConnected'])&&$_SESSION['isAdmin']){?>
        <form action="?action=suspendre"  method="POST">
            <?php if($this->_user->isLocked()==0){ ?>
                <input type="hidden" id="suspendre" name="suspendre" value="Suspendre">
                <input type="submit" class="btn btn-info" value="suspendre">
            <?php }else{ ?>
                <input type="hidden" id="enLigne" name="enLigne" value="enLigne">
                <input type="submit" class="btn btn-info" value="enLigne">

            <?php }?>


        </form>

        <form action="?action=Admin"  method="POST">
            <?php if($this->_user->isAdmin()==0){ ?>
                <input type="hidden" id="admin" name="Admin" value="admin">
                <input type="submit" class="btn btn-info" value="   Admin    ">
            <?php }else{ ?>
                <input type="hidden" id="Membre" name="Membre" value="Membre">
                <input type="submit" class="btn btn-info" value="   Membre    ">
            <?php }?>
        </form>
    <?php }?>

    <h2>fiche de: <?php echo $this->_user->getUsername(); ?></h2>
    <p>
        <table class="table table-bordered">
        <thead>
        <tr>
            <th>categorie</th>
            <th>Titre</th>

        </tr>
        </thead>
        <tbody>
        <?php
            foreach($this->_questions as $i =>$question){

                echo'<tr>';


                echo'<td><a href="/category/' .userController::getCategory($question['category_id'])[0]. '"><h3>' . userController::getCategory($question['category_id'])[0]. '</h3></a>.</td>';

                echo'<td><a href="/question/' .$question['question_id'].'/'.$this->_global['fn']->clean($question['title']) . '"><h3>' . $question['title'] . '</h3></a>.</td>';
                echo'</tr>';




            }

        ?>

        </tbody>
    </table>
    </table>


    <?php if(!empty($_SESSION['isConnected'])&&$_SESSION['isAdmin']){?>


        <form action="?action=allUser" method="POST">
            <input type="hidden" id="allUsers" name="allUsers" value="allUsers">

            <input type="submit" class="btn btn-secondary" value="   Afficher tous les utilisateurs    ">
        </form>


    <?php } ?>

</div>