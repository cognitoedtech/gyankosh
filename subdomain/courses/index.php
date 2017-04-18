<!doctype html>
<?php 
include_once("../../lib/session_manager.php");
include('../../database/mcat_db.php');
include_once(dirname(__FILE__)."/../../lib/include_js_css.php");
include_once(dirname(__FILE__)."/../../lib/site_config.php");

$objIncludeJsCSS = new IncludeJSCSS();

?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="Generator" content="">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">
<title><?php echo(CConfig::SNC_SITE_NAME);?> : Free Video Courses</title>
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
</head>
<body ng-app="Demo" ng-cloak>
	<?php 
	include_once(dirname(__FILE__)."/../../lib/header.php");
	?>
	<div>
		Coming Soon ...
	</div>
</body>
</html>
