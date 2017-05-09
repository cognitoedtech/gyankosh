<?php
	include_once(dirname(__FILE__)."/../../../lib/session_manager.php");
	include_once(dirname(__FILE__)."/../../../test/lib/tbl_result.php");
	
	// - - - - - - - - - - - - - - - - -
	// On Session Expire Load ROOT_URL
	// - - - - - - - - - - - - - - - - -
	CSessionManager::OnSessionExpire();
	// - - - - - - - - - - - - - - - - -
	
	$user_id = CSessionManager::Get(CSessionManager::STR_USER_ID);
	$nUserType = CSessionManager::Get(CSessionManager::INT_USER_TYPE);
	
	$objTR = new CResult();
	
	$aryRet = $objTR->GetTestStats($_POST['test_id'], $_POST['test_pnr'], $user_id, $nUserType);
	
	echo (json_encode($aryRet));
?>