<div class=" user">

    <h2>fiche de: <?php echo $this->_user->getName(); ?> <?php echo $this->_user->getFirstName(); ?></h2>

    <p>
        <?php
            foreach($this->_questions as $i =>$question){
                echo'<a href="/question/' .$question['question_id'].'/'.$this->_global['fn']->clean($question['title']) . '"><h3>' . $question['title'] . '</h3></a></br>';
            }

        ?>
    </p>
    <?php if(!empty($_SESSION['isConnected'])&&$_SESSION['isAdmin']){?>
    <form action="?action=suspendre" method="post">
        <?php if($this->_user->isLocked()==0){ ?>
        <input type="hidden" id="suspendre" name="suspendre" value="Suspendre">
            <input type="submit" value="suspendre">
        <?php }else{ ?>
        <input type="hidden" id="enLigne" name="enLigne" value="enLigne">
            <input type="submit" value="enLigne">
        <?php }?>


    </form>
<?php }?>
    <?php if(!empty($_SESSION['isConnected'])&&$_SESSION['isAdmin']){?>
        <form action="?action=Admin" method="post">
            <?php if($this->_user->isAdmin()==0){ ?>
            <input type="hidden" id="admin" name="Admin" value="admin">
            <input type="submit" value="   Admin    ">
            <?php }else{ ?>
                <input type="hidden" id="Membre" name="Membre" value="Membre">
                <input type="submit" value="   Membre    ">
            <?php }?>
        </form>
    <?php }?>

    <?php if(!empty($_SESSION['isConnected'])&&$_SESSION['isAdmin']){?>
         <form action="?action=allUser" method="post">
        <input type="hidden" id="allUsers" name="allUsers" value="allUsers">
        <input type="submit" value="   Afficher tous les utilisateurs    ">
         </form>


    <?php } ?>








</div>