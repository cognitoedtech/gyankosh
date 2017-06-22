<!doctype html>
<?php 
include_once("../../lib/session_manager.php");
include('../../database/mcat_db.php');
include_once(dirname(__FILE__)."/../../lib/include_js_css.php");
include_once(dirname(__FILE__)."/../../lib/site_config.php");

$objIncludeJsCSS = new IncludeJSCSS();

$bCopiedLink = false;
$bProperURL  = true;
$test_id = NULL;
if(isset($_GET['ln']) && !empty($_GET['ln']))
{
	$bCopiedLink = true;
	$testInfoAry = explode("-", $_GET['ln']);
	
	if(preg_match('/^\d+$/', $testInfoAry[0]) != 0 && $testInfoAry[0] > 0 && count($testInfoAry) == 3 && strlen($testInfoAry[1]) == 2 && $testInfoAry[1] >= 1 && $testInfoAry[1] <= 31)
	{
		$test_id = $testInfoAry[0];
		$owner_id_hint = $testInfoAry[2];
		if(strlen($owner_id_hint) == 2)
		{
			$objDB = new CMcatDB();
			
			$isFreeTest = $objDB->IsTestPublished($test_id, $owner_id_hint);
			
			if(!$isFreeTest)
			{
				$bProperURL = false;
			}
		}
		else 
		{
			$bProperURL = false;
		}
	}
	else 
	{
		$bProperURL = false;
	}
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
<title><?php echo(CConfig::SNC_SITE_NAME);?> : Free Practice Tests</title>
<script type="text/javascript">
var imageUpArrowIncludeBasePath = "<?php echo(CSiteConfig::ROOT_URL);?>";
</script>
<link rel="shortcut icon" href="<?php echo(CSiteConfig::ROOT_URL);?>/favicon.ico?v=1.1">
<?php 
$objIncludeJsCSS->CommonIncludeCSS(CSiteConfig::ROOT_URL."/");
$objIncludeJsCSS->IncludeMipcatCSS(CSiteConfig::ROOT_URL."/");
$objIncludeJsCSS->Include3DCornerRibbonsCSS(CSiteConfig::ROOT_URL."/");
$objIncludeJsCSS->IncludeFuelUXCSS(CSiteConfig::ROOT_URL."/");
$objIncludeJsCSS->CommonIncludeJS(CSiteConfig::ROOT_URL."/");
$objIncludeJsCSS->IncludeScrollUpJS(CSiteConfig::ROOT_URL."/");
$objIncludeJsCSS->IncludeAngularMinJS(CSiteConfig::ROOT_URL."/");
$objIncludeJsCSS->IncludeUnderscoreMinJS(CSiteConfig::ROOT_URL."/");
$objIncludeJsCSS->IncludeTaggedInfiniteScrollJS(CSiteConfig::ROOT_URL."/");
$objIncludeJsCSS->IncludeJqueryRatyJS(CSiteConfig::ROOT_URL."/");
$objIncludeJsCSS->IncludeJqueryFormJS(CSiteConfig::ROOT_URL."/");
$objIncludeJsCSS->IncludeJqueryValidateMinJS(CSiteConfig::ROOT_URL."/");
$objIncludeJsCSS->IncludeMetroNotificationJS(CSiteConfig::ROOT_URL."/");
?>
<style type="text/css">
	#overlay { position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; z-index: 100; background-color:white;}
	
	.modal1 {
			display:    none;
			position:   fixed;
			z-index:    1000;
			top:        50%;
			left:       50%;
			height:     100%;
			width:      100%;
		}
</style>
</head>
<body>
	<?php 
	include_once(dirname(__FILE__)."/../../lib/header.php");
	?>
	<div class="container" style="margin-top: 80px">
		<div class="fuelux modal1">
			<div class="preloader"><i></i><i></i><i></i><i></i></div>
		</div>
	
		<div class="row">
			<div class="col-sm-8 col-md-8 col-lg-8 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
				<div class="input-group">
					<input class="form-control" type="text" name="username" placeholder="Email ID ..."></input>
					<br/>
					<input class="form-control" type="password" name="password" placeholder="Password ..."></input>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
