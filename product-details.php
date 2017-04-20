<!doctype html>
<?php
// header("Location: http://practice.quizus.co"); /* Redirect browser */
// exit();

include_once (dirname ( __FILE__ ) . "/lib/include_js_css.php");
include_once (dirname ( __FILE__ ) . "/lib/session_manager.php");
include_once (dirname ( __FILE__ ) . "/lib/site_config.php");
include_once (dirname ( __FILE__ ) . "/lib/utils.php");
include_once (dirname ( __FILE__ ) . "/database/config.php");
include_once (dirname ( __FILE__ ) . "/database/mcat_db.php");
include_once (dirname ( __FILE__ ) . "/3rd_party/recaptcha/recaptchalib.php");

$page_id = CSiteConfig::HF_INDEX_ID;
$login = CSessionManager::Get ( CSessionManager::BOOL_LOGIN );
$jsonCartItems = CSessionManager::Get ( CSessionManager::JSON_CART_ITEMS );

$parsAry = parse_url ( CUtils::curPageURL () );
$qry = split ( "[=&]", $parsAry ["query"] );

$objUtils = new CUtils ();
// print_r($qry);
if (strcasecmp ( $qry [2], "product-id" ) != 0 && strcasecmp ( $qry [4], "product-type" ) != 0) {
	// echo("\nTest - 1");
	$objUtils->Redirect ( "search-results.php" );
}
/*
 * if($login) { CUtils::Redirect("core/dashboard.php"); } else
 * if(CSiteConfig::DEBUG_SITE == true && stristr($parsAry["host"],
 * strtolower(CConfig::SNC_SITE_NAME).".com") == FALSE) { if($qry[0] != "debug"
 * && $qry[1] != "639") { CUtils::Redirect(CSiteConfig::ROOT_URL, true); } }
 */

$login_name = $_GET ['ln'];
if (! empty ( $login_name )) {
	CSessionManager::Set ( CSessionManager::STR_LOGIN_NAME, $login_name );
} else if (! $login) {
	CSessionManager::UnsetSessVar ( CSessionManager::STR_LOGIN_NAME );
}

$product_id = $qry [3];
$product_type = $qry [5];

$objDB = new CMcatDB ();

$aryPublishedProduct = $objDB->GetPublishedProductDetails ( $product_id, $product_type );
$aryPublishedInfo = json_decode ( $aryPublishedProduct ['published_info'], TRUE );

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
<link rel="shortcut icon"
	href="<?php echo(CSiteConfig::ROOT_URL);?>/favicon.ico?v=1.1">
<?php
$objIncludeJsCSS->CommonIncludeCSS ( "" );
$objIncludeJsCSS->IncludeMipcatCSS ( "" );
$objIncludeJsCSS->IncludeIconFontCSS ( "" );
$objIncludeJsCSS->IncludeFuelUXCSS ( "" );

$objIncludeJsCSS->CommonIncludeJS ( "" );
$objIncludeJsCSS->IncludeMetroNotificationJS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeJqueryRatyJS ( "" );
?>
		<!-- CSS -->

<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/responsive.css">
<link rel="icon" href="images/gini-favicon.png" type="image/png">

<style type="text/css">
.popover {
	width: 550px !important;
}

.progress {
	height: 10px !important;
	margin-top: 6px !important;
}

.input-group-btn select {
	border-color: #ccc;
	margin-top: 0px;
	margin-bottom: 0px;
	padding-top: 9px;
	padding-bottom: 7px;
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
<body style="margin-top: 70px; overflow-x:hidden;">

	<?php
	include_once (dirname ( __FILE__ ) . "/lib/header.php");
	?>
	
	<!-- ************************* -->

	
		<div  class="row-fluid">
			<div class="col-sm-3 col-md-3 col-lg-3">
			<?php
			include_once (dirname ( __FILE__ ) . "/lib/sr-sidebar.php");
			?>
			</div>
			<div class="col-sm-9 col-md-9 col-lg-9" style="border-left: 1px solid #ddd;">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="row">
							<div class="col-lg-10 col-md-10 col-sm-10">
								<img src="images/product-details/boy-with-books.jpg" alt="..."
									class="img-thumbnail img-responsive">
							</div>
						</div>
						<hr />
						<div class="row">
							<div class="col-lg-10 col-md-10 col-sm-10">
								<span class="h5">Who should buy?</span><br />
								<p id="who-should-buy"><?php echo($aryPublishedProduct['who_should_buy']);?></p>
							</div>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-8">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								by <a
									href="search-results.php?company-name=<?php echo(urldecode($aryPublishedProduct['org_name']));?>&id=<?php echo($aryPublishedInfo['org_id']);?>"><?php echo($aryPublishedProduct['org_name']);?></a>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div id="product-heading" class="h3"><?php echo($aryPublishedProduct['product_name']);?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3 col-sm-3">
								<span id="product-rating" data-score="1"></span> <a href="#"
									id="product-rating-details" class="btn btn-xs"
									data-toggle="popover" data-trigger="hover"
									data-placement="bottom"><i class="fa fa-sort-desc"
									aria-hidden="true"></i> </a>
							</div>
							<div class="col-lg-9 col-md-9 col-sm-9">
								<a href="#">21 Customer Reviews</a>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="h3 img-thumbnail">
									<i class="fa fa-inr" aria-hidden="true"></i> <?php echo($aryPublishedInfo['cost']['inr']);?>
								</div>
							</div>
						</div>
						<hr />
						<div class="row">
							<div class="col-lg-9 col-md-9 col-sm-9">
								<button class="btn btn-info col-lg-3 col-md-3 col-sm-3">
									Add to cart <i class="fa fa-shopping-cart" aria-hidden="true"></i>
								</button>
								<button
									class="btn btn-success col-lg-3 col-md-3 col-sm-3 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
									Buy Now <i class="fa fa-credit-card" aria-hidden="true"></i>
								</button>
							</div>
						</div>
						<hr />
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<span class="h5">Description:</span> <span
									id="product-description"> <?php echo($aryPublishedProduct['description']);?> </span>
							</div>
						</div>
						<hr />
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<span class="h5">Suggested Reads:</span> <span
									id="suggested-reads"> <?php echo($aryPublishedInfo['suggested_reads']);?> </span>
							</div>
						</div>
						<hr />
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<span class="h5">What will you acheive?:</span> <span
									id="what-will-you-acheive"> <?php echo($aryPublishedInfo['what_will_you_acheive']);?> </span>
							</div>
						</div>
						<hr />
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<label for="basic-url">Provide review for this test/package</label>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon3">Subject</span>
									<input type="text" class="form-control" id="basic-url"
										aria-describedby="basic-addon3" /> <span
										class="input-group-addon" id="basic-addon3">Rating</span> <span
										class="input-group-btn" aria-describedby="basic-addon3"> <select
										class="btn">
											<option value=5>5 Stars</option>
											<option value=4>4 Stars</option>
											<option value=3>3 Stars</option>
											<option value=2>2 Stars</option>
											<option value=1>1 Star</option>
									</select>
									</span>
								</div>
								<textarea class="form-control" rows="3"
									placeholder="Review Comments"></textarea>
								<button class="btn btn-default" type="submit">Submit</button>
							</div>
						</div>
					</div>
				</div>
				<hr />
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<a name="review"></a>
						<div class="panel panel-default">
							<div class="panel-heading">
								<span id="product-rating-user-1" data-score="1"></span> This is
								an awesome test by Prerna Arora
							</div>
							<div class="panel-body">I have</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<p class="text-center"><?php include ("lib/footer.php"); ?></p>
	

	<!-- ************************* -->
	<script type="text/javascript">
		function stay_connected()
		{
			return objUtils.stay_connected();
		}

		$('#product-rating').raty({
			readOnly  : true,
		    half      : true,
		    size      : 18,
		    score	  : 4.5,
		    starHalf  : '<?php echo(CSiteConfig::ROOT_URL);?>/3rd_party/raty/demo/img/star-half-big-sm.png',
		    starOff   : '<?php echo(CSiteConfig::ROOT_URL);?>/3rd_party/raty/demo/img/star-off-big-sm.png',
		    starOn    : '<?php echo(CSiteConfig::ROOT_URL);?>/3rd_party/raty/demo/img/star-on-big-sm.png'
		});

		$('#product-rating-user-1').raty({
			readOnly  : true,
		    half      : true,
		    size      : 18,
		    score	  : 5,
		    starHalf  : '<?php echo(CSiteConfig::ROOT_URL);?>/3rd_party/raty/demo/img/star-half-big-sm.png',
		    starOff   : '<?php echo(CSiteConfig::ROOT_URL);?>/3rd_party/raty/demo/img/star-off-big-sm.png',
		    starOn    : '<?php echo(CSiteConfig::ROOT_URL);?>/3rd_party/raty/demo/img/star-on-big-sm.png'
		});

		$(document).ready(function(){
		    $('#product-rating-details').popover({ html:true, title:"<span style='width:300px'>4.5 stars out of 5.0</span>", content:"<div class='row'><div class='col-lg-12 col-md-12 col-sm-12'><div class='col-lg-2 col-md-2 col-sm-2'><small>5</small></div><div class='col-lg-8 col-md-8 col-sm-8'><div class='progress'><div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='90' aria-valuemin='0' aria-valuemax='100' style='width: 90%;'></div></div></div><div class='col-lg-2 col-md-2 col-sm-2'><small>100%</small></div></div></div><div class='row'><div class='col-lg-12 col-md-12 col-sm-12'><div class='col-lg-2 col-md-2 col-sm-2'><small>5</small></div><div class='col-lg-8 col-md-8 col-sm-8'><div class='progress'><div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='90' aria-valuemin='0' aria-valuemax='100' style='width: 90%;'></div></div></div><div class='col-lg-2 col-md-2 col-sm-2'><small>100%</small></div></div></div>"});
		});
		
		$(".icon-home").addClass("glyphicon");
		$(".icon-home").addClass("glyphicon-home");
	
		$(".icon-user").addClass("glyphicon");
		$(".icon-user").addClass("glyphicon-user");

		(function ($) {
			  $('.spinner .btn:first-of-type').on('click', function() {
			    $('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
			  });
			  $('.spinner .btn:last-of-type').on('click', function() {
			    $('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
			  });
			})(jQuery);
	</script>
</body>
</html>
