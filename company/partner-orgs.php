<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
	include_once(dirname(__FILE__)."/../lib/session_manager.php");
	include_once(dirname(__FILE__)."/../lib/include_js_css.php");
	include_once(dirname(__FILE__)."/../lib/site_config.php");
	include_once(dirname(__FILE__)."/../lib/utils.php");
	$page_id = CSiteConfig::HF_FAQ;
	$login = CSessionManager::Get(CSessionManager::BOOL_LOGIN);
	
	$objIncludeJsCSS = new IncludeJSCSS();
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Contact Us</title>		
		<?php 
			$objIncludeJsCSS->CommonIncludeCSS("../");
			$objIncludeJsCSS->CommonIncludeJS("../");
		?>
	</head>
	<body>
		<!-- Header -->
		<?php
			include(dirname(__FILE__)."/../lib/header.php");
		?>
		<div class="container">
			<h3 style="text-align:center;color:steelblue;">Test Provides on <?php echo(CConfig::SNC_SITE_NAME);?></h3><br/>
			
			<div class="col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
			<?php
			include ("../lib/footer.php");
			?>
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