
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
                    foreach($this->_allUsers as $i =>$userName) {
                        echo'<tr>';
                        echo '<th scope="row">'.$userName['user_id'].'</th>';
                        echo '<td><a href="/user/' . $userName['username'] . '"><h4>' . $userName['username'] . '</h4></a></td>';
                        echo'<td>'.$userName['firstname'].'</td>';
                        echo'<td>'.$userName['name'].'</td>';
                        echo'<td>'.$userName['email'].'</td>';
                        echo'</tr>';
                    }
             ?>









    </tbody>





