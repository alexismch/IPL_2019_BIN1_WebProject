
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">pseudo</th>
        <th scope="col">prénom</th>
        <th scope="col">nom</th>
        <th scope="col">mail</th>
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
                        echo'</tr>';
                    }
             ?>









    </tbody>





