<?php
	include_once(dirname(__FILE__)."/../../../lib/session_manager.php");
	include_once(dirname(__FILE__)."/../../../database/config.php");
	include_once(dirname(__FILE__)."/../../../database/mcat_db.php");
	include_once(dirname(__FILE__)."/../../../lib/user_manager.php");
	include_once(dirname(__FILE__)."/../../../lib/utils.php");
	include_once(dirname(__FILE__)."/../../../lib/billing.php");
	
	$test_id = 0;
	$user_id = 0;
	$scheduled_on = 0;
	$hours = 0;
	$minutes = 0;
	$expire_on = 0;
	$expire_hours = 0;
	$expire_minutes = 0;
	$candidate_list = 0;
	$time_zone = 0;
	$schd_type = 0; 
	$schd_id = 0;
	
	$objDB = new CMcatDB();
	$test_name = $objDB->InsertIntoTestSchedule($test_id, $user_id, $scheduled_on, $hours, $minutes, $expire_on, $expire_hours, $expire_minutes, $candidate_list, $time_zone, $schd_type, $schd_id);
	
	$objBilling = new CBilling();
	$products_purchased = 0;
	$payment_info = 0;
	$objBilling->AddToCustomerBilling($user_id, $products_purchased, $payment_info);
	
	$objDB->EmailTestScheduleNotification($user_id, $test_name, $candidate_list, $scheduled_on, $hours, $minutes,"","","",$time_zone);
?>