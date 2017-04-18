<?php
	include_once(dirname(__FILE__)."/../../lib/session_manager.php");
	include_once(dirname(__FILE__)."/../../database/config.php");
	include_once(dirname(__FILE__)."/../../database/mcat_db.php");
	include_once(dirname(__FILE__)."/../../lib/utils.php");

	//$parsAry = parse_url(CUtils::curPageURL());
	//$qry = split("[=&]", $parsAry["query"]);
	
	$objDB  = new CMcatDB();
	$aryRet = array("success"=>false);

	if( isset($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) !== false )
	{
		//echo("Test 1");
		$aryRet["success"] = $objDB->StayConnected($_POST["email"]);
	}

	echo json_encode($aryRet);
?>