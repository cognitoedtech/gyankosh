<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
	include_once("../../lib/session_manager.php");
	include_once('../../test/lib/tbl_result.php');
	include_once(dirname(__FILE__)."/../../lib/include_js_css.php");
	include_once(dirname(__FILE__)."/../../lib/site_config.php");
	
	// - - - - - - - - - - - - - - - - -
	// On Session Expire Load ROOT_URL
	// - - - - - - - - - - - - - - - - -
	CSessionManager::OnSessionExpire();
	// - - - - - - - - - - - - - - - - -
	
	$objTR = new CResult();
	
	$user_id = CSessionManager::Get(CSessionManager::STR_USER_ID);
	$nUserType = CSessionManager::Get(CSessionManager::INT_USER_TYPE);
	
	$TNameAry = $objTR->GetCompletedTestNames($user_id, $nUserType, true);
	
	$objIncludeJsCSS = new IncludeJSCSS();
	
	$menu_id = CSiteConfig::UAMM_RESULT_ANALYTICS;
	$page_id = CSiteConfig::UAP_ANALYZE_QUESTION;
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="Generator" content="Mastishka Intellisys Private Limited">
<meta name="Author" content="Mastishka Intellisys Private Limited">
<meta name="Keywords" content="">
<meta name="Description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo(CConfig::SNC_SITE_NAME);?>: Test DNA Analysis</title>
<?php 
$objIncludeJsCSS->CommonIncludeCSS ( "../../" );
$objIncludeJsCSS->IncludeIconFontCSS ( "../../" );
$objIncludeJsCSS->IncludeFuelUXCSS ( "../../" );
$objIncludeJsCSS->CommonIncludeJS ( "../../");
$objIncludeJsCSS->IncludeCanvasMinJS ( "../../");
$objIncludeJsCSS->CommonIncludeHighchartsJS("../../");
$objIncludeJsCSS->IncludeJQueryNouisliderMinJS("../../");
$objIncludeJsCSS->IncludeResultAnalyticsJS("../../");
?>
<style type="text/css">
	.modal1 {
		display:    none;
		position:   fixed;
		z-index:    1000;
		top:        50%;
		left:       60%;
		height:     100%;
		width:      100%;
	}
</style>
</head>
<body>

	<?php 
	include_once(dirname(__FILE__)."/../../lib/header.php");
	?>

	<!-- --------------------------------------------------------------- -->
	<br />
	<br />
	<br />
	<div class='row-fluid'>
		<div class="col-lg-3 col-md-3 col-sm-3">
			<?php 
			include_once(dirname(__FILE__)."/../../lib/sidebar.php");
			?>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9" style="border-left: 1px solid #ddd; border-top: 1px solid #ddd;">
			<div class="fuelux modal1">
				<div class="preloader"><i></i><i></i><i></i><i></i></div>
			</div>
			<br />
			<div class="row fluid">
				<div class="col-lg-12 col-md-12 col-sm-12">
					
				</div>
			</div>
			<?php
			include_once (dirname ( __FILE__ ) . "/../../lib/footer.php");
			?>
		</div>
	</div>
	<script type="text/javascript">
	$(document).ready(function() {
		
	});
	</script>
</body>
</html>