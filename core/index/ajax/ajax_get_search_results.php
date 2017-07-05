<?php 
	include_once(dirname(__FILE__)."/../../../lib/free_user_manager.php");
	
	$objFreeUM = new CFreeUserManager();
	
	$searchResultAry = $objFreeUM->PopulateProducts(trim($_POST['search_text']), $_POST['search_category'], 
											$_POST['limit_start_value'], $_POST['product_category'], $_POST['product_major_category']);
	
	echo(json_encode($searchResultAry));
?>