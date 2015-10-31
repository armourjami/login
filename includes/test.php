<?php
require_once '../core/init.php';

//$user = DB::getInstance()->insert('users', array('username' => 'Evie', 'password' => 'something', 'salt' => 'salt', 'name' => 'Evie', 'joined' => date("Y-m-d H:i:s"), 'group' => '0'));
$user = DB::getInstance();
$user->get('users', array('username', '=', 'jamie'));
echo "<br>index.php: " . $user->results()[0]->username;
//$userUpdate = DB::getInstance()->update('users', 2, array(
//	'password' => 'newpassword',
//	'name' => 'Dale Garrett'
//));



?>
