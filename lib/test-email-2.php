<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include_once("../../lib/aws-ses-email.php");

	$objMail = new CEMail("quizus.co@gmail.com", "");

	//$retval = $objMail->PrepAndSendFreeUserResult("manish_mastishka@yahoo.co.in", "Manish Arora", "57d667f065979_test_dna.pdf", "57d667f065979_inspect_result.pdf");
	Send("manish.mastishka@gmail.com","Test","Hi");

	print_r($retval);
?>