<table class="table">


    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">pseudo</th>
            <th scope="col">prénom</th>
            <th scope="col">nom</th>
            <th scope="col">mail</th>
            <th scope="col">est Admin?</th>
            <th scope="col">est suspendu?</th>
        </tr>
    </thead>
    <tbody>

        <?php
            foreach($this->_allUsers as $i =>$user) {
                echo'<tr>';
                    echo '<th scope="row">'.$user['user_id'].'</th>';
                    echo '<td><a href="/user/' . $user['username'] . '"><h4>' . $user['username'] . '</h4></a></td>';
                    echo'<td>'.$user['firstname'].'</td>';
                    echo'<td>'.$user['name'].'</td>';
                    echo'<td>'.$user['email'].'</td>';
                    if($user['isAdmin']){
                        echo'<td><form action="?=setMember" method="post">';
                        echo'<div class="isAdmin">
                                <input type="hidden" name="setMember" value="'.$user['user_id'].'">
                                <button type="submit" class="btn btn-info btn-sm">
                                <span class="glyphicon glyphicon-ok"></span> 
                                    </button></div>';
                    }else{
                        echo'<td><form action="?=setAdmin" method="post">';
                        echo'<div class="isAdmin">
                                <input type="hidden" name="setAdmin" value="'.$user['user_id'].'"/>
                                <button type="submit" class="btn btn-warning btn-sm">
                                <span class="glyphicon glyphicon-remove"></span> 
                                    </button></div>';
                    }
                    echo'</form></td>';
                if($user['isLocked']){
                    echo'<td><form action="?=setOnLine" method="post">';
                    echo'<div class="isLocked">
                                <input type="hidden" name="setOnLine" value="'.$user['user_id'].'">
                                <button type="submit" class="btn btn-info  btn-sm">
                                <span class="glyphicon glyphicon-ok"></span> 
                                    </button></div>';
                }else{
                    echo'<td><form action="?=setLocked" method="post">';
                    echo'<div class="isLocked">
                                <input type="hidden" name="setLocked" value="'.$user['user_id'].'"/>
                                <button type="submit" class="btn btn-warning btn-sm">
                                <span class="glyphicon glyphicon-remove"></span> 
                                    </button></div>';
                }
                echo'</form></td>';




                echo'</tr>';
            }
        ?>
    </tbody>
</table>