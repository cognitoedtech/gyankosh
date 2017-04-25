<?php
	include_once (dirname ( __FILE__ ) . "/../../../lib/session_manager.php");
	include_once (dirname ( __FILE__ ) . "/../../../lib/aws-ses-email.php");
	include_once (dirname ( __FILE__ ) . "/../../../database/config.php");
	include_once (dirname ( __FILE__ ) . "/../../../database/mcat_db.php");
	
	/*$fp = fopen("add_category.txt", "w");
	fwrite($fp, print_r($_POST, TRUE)."\r\n");
	fclose($fp);*/
	
	$objDB = new CMcatDB();
	$retVal = $objDB->AddCategoryRequest($_POST['user_id'], $_POST['category'], $_POST['sub_category']);
	
	if($retVal)
	{
		$objMail = new CEMail(CConfig::OEI_SUPPORT, $objDB->GetPasswordFromOfficialEMail(CConfig::OEI_SUPPORT));
		$objMail->AckAddCategoryRequest($objDB->GetUserEmail($_POST['user_id']), 
										$objDB->GetUserName($_POST['user_id']),
										$_POST['category'], $_POST['sub_category']);
	}
	
	json_encode(array("status"=>$retVal));
?>