<?php 
	include_once(dirname(__FILE__)."/../../../database/mcat_db.php");
	include_once(dirname(__FILE__)."/../../../lib/session_manager.php");
	
	// - - - - - - - - - - - - - - - - -
	// On Session Expire Load ROOT_URL
	// - - - - - - - - - - - - - - - - -
	CSessionManager::OnSessionExpire();
	// - - - - - - - - - - - - - - - - -
	
	/*$fp = fopen("post_file.txt", "w");
	fwrite($fp, print_r($_POST, TRUE));
	fclose($fp);*/
	
	$objDB = new CMcatDB();
	
	$user_id = CSessionManager::Get(CSessionManager::STR_USER_ID);
	
	if($_POST['publish']==1)
	{
		$schedule_start			= trim($_POST['schedule_start']);
		$schedule_end			= isset($_POST['schedule_end']) ? trim($_POST['schedule_end']) : 0;
		$keywords				= trim($_POST['publish_keywords']);
		$description			= trim($_POST['publish_test_desc']);
		$suggested_reads		= trim($_POST['suggested_reads']);
		$who_should_buy			= trim($_POST['who_should_buy']);
		$what_will_you_acheive 	= trim($_POST['what_will_you_acheive']);
		$product_id				= trim($_POST['pub_test_id']);
		
		$gd_univ_name			= isset($_POST['gd_univ_name']) ? 1 : 0;
		$gd_inst_name			= isset($_POST['gd_inst_name']) ? 1 : 0;
		$gd_enroll_num			= isset($_POST['gd_enroll_num']) ? 1 : 0;
		
		$aryGatherData	= array("gd_univ_name" 	=> $gd_univ_name,
								"gd_inst_name" 	=> $gd_inst_name,
								"gd_enroll_num" => $gd_enroll_num);
		
		$publish_test_category  	= trim($_POST['publish_test_category']);
		$publish_test_sub_category  = trim($_POST['publish_test_sub_category']);
		
		$inr_cost			= isset($_POST['inr_cost']) ? trim($_POST['inr_cost']) : 0;
		$usd_cost			= isset($_POST['usd_cost']) ? trim($_POST['usd_cost']) : 0;
		
		$org_id			= $objDB->GetOrgIdByUserId($user_id);
		$org_name 		= $objDB->GetOrganizationName($org_id);
		$category_id	= $objDB->GetCategoryID($publish_test_category, $publish_test_sub_category);
		$product_image 	= null;
		
		if($_FILES['product_img']['size'] > 0)
		{
			$handle = fopen($_FILES['product_img']['tmp_name'], "rb");
			$product_image  = fread($handle, $_FILES['product_img']['size']);
			fclose($handle);
		}
		
		$aryPublishedInfo = array("org_id"=>$org_id,
							"org_name"=>$org_name,
							"suggested_reads"=>mysql_real_escape_string($suggested_reads),
							"who_should_buy"=>mysql_real_escape_string($who_should_buy),
							"what_will_you_acheive"=>mysql_real_escape_string($what_will_you_acheive),
							"cost"=>array("inr"=>$inr_cost, "usd"=>$usd_cost),
							"gather_data"=>$aryGatherData,
							);
		
		$objDB->PublishProduct($keywords, $description, $product_image, 
						$schedule_start, $schedule_end, $aryPublishedInfo, 
						$product_id, CConfig::PT_TEST, $category_id);
	}
	else if($_POST['unpublish']==0)
	{	
		$product_id	=	$_POST['test_id'];
		$objDB->UnPublishProduct($product_id, 0);
	}
?>
