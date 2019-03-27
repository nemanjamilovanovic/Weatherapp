<?php
include 'bootstrap.php';

$tasks = $userManager->getAllUsers();

foreach($tasks as $key=>$value){
	$result[] = [
		'name'=> $value->first_name,
		'lastname'=> $value->last_name,
		'email' => $value->email
	];
}

require 'login.php';