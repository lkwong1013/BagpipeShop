<?php
function hashpass($password, $userid){
$salt = $userid;
$sha256pass = hash('sha256', $salt.$password);

return $sha256pass;



}



?>