<?php 
	include_once(dirname(__FILE__)."/../../../lib/session_manager.php");
	
	$jsonCartItems = CSessionManager::Get(CSessionManager::JSON_CART_ITEMS);
	
	$aryCartItems = json_decode($jsonCartItems, TRUE);
	
	/*
	 * Status : 0 (No Error, successfuly added
	 * Status : 1 (Product is already present in cart)
	 * 
	 * */
	if(empty($aryCartItems))
		$aryCartItems = array('status'=>0);
	
	/*$fp = fopen("add_to_cart.txt", "w");
	fwrite($fp, print_r($aryCartItems, TRUE)."\r\n");
	fclose($fp);*/
	
	$product_id = $_POST['product_id'];
	$product_type = $_POST['product_type'];
	
	$bProductExistsInCart = false;
	foreach($aryCartItems as $key => $cartItem)
	{
		$fp = fopen("add_to_cart.txt", "a");
		fwrite($fp, print_r($cartItem, TRUE)."\r\n");
		fclose($fp);
		
		if(is_int($key) && $cartItem['id'] == $product_id)
		{
			$bProductExistsInCart = true;
			
			break;
		}
	}
	
	if($bProductExistsInCart)
	{
		$aryCartItems['status'] = 1;
	}
	else 
	{
		array_push($aryCartItems, array('id'=>$product_id, 'type'=>$product_type));
		
		$aryCartItems['status'] = 0;
	}
	
	$jsonCartItems = json_encode($aryCartItems);
	CSessionManager::Set(CSessionManager::JSON_CART_ITEMS, $jsonCartItems);
	
	/*$fp = fopen("add_to_cart.txt", "a");
	fwrite($fp, $jsonCartItems."\r\n");
	fclose($fp);*/
	
	echo($jsonCartItems);
?>