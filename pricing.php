<!doctype html>
<?php 
	include_once(dirname(__FILE__)."/lib/include_js_css.php");
	include_once(dirname(__FILE__)."/lib/session_manager.php");
	include_once(dirname(__FILE__)."/database/config.php");
	
	$objIncludeJsCSS = new IncludeJSCSS();
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="Generator" content="Mastishka Intellisys Private Limited">
<meta name="Author" content="Mastishka Intellisys Private Limited">
<meta name="Keywords" content="">
<meta name="Description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo(CConfig::SNC_SITE_NAME);?> - Pricing</title>
<?php 
$objIncludeJsCSS->CommonIncludeCSS("");
$objIncludeJsCSS->IncludeMipcatCSS("");
$objIncludeJsCSS->IncludeIconFontCSS("");
$objIncludeJsCSS->IncludePricingCSS("");
$objIncludeJsCSS->CommonIncludeJS("");
?>
</head>
<body>
	<?php 
	include_once(dirname(__FILE__)."/lib/header.php");
	?>
	<!-- ********************************** -->
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-6">
				<div class="drop-shadow curved curved-vt-2"
					style="width: 91%; height: 500px; margin-top: 100px">
					<h3><i>Pay only when you are using our services!</i></h3><br/>
					<iframe width="100%" height="360" src="https://www.youtube.com/embed/HRbMDvo59g4?rel=0" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
			<div class="col-xs-6 col-md-6">
				<div id="pricing-table" style="width: 100%;" class="clear">
					<div class="plan">
						<h3>
							Standard <span>$<?php echo(CConfig::SPR_BASIC * CConfig::SPR_MINIMUM_TESTS);?> <br/>(Rs.3300) </span>
						</h3>
						<a class="signup" href="<?php echo CSiteConfig::ROOT_URL;?>/login/register-org.php?plan=basic">Sign up</a>
						<ul>
							<li><b>$<?php echo(CConfig::SPR_BASIC * CConfig::SPR_MINIMUM_TESTS);?> (Rs.3300)</b> Minimum Recharge</li>
							<li class="alert-info"><b>$<?php echo(CConfig::SPR_BASIC);?> (Rs.60)</b> per test/user</li>
							<?php if(false){ ?>
							<li class="alert-info">OR <b>$1.00</b> per user monthly (unlimited)</li>
							<?php  } ?>
							<li></li>
							<li class="alert-danger">Candidate Management</li>
							<li>Bulk Upload Candidate Information</li>
							<li><span style="text-decoration:line-through" > Candidate Batches</span> </li>
							<li style="text-decoration:line-through">Co-ordinator Management</li>
							<li class="alert-danger">Knowledge Base Management</li>
							<li style="text-decoration:line-through">Use EZeeAssess Question</li>
							<li>Use Personal Question</li>
							<li class="alert-danger">Test Design &amp; Management</li>
							<li>Design as per requirement</li>
							<!-- <li>Static Test Design</li> -->
							<li>Dynamic Test Design</li>
							<li>Test Failsafe Enablement</li>
							<li>Cheating Prevention Algorithm</li>
							<li style="text-decoration:line-through">Active Test Monitoring </li>
							<li>Result Visiblity Control</li>
							<li class="alert-danger">Test Scheduling</li>
							<li>Time Zone Specific Test Scheduling</li>
							<li>Test Rescheduling</li>
							<li>Test Cancelation</li>
							<li class="alert-danger">Analytics</li>
							<li style="text-decoration:line-through">Result Analytics/Charts</li>
							<li style="text-decoration:line-through">Question Paper Inspection </li>
							<li style="text-decoration:line-through">Result Consolidation</li>
							<li class="alert-danger">Billing Management</li>
							<li>Live Billing information</li>
							<li>Online Account Recharge</li>
							<li class="alert-danger">Personalization</li>
							<li>Personalized URL</li>
							<li>Personalized LOGO</li>
						</ul>
					</div>
					<div class="plan" id="most-popular">
						<h3>
							Professional<span>$<?php echo(CConfig::SPR_PROFESSIONAL * CConfig::SPR_MINIMUM_TESTS);?><br/>(Rs.6600)</span>
						</h3>
						<a class="signup" href="<?php echo CSiteConfig::ROOT_URL;?>/login/register-org.php?plan=professional">Sign up</a>
						<ul>
							<li><b>$<?php echo(CConfig::SPR_PROFESSIONAL * CConfig::SPR_MINIMUM_TESTS);?> (Rs.6600)</b> Minimum Recharge</li>
							<li class="alert-info"><b>$<?php echo(CConfig::SPR_PROFESSIONAL);?> (Rs.66)</b> per test/user</li>
							<?php if(false){ ?>
							<li class="alert-info">OR <b>$1.70</b> per user monthly (unlimited)</li>
							<?php } ?>
							<li></li>
							<li class="alert-danger">Candidate Management</li>
							<li>Bulk Upload Candidate Information</li>
							<li class="text-success"><b> Candidate Batches </b> </li>
							<li style="text-decoration:line-through">Co-ordinator Management</li>
							<li class="alert-danger">Knowledge Base Management</li>
							<li style="text-decoration:line-through">Use EZeeAssess Question</li>
							<li>Use Personal Question</li>
							<li class="alert-danger">Test Design &amp; Management</li>
							<li>Design as per requirement</li>
							<!-- <li>Static Test Design</li> -->
							<li>Dynamic Test Design</li>
							<li>Test Failsafe Enablement</li>
							<li>Cheating Prevention Algorithm</li>
							<li style="text-decoration:line-through">Active Test Monitoring</li>
							<li>Result Visiblity Control</li>
							<li class="alert-danger">Test Scheduling</li>
							<li>Time Zone Specific Test Scheduling</li>
							<li>Test Rescheduling</li>
							<li>Test Cancelation</li>
							<li class="alert-danger">Analytics</li>
							<li class="text-success"><b> Result Analytics/Charts </b></li>
							<li class="text-success"><b> Question Paper Inspection</b> </li>
							<li class="text-success"><b> Result Consolidation</b> </li>
							<li class="alert-danger">Billing Management</li>
							<li>Live Billing information</li>
							<li>Online Account Recharge</li>
							<li class="alert-danger">Personalization</li>
							<li>Personalized URL</li>
							<li>Personalized LOGO</li>
						</ul>
					</div>
					<div class="plan">
						<h3>
							Enterprise<span>$<?php echo(CConfig::SPR_ENTERPRISE * CConfig::SPR_MINIMUM_TESTS);?><br/>(Rs.13200)</span>
						</h3>
						<a class="signup" href="<?php echo CSiteConfig::ROOT_URL;?>/login/register-org.php?plan=enterprise">Sign up</a>
						<ul>
							<li><b>$<?php echo(CConfig::SPR_ENTERPRISE * CConfig::SPR_MINIMUM_TESTS);?> (Rs.13200)</b> Minimum Recharge</li>
							<li class="alert-info"><b>$<?php echo(CConfig::SPR_ENTERPRISE);?> (Rs.132)</b> per test/user</li>
							<?php if(false){ ?>
							<li class="alert-info">OR <b>$2.50</b> per user monthly (unlimited)</li>
							<?php } ?>
							<li></li>
							<li class="alert-danger">Candidate Management</li>
							<li>Bulk Upload Candidate Information</li>
							<li class="text-success"> <b> Candidate Batches </b></li>
							<li class="text-success"><b> Co-ordinator Management </b></li>
							<li class="alert-danger">Knowledge Base Management</li>
							<li class="text-success"><b> Use EZeeAssess Question</b></li>
							<li>Use Personal Question</li>
							<li class="alert-danger">Test Design &amp; Management</li>
							<li>Design as per requirement</li>
							<!-- <li>Static Test Design</li> -->
							<li>Dynamic Test Design</li>
							<li>Test Failsafe Enablement</li>
							<li>Cheating Prevention Algorithm</li>
							<li class="text-success"> <b>Active Test Monitoring </b></li>
							<li>Result Visiblity Control</li>
							<li class="alert-danger">Test Scheduling</li>
							<li>Time Zone Specific Test Scheduling</li>
							<li>Test Rescheduling</li>
							<li>Test Cancelation</li>
							<li class="alert-danger">Analytics</li>
							<li class="text-success"><b> Result Analytics/Charts</b></li>
							<li class="text-success"><b> Question Paper Inspection </b></li>
							<li class="text-success"><b> Result Consolidation</b></li>
							<li class="alert-danger">Billing Management</li>
							<li>Live Billing information</li>
							<li>Online Account Recharge</li>
							<li class="alert-danger">Personalization</li>
							<li>Personalized URL</li>
							<li>Personalized LOGO</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		$(".icon-home").addClass("glyphicon");
		$(".icon-home").addClass("glyphicon-home");
	
		$(".icon-user").addClass("glyphicon");
		$(".icon-user").addClass("glyphicon-user");
	</script>
</body>
</html>
