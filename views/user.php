<div class="user">

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
        <a href="/user/all">Afficher tous les utilisateurs</a>
    <?php } ?>
</div>