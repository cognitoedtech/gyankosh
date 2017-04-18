<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
include_once (dirname ( __FILE__ ) . "/../lib/include_js_css.php");
include_once (dirname ( __FILE__ ) . "/../database/config.php");

$objIncludeJsCSS = new IncludeJSCSS ();
?>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="Generator" content="">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo(CConfig::SNC_SITE_NAME);?> Features: Batch Management</title>
<?php
$objIncludeJsCSS->IncludeMipcatCSS ( "../" );
$objIncludeJsCSS->IncludeIconFontCSS ( "../" );
$objIncludeJsCSS->CommonIncludeCSS ( "../" );
$objIncludeJsCSS->CommonIncludeJS ( "../" );
?>
</head>
<body>
	<?php
	include_once (dirname ( __FILE__ ) . "/../lib/header.php");
	?>
	<br />
	<br />
	<br />
	<br />
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="drop-shadow lifted">
					<a href="../images/features/publish-and-promote/free-subdomain.png"
						target="_blank"><img
						src="../images/features/publish-and-promote/free-subdomain.png" /></a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading clearfix">
					<span class="pull-left panel-title"><i class="icon-arrow-left-2"></i>&nbsp;&nbsp;<a
						href="batch-management.php">Batch Management</a></span>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-8 text-justify">
							<h3>Publish &amp; Promote</h3>
							<?php echo(CConfig::SNC_SITE_NAME);?>'s <b><i>Publish &amp; Promote</i></b> feature is
							unique phenomenon to promote your business for free, by
							publishing test at <a href="http://practice.<?php echo(strtolower(CConfig::SNC_SITE_NAME)); ?>.co">practice.<?php echo(strtolower(CConfig::SNC_SITE_NAME)); ?>.co</a>
							you will be exposing your training methods and market yourself in
							this free test prepration market place by hilightling how good
							your test prepration methods are. <br /> <br /> Our <b><i>Publish &amp; Promote</i></b> 
							feature serves win-win strategy for candidate-<b>you</b>. It's
							free for candidate and we get candidate information before
							releasing test performance details to candidate and you can get
							that information with candidate's details by navigating to <b>Practice Test Result</b>.
						</div>
						<div class="col-md-4">
							<div class="drop-shadow lifted">
								<a href="../images/features/publish-and-promote/manage-test.png"
									target="_blank"> <img
									src="../images/features/publish-and-promote/manage-test.png" /></a>
							</div>
							<div class="drop-shadow lifted">
								<a href="../images/features/publish-and-promote/free-user-results.png"
									target="_blank"> <img
									src="../images/features/publish-and-promote/free-user-results.png" /></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
		<?php
		include ("../lib/footer.php");
		?>
		</div>
	</div>
</body>
</html>
