<?php
	include_once(dirname(__FILE__)."/../../../lib/session_manager.php");
	include_once(dirname(__FILE__)."/../../../database/config.php");
	include_once(dirname(__FILE__)."/../../../database/mcat_db.php");
	include_once(dirname(__FILE__)."/../../../lib/utils.php");
	include_once(dirname(__FILE__)."/../../../test/lib/tbl_result.php");
	
	$objTR = new CResult();
	
	$user_id = CSessionManager::Get(CSessionManager::STR_USER_ID);
	$user_type = CSessionManager::Get(CSessionManager::INT_USER_TYPE);
	$time_zone = CSessionManager::Get(CSessionManager::FLOAT_TIME_ZONE);
	
	$parsAry = parse_url(CUtils::curPageURL());
	$qry = split("[=&]", $parsAry["query"]);
	
	if($qry[0] == "test_id")
	{
		$objDB = new CMcatDB();
		
		$ResultAry = $objTR->GetCompletedTestDates($user_id, $user_type, $qry[1], $time_zone, true);
		
		printf("<option value=''>-- Choose Schedule Date --</option>");
		foreach ($ResultAry as $tschd_id => $scheduled_on_user_ary)
		{
			printf("<option value='%s'>%s (%s, pID : %s)</option>", $scheduled_on_user_ary[2], $scheduled_on_user_ary[0], $objDB->GetUserName($scheduled_on_user_ary[1]), ($tschd_id != -100)? $tschd_id:"Demo");
		}
	}
?>