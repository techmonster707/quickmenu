<?php

if(isset($_POST['purchase_code']) && !isset($_POST['submit'])) {
	require_once 'helper.php';
	
	session_start();
	$_SESSION['purchase_code'] = $_POST['purchase_code'];
	$_SESSION['buyer'] = 'xxxxxxxx';
	$_SESSION['account_email'] = 'mail@mail.com';
	$json['buyer'] = 'xxxxxxxx';
	$json['account_email'] = 'mail@mail.com';
	$json['st'] = 1;
	$json['msg'] = "Purchase Code Verified Successfully";

}else {
    $json['st'] = 0;
    $json['msg'] = "Access Denied!";
}

echo json_encode($json);