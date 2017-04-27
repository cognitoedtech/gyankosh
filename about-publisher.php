<!doctype html>
<?php
// header("Location: http://practice.quizus.co"); /* Redirect browser */
// exit();

include_once (dirname ( __FILE__ ) . "/lib/include_js_css.php");
include_once (dirname ( __FILE__ ) . "/database/config.php");
include_once (dirname ( __FILE__ ) . "/lib/session_manager.php");
include_once (dirname ( __FILE__ ) . "/lib/site_config.php");
include_once (dirname ( __FILE__ ) . "/lib/utils.php");
include_once (dirname ( __FILE__ ) . "/lib/user_manager.php");
include_once (dirname ( __FILE__ ) . "/database/mcat_db.php");
include_once (dirname ( __FILE__ ) . "/3rd_party/recaptcha/recaptchalib.php");

$page_id = CSiteConfig::HF_INDEX_ID;
$login = CSessionManager::Get ( CSessionManager::BOOL_LOGIN );

$jsonCartItems = CSessionManager::Get ( CSessionManager::JSON_CART_ITEMS );
$aryCartItems = json_decode ( $jsonCartItems, TRUE );

$objDB = new CMcatDB ();
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
<title><?php echo(CConfig::SNC_SITE_NAME." - ".CConfig::SNC_PUNCH_LINE);?></title>
<?php
$objIncludeJsCSS->CommonIncludeCSS ( "" );
$objIncludeJsCSS->IncludeTVCSS ( "" );
$objIncludeJsCSS->IncludeMipcatCSS ( "" );
$objIncludeJsCSS->IncludeIconFontCSS ( "" );

$objIncludeJsCSS->CommonIncludeJS ( "" );
$objIncludeJsCSS->IncludeMetroDatepickerJS ( "" );
$objIncludeJsCSS->IncludeJqueryFormJS ( "" );
$objIncludeJsCSS->IncludeJqueryValidateMinJS ( "", "1.16.0" );
?>
		<!-- CSS -->

<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/responsive.css">
<link rel="icon" href="images/gini-favicon.png" type="image/png">

<style type="text/css">
.spinner {
	width: 50px;
}

.spinner input {
	text-align: center;
}

.input-group-btn-vertical {
	position: relative;
	white-space: nowrap;
	width: 1%;
	vertical-align: middle;
	display: table-cell;
}

.input-group-btn-vertical>.btn {
	display: block;
	float: none;
	width: 100%;
	max-width: 100%;
	padding: 7px;
	margin-left: -1px;
	position: relative;
	border-radius: 0;
}

.input-group-btn-vertical>.btn:first-child {
	border-top-right-radius: 4px;
}

.input-group-btn-vertical>.btn:last-child {
	margin-top: -2px;
	border-bottom-right-radius: 4px;
}

.input-group-btn-vertical i {
	position: absolute;
	top: 0;
	left: 4px;
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

<!-- Js -->
<script src="js/vendor/modernizr-2.6.2.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/mipcat/utils.js"></script>
<script>
         new WOW(
            ).init();
        </script>
</head>
<body style="margin-top: 100px;">

	<?php
	include_once (dirname ( __FILE__ ) . "/lib/header.php");
	?>
	
	<!-- ************************* -->
	<div class="fuelux modal1">
		<div class="preloader">
			<i></i><i></i><i></i><i></i>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-3">
				<div class="row">
					<img src="images/product-details/boy-with-books.jpg" alt="..."
						class="img-thumbnail img-responsive">
				</div>
				<br/>
				<div class="row" style="padding-right:15px;">
					<div class="col-lg-12 col-md-12 col-sm-12 img-thumbnail img-responsive">
						<address>
							<strong>Cognito EdTech Pvt. Ltd.</strong><br /> 1355 Market
							Street, Suite 900<br /> San Francisco, CA 94103<br /> <abbr
								title="Phone">P:</abbr> (123) 456-7890<br /> <abbr title="Email">@:</abbr>
							<a href="mailto:first.last@example.com">first.last[at]example.com</a><br />
							<abbr title="Website"><i class="fa fa-globe" aria-hidden="true"></i>:</abbr>
							<a href="">http://www.cognitoedtech.com</a><br />
						</address>
					</div>
				</div>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-9"
				style="border-left: 1px solid #eee; padding-left: 30px;">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<h2>Cognito EdTech Pvt. Ltd.</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-8 col-md-8 col-sm-8">
						<div class="row">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce
								tellus nisi, blandit vitae lobortis vitae, sagittis eget tortor.
								Morbi tincidunt aliquam ex, at sollicitudin dolor volutpat et.
								Phasellus suscipit iaculis lobortis. Aliquam euismod sed magna
								et viverra. Suspendisse ultrices dolor ac nunc imperdiet, at
								malesuada tellus eleifend. Fusce velit eros, hendrerit quis enim
								sit amet, accumsan feugiat purus. Maecenas a tellus in nisl
								finibus semper. Sed nulla ex, tristique ut erat vitae, sagittis
								laoreet ipsum. Aliquam erat volutpat. Etiam cursus vel dui sit
								amet viverra. Curabitur ut dui quam.</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4"
						style="border-left: 1px solid #ddd;">
						<button class="btn btn-default btn-lg video"
							data-video="https://www.youtube.com/embed/HBdcL7YsdBY"
							data-toggle="modal" data-target="#videoModal"><img src="images/home/video-placeholder.jpg" alt="..."></button>
						<div class="modal fade" id="videoModal" tabindex="-1"
							role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-body">
										<button type="button" class="close" data-dismiss="modal"
											aria-label="Close">
											<i class="fa fa-times" aria-hidden="true"></i>
										</button>
										<iframe width="100%" height="350" src="" frameborder="0" style="padding:20px" 
											allowfullscreen></iframe>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr/>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<h4>Courses/Program Offered</h4>
						<ol>
							<li><h5>CAT: </h5>We offer CAT prep course</li>
							<li><h5>IBPS: </h5>We offer IBPS prep course</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<p class="text-center"><?php include ("lib/footer.php"); ?></p>
	</div>

	<!-- ************************* -->
	<script type="text/javascript">
		$( document ).ready(function() {
			
		});

		 $(function() {
			$(".video").click(function () {
				var theModal = $(this).data("target"),
			    videoSRC = $(this).attr("data-video"),
			    videoSRCauto = videoSRC + "?modestbranding=1&rel=0&controls=0&showinfo=0&html5=1&autoplay=1";
			    $(theModal + ' iframe').attr('src', videoSRCauto);

			    $(theModal + ' button.close').click(function () {
			    	$(theModal + ' iframe').attr('src', videoSRC);
			    });
			});
		});
	</script>
</body>
</html>
