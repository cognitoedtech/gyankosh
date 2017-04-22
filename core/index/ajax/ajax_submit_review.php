<?php
	include_once (dirname ( __FILE__ ) . "/../../../database/mcat_db.php");
	include_once (dirname ( __FILE__ ) . "/../../../lib/session_manager.php");
	include_once (dirname ( __FILE__ ) . "/../../../lib/utils.php");
	
	$user_id = CSessionManager::Get(CSessionManager::STR_USER_ID);
	
	$redirect_url 	= $_POST['redirect_url'];
	$product_id 	= $_POST['product_id'];
	$product_type 	= $_POST['product_type'];
	$rating			= $_POST['rating'];
	$subject		= trim($_POST['subject']);
	$description	= trim($_POST['description']);
	$date	 		= new DateTime();
	$timestamp 		= $date->format('Y-m-d H:i:s');
	
	$objDB = new CMcatDB();
	
	$aryReview  = array ('user_id' => $user_id, 
						'rating' => $rating, 
						'subject' => $subject, 
						'description' => $description, 
						'timestamp' => $timestamp);
	
	$searchResultAry = $objDB->SubmitReview($product_id, $product_type, $aryReview);
	
	CUtils::Redirect($redirect_url);
?>