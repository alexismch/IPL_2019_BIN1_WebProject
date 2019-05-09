<div class="user">
    <div class="test">
    <?php if(!empty($_SESSION['isConnected'])&&$_SESSION['isAdmin']&& $this->_user->getId()!=unserialize($_SESSION['user'])->getId()){?>
        <form action="?action=suspendre"  class="boutton" method="POST">
            <?php if($this->_user->isLocked()==0){ ?>
                <input type="hidden" id="suspendre" name="suspendre" value="Suspendre">
                <input type="submit" class="btn btn-info" value="suspendre">
            <?php }else{ ?>
                <input type="hidden" id="enLigne" name="enLigne" value="enLigne">
                <input type="submit" class="btn btn-info" value="enLigne">
            <?php }?>
        </form>
        <form action="?action=Admin" class="boutton" method="POST" >
            <?php if($this->_user->isAdmin()==0){ ?>
                <input type="hidden" id="admin" name="Admin" value="admin">
                <input type="submit" class="btn btn-info" value="   Admin    ">
            <?php }else{ ?>
                <input type="hidden" id="Membre" name="Membre" value="Membre">
                <input type="submit" class="btn btn-info" value="   Membre    ">
            <?php }?>
        </form>
    <?php }?>
    </div>
    <h2>fiche de: <?php echo $this->_user->getUsername(); ?></h2>
    <p>
        <table class="table table-bordered">
        <thead>
        <tr>
            <th>Catégorie</th>
            <th>Titre</th>
            <th>Etat</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach($this->_questions as $i =>$question){

                echo'<tr>';
                echo'<td><a href="/category/' .$this->_global['db']->getCategoryById($question['category_id'])['link_referer']. '"><h3>' . $this->_global['db']->getCategoryById($question['category_id'])['name']. '</h3></a>.</td>';
                echo'<td><a href="/question/' .$question['question_id'].'/'.$this->_global['fn']->clean($question['title']) . '"><h3>' . $question['title'] . '</h3></a>.</td>';
                echo '<td>'.(($question['state']==='o') ? 'ouvert':(($question['state']==='d')?'dupliqué':'résolu')).'</td>';
                echo'</tr>';
            }
        ?>
        </tbody>
    </table>
    <?php if(!empty($_SESSION['isConnected'])&&$_SESSION['isAdmin']){?>
        <form action="?action=allUser" method="POST">
            <input type="hidden" id="allUsers" name="allUsers" value="allUsers">
            <input type="submit" class="btn btn-secondary" value="   Afficher tous les utilisateurs    ">
        </form>
    <?php } ?>
</div>