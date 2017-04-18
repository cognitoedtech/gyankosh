<?php
	include_once(dirname(__FILE__)."/../../../lib/session_manager.php");
	
	$jsonCartItems = CSessionManager::Get(CSessionManager::JSON_CART_ITEMS);
	
	$aryCartItems = json_decode($jsonCartItems, TRUE);
	
	/*
	 * $fp = fopen("add_to_cart.txt", "w");
	 * fwrite($fp, print_r($aryCartItems, TRUE)."\r\n");
	 * fclose($fp);
	 * */
	
	$product_id = $_POST['product_id'];
	$product_type = $_POST['product_type'];
	
	foreach($aryCartItems as $key => $CartItem)
	{
		if(is_int($key) && $CartItem['id'] == $product_id && $CartItem['type'] == $product_type)
		{
			unset($aryCartItems[$key]);
			break;
		}
	}
	
	$jsonCartItems = json_encode($aryCartItems);
	CSessionManager::Set(CSessionManager::JSON_CART_ITEMS, $jsonCartItems);
?>