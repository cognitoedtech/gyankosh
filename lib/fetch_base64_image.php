<?php
	include_once(dirname(__FILE__)."/../database/mcat_db.php");
	include_once(dirname(__FILE__)."/utils.php");
	
	$parsAry = parse_url(CUtils::curPageURL());
	$qry = split("[=&]", $parsAry["query"]);
	
	$objDB 	= new CMcatDB();
	
	$img_content = "";
	
	if($qry[0] == "product_id")
	{
		$product_id = trim($qry[1]);
		$prodcut_type = trim($qry[3]);
		$img_content = base64_decode($objDB->GetProductImage($product_id, $prodcut_type));
		
		
	}
	
	$image = imagecreatefromstring($img_content);
	
	/*$fp = fopen("image_file.txt", "w");
	fwrite($fp, $img_content);
	fclose($fp);*/
	
	//$filename = md5(uniqid(rand(), true));
	if($image !== FALSE)
	{
		$image_type = CUtils::getMimeType($img_content);
		header('Content-Type: '.$image_type);
		
		if($image_type == "image/gif")
		{
			imagegif($image);
		}
		else if($image_type == "image/png")
		{
			imagepng($image);
		}
		else if($image_type == "image/jpeg")
		{
			imagejpeg($image);
		}
		
		imagedestroy($image);
	}
	else if($qry[5] == 1) // $qry[4] -> random = 1
	{
		header('Content-Type: image/jpeg');
		$image = imagecreatefromjpeg (dirname(__FILE__)."/../images/org_logo_placeholder/".mt_rand(1,7).".jpg");
		
		if($image !== FALSE)
		{
			imagejpeg($image);
			imagedestroy($image);
		}
	}
?>