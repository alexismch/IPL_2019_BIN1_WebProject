<?php


    foreach($this->_allUsers as $i =>$userName){

    echo'<a href="/user/' .$userName['username']. '"><h3>' .$userName['username']. '</h3></a></br>';
}
    ?>