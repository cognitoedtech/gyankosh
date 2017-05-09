<!doctype html>
<?php
	include_once(dirname(__FILE__)."/../../lib/session_manager.php");
	include_once(dirname(__FILE__)."/../../database/config.php");
	include_once(dirname(__FILE__)."/../../database/mcat_db.php");
	include_once(dirname(__FILE__)."/../../database/payu_transaction_db.php");
	
	include_once(dirname(__FILE__)."/../../lib/user_manager.php");
	include_once(dirname(__FILE__)."/../../lib/utils.php");
	include_once(dirname(__FILE__)."/../../lib/billing.php");
	
	include_once (dirname ( __FILE__ ) . "/../../lib/include_js_css.php");
	include_once (dirname ( __FILE__ ) . "/../../lib/header.php");
	
	$bShowCKEditor = FALSE;
	
	$objIncludeJsCSS = new IncludeJSCSS ();
	
	if(!isset ( $_POST['search_text'] ) && !isset( $_POST['search_category'] )) {
		$_POST['search_text'] = "";
		$_POST['search_category'] = "keywords";
	}
	
	$test_id = NULL;
	if (isset( $_GET ['company-name'] ) && ! empty ( $_GET ['company-name'] )) {
		$_POST['search_text'] = $_GET ['company-name'];
		$_POST['search_category'] = "inst_name";
	}
	
	$from_free = 1;
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="Generator" content="">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">
<title><?php echo(CConfig::SNC_SITE_NAME);?> : Practice Tests</title>
<script type="text/javascript">
var imageUpArrowIncludeBasePath = "<?php echo(CSiteConfig::ROOT_URL);?>";
</script>
<link rel="shortcut icon"
	href="<?php echo(CSiteConfig::ROOT_URL);?>/favicon.ico?v=1.1">
<?php
$objIncludeJsCSS->CommonIncludeCSS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeMipcatCSS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeIconFontCSS ( "" );
$objIncludeJsCSS->Include3DCornerRibbonsCSS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeFuelUXCSS ( CSiteConfig::ROOT_URL . "/" );

$objIncludeJsCSS->CommonIncludeJS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeScrollUpJS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeAngularMinJS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeUnderscoreMinJS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeTaggedInfiniteScrollJS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeJqueryRatyJS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeJqueryFormJS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeJqueryValidateMinJS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeMetroNotificationJS ( CSiteConfig::ROOT_URL . "/" );
?>
<style type="text/css">
#overlay {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 100;
	background-color: white;
}

.modal1 {
	display: none;
	position: fixed;
	z-index: 1000;
	top: 50%;
	left: 50%;
	height: 100%;
	width: 100%;
}
</style>
<script>
function printThis()
{
	var noprint =  $('.noprint');	
	noprint.hide();
	window.print();
	noprint.show();
	

}


</script>

</head>
<body>
	<?php
	
	
	
	if(isset($_POST["txnid"]))
	{
	
	$transaction_id = $_POST["txnid"];
	$free_test = $_POST["free"];		
	$product_info = $_POST["productinfo"];	
	$message="Thank you for your purchase.You can attempt test from Purchased Products ";
	$user_id = CSessionManager::Get(CSessionManager::STR_USER_ID);
	$objDB = new CMcatDB();
	$objBilling = new CBilling();
	
	$prod_array = json_decode($product_info);
	$objDB = new CMcatDB();
	$scheduled_on = date("Y-m-d");
		
	$hours = date("H");
	$minutes = date("i");
	$expire_on = ""; // For now expire never
	$expire_hours = "";
	$expire_minutes = "";
	$candidate_list = $user_id; // csv list of users but here we have only one user;
	$time_zone = "5.5"; // For now just hardcode it. Bad practice but just do it now.
			
	
	$productPurchasedarray = array();
	$payment_info_arr = array();
	
	$productPurchasedarray["products"]["tests"] = array();
		
	$fTax = CConfig::$BA_TAX_APPLIED_ARY ["Service Tax"] / 100;
		
	foreach ($prod_array as $key => $prodItem )
	{
		if(isset($prodItem->id) && $prodItem->type == CConfig::PT_TEST) 
		{
			$test_id = $prodItem->id;
			//$sTestName =  $objDB->GetTestName($test_id);
			$owner_id =  $objDB->GetTestOwnerID($test_id);
			$schd_id ="";
	
			$sTestName= $objDB->InsertIntoTestSchedule($test_id, $user_id, $scheduled_on, $hours, $minutes, $expire_on, $expire_hours, $expire_minutes, $candidate_list, $time_zone,CConfig::TST_ONLINE, $schd_id);
	
			$sellerBilling = $objBilling->GetSellerBilling($owner_id);
	
			$aryProdDetails = $objDB->GetPublishedProductDetails ( $prodItem->id, $prodItem->type );
			// print_r($aryProdDetails);
			$aryProdInfo = json_decode ( $aryProdDetails ['published_info'], TRUE );
			$prod_name = $aryProdDetails ['product_name'];
			$prod_cost =  $aryProdInfo ['cost'] ['inr'] ;	
			$test_array = array("id"=>$prodItem->id, "scheduled_id"=>$schd_id, "amount_base"=>$prod_cost, "taxes"=>$prod_cost*$fTax,"seller_share"=>$sellerBilling["market_percentage_sharing"],"quizus_share"=>100 - $sellerBilling["market_percentage_sharing"]);
			array_push($productPurchasedarray["products"]["tests"] , $test_array);	
		}
			
		$objDB->EmailTestScheduleNotification($user_id, $test_name, $user_id, $scheduled_on, $hours, $minutes,"","","",$time_zone);
	}
	$payment_info_arr["payment_info"] = array("transaction_id"=>$transaction_id, "purchase_type" =>CConfig::ZERO_CART,"total_amount" => 0);
	$objBilling->AddToCustomerBilling($user_id, json_encode($productPurchasedarray), json_encode($payment_info_arr));
	
		
	}
	

?>


<div class="row col-xs-5 col-sm-4 col-lg-6" style="margin-top:7%; margin-left:20%"  >

 

<?php
if(isset($_POST["txnid"]))
{
	
?>




  <div class="panel panel-default ">
  
  <div class="panel-heading">Transaction Details</div>
  <div class="panel-body">
  
 
  
  <div class="alert alert-info  col-xs-6 col-sm-6 col-lg-12">
  <?php echo $message; ?>   
  </div>
  
  <div class="table">
  <table class="table">
  <tr class="default">
   <td>Transaction ID: </td> <td><?php echo $transaction_id ?> </td>
   </tr>
  
  </table>
  </div>
  
  <div 	class="col-lg-12 col-md-4 col-sm-4 col-sm-offset-1 col-md-offset-1 col-lg-offset-3  noprint">
								<button class="btn btn-info" onclick ="printThis()"
									aria-expanded="false" aria-controls="collapseOne">
									<i class="fa fa-print" aria-hidden="true"></i>&nbsp;&nbsp;
									Print
								</button>
								<a class="btn btn-success"  href="../purchased-products.php">
										My Purchase &nbsp;&nbsp; <i class="fa fa-shopping-bag"
											aria-hidden="true"></i>
									</a>
									
								
								<a class="btn btn-success"  href="../../search-results.php">
										Continue Shopping &nbsp;&nbsp; <i class="fa fa-shopping-cart"
											aria-hidden="true"></i>
									</a>
							</div>
  
  
</div>
  
  
  </div>

</div>

 
<?php }


?>
</div>


</body>