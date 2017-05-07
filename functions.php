<?php

require("credentials.php");

function random_salt($length) {
	$possible = '0123456789'.
		'abcdefghijklmnopqrstuvwxyz'.
		'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.
		'./';
	$str = '';
	mt_srand((double)microtime() * 1000000);
	while (strlen($str) < $length)
		$str .= substr($possible,(rand()%strlen($possible)),1);
	return $str;
}

function generate_password($password){
	$salt = random_salt(13);

	return "{CRYPT}".crypt($password, $salt);
}


try{
	$bdd = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.';charset=utf8', $dbUser, $dbPassword);
}
catch(Exception $e){
	die('Erreur : '.$e->getMessage());
}





?>