<?php
	include_once("../../lib/session_manager.php");
	include_once("../../database/mcat_db.php");
	include_once("../../lib/user_manager.php");
	
	// - - - - - - - - - - - - - - - - -
	// On Session Expire Load ROOT_URL
	// - - - - - - - - - - - - - - - - -
	CSessionManager::OnSessionExpire();
	// - - - - - - - - - - - - - - - - -
	
	$user_id = CSessionManager::Get(CSessionManager::STR_USER_ID);
	
	/*$fp = fopen("post_file.txt", "w");
	fwrite($fp, print_r($_POST, TRUE));
	fclose($fp);*/
	
	//$objDB = new CMcatDB();
	$objUM = new CUserManager();
	
	$test_id		= trim($_POST['test_id']);
	$schd_id		= trim($_POST['schd_id']);
	$ga_univ_name 	= trim($_POST['ga_univ_name']);
	$ga_inst_name 	= trim($_POST['ga_inst_name']);
	$ga_enroll_num 	= trim($_POST['ga_enroll_num']);
	
	if(!empty($ga_univ_name) || !empty($ga_inst_name) || !empty($ga_enroll_num))
	{
		/*$fp = fopen("post_file.txt", "w");
		fwrite($fp, print_r($_POST, TRUE));
		fclose($fp);*/
		
		echo $objUM->InsertGatheredData($user_id, $test_id, $schd_id, $ga_univ_name, $ga_inst_name, $ga_enroll_num);
	}
?>