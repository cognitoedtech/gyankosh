<!doctype html>
<?php
include_once (dirname ( __FILE__ ) . "/lib/session_manager.php");
include_once (dirname ( __FILE__ ) . "/database/mcat_db.php");
include_once (dirname ( __FILE__ ) . "/lib/include_js_css.php");
include_once (dirname ( __FILE__ ) . "/lib/site_config.php");

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
</head>
<body ng-app="QuizUS" style="overflow-x: hidden;" ng-cloak>
	<?php
	include_once (dirname ( __FILE__ ) . "/lib/header.php");
	?>
	<div id="overlay" style="display: none;">
		<iframe id="overlay_frame" src="#" width="100%" height="100%"></iframe>
	</div>

	<div id="scrollUp"></div>

	<div class="row" style="margin-top: 23px;">
		<div class="fuelux modal1">
			<div class="preloader">
				<i></i><i></i><i></i><i></i>
			</div>
		</div>
	</div>
	<div class="row-fluid" id="main" style="margin-top: 23px;">
		<div class="col-lg-3 col-md-3 col-sm-3">
		<?php
		include_once (dirname ( __FILE__ ) . "/lib/sr-sidebar.php");
		?>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9"
			style="border-left: 1px solid #ddd;">
			<div class="row">
				<div
					class="col-sm-9 col-md-9 col-lg-9"
					style="position: fixed; z-index: 100; margin-top: -15px;">
					<div class="drop-shadow">
						<form id="search_form" action="search-results.php" method="post">
							<div class="row">
								<div class="col-sm-6 col-md-6 col-lg-6">
									<input class="form-control" type="text" name="search_text"
										placeholder="Search Practice Tests / Quizzes / Assessments"
										value="<?php echo(trim($_POST['search_text']));?>" />
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3">
									<select name="search_category" class="form-control">
										<option value="keywords"
											<?php echo(($_POST['search_category'] == "keywords")?"selected='selected'":"");?>>by
											Keywords</option>
										<option value="test_name"
											<?php echo(($_POST['search_category'] == "test_name")?"selected='selected'":"");?>>by
											Test Name</option>
										<option value="inst_name"
											<?php echo(($_POST['search_category'] == "inst_name")?"selected='selected'":"");?>>by
											Organization Published</option>
									</select>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3">
									<button type="submit" class="btn btn-primary">
										<b><i class="fa fa-search" aria-hidden="true"></i> Search</b>
									</button>
									<button type="button" class="btn btn-primary btn-sm"
										onclick="window.location=window.location">
										<b><i class="fa fa-th-large" aria-hidden="true"></i> Explore All</b>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- Search Results -->
				<div ng-controller="InfiniteScrollDemoController" style="margin-top: 100px;">
					<div tagged-infinite-scroll="getMore()"
						tagged-infinite-scroll-disabled="!enabled || paginating"
						tagged-infinite-scroll-distance="distance">
						<div class="items" ng-class="{ paginating: paginating }">
							<div ng-repeat="item in items">
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-3"
										style="padding-right: 30px; border-top: 1px solid #eee;">
										<div class="drop-shadow">
											<img alt="..." ng-src='{{item.product_image}}' style='' />
										</div>
									</div>
									<div class="col-lg-8 col-md-8 col-sm-8"
										style="border-left: 1px solid #eee; border-top: 1px solid #eee; padding-left: 30px;">
										<div class="row">
											<div class="h5">
												<br />by <a href="{{item.org_url}}">{{item.org_name}}</a>
											</div>
										</div>
										<div class="row">
											<div class="h3">
												<a href="{{item.product_page}}">{{ item.product_name }}</a>
												<img src="images/search-results/free-sm.jpg" alt="free"
													style="visibility: {{!item.inr_cost||   'hidden'" />
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3 col-md-3 col-sm-3">
												<span class="h4"
													style="border: 1px solid #ddd; padding: 5px;"> <i
													class="fa fa-inr" aria-hidden="true"></i> {{item.inr_cost}}
												</span>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-4">
												<span is_rated="false" name='{{item.product_id}}_star'
													data-score='{{item.rating}}' id='{{item.product_id}}_star'
													class="star"></span></span> <a href="#"
													id="product-rating-details" class="btn btn-xs"
													data-toggle="popover" data-trigger="hover"
													data-placement="bottom"><i class="fa fa-sort-desc"
													aria-hidden="true"></i> </a>
											</div>
											<div class="col-lg-5 col-md-5 col-sm-5">
												<a href="{{item.review_bookmark}}">{{item.total_reviews}} Customer Reviews</a>
											</div>
										</div>
										<hr />
										<div class="row">
											<div class="col-lg-9 col-md-9 col-sm-9"
												ng-controller="actionButtonsController">
												<button class="btn btn-info col-lg-3 col-md-3 col-sm-3"
													ng-click="OnAddToCart(item.product_name,item.product_id,item.product_type);">
													Add to cart<i class="fa fa-shopping-cart"
														aria-hidden="true"></i>
												</button>
												<button
													class="btn btn-success col-lg-3 col-md-3 col-sm-3 col-lg-offset-1 col-md-offset-1 col-sm-offset-1"
													ng-click="OnBuyNow(item.product_name,item.product_id,item.product_type);">
													Buy Now <i class="fa fa-credit-card" aria-hidden="true"></i>
												</button>
											</div>
										</div>
										<hr />
										<div class="row">
											<span class="h5">Description:</span><span
												id="product-description"> {{ item.description }} <a
												href="{{item.product_page}}">more...</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ****************************************************** -->


	<script type="text/javascript">
		var demo = angular.module('QuizUS', ['tagged.directives.infiniteScroll']);
		var limit_start_value = 0;

		$(document).ready(function(){
		    $('#product-rating-details').popover({ html:true, title:"<span style='width:300px'>4.5 stars out of 5.0</span>", content:"<div class='row'><div class='col-lg-12 col-md-12 col-sm-12'><div class='col-lg-2 col-md-2 col-sm-2'><small>5</small></div><div class='col-lg-8 col-md-8 col-sm-8'><div class='progress'><div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='90' aria-valuemin='0' aria-valuemax='100' style='width: 90%;'></div></div></div><div class='col-lg-2 col-md-2 col-sm-2'><small>100%</small></div></div></div><div class='row'><div class='col-lg-12 col-md-12 col-sm-12'><div class='col-lg-2 col-md-2 col-sm-2'><small>5</small></div><div class='col-lg-8 col-md-8 col-sm-8'><div class='progress'><div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='90' aria-valuemin='0' aria-valuemax='100' style='width: 90%;'></div></div></div><div class='col-lg-2 col-md-2 col-sm-2'><small>100%</small></div></div></div>"});
		});
		
		function InfiniteScrollDemoController($scope, $timeout) {
		  $scope.items = [];
		  $scope.distance = 0;
		  $scope.paginating = false;
		  $scope.enabled = true;
	
		  // This is called each time the infinite scroll directive needs to get more items.
		  // This dummy implementation simply adds fake items to `$scope.items` and limits
		  // itself to 50 items.
		  $scope.getMore = function() {
		    if (true === $scope.paginating) return;
	
		    var timeout = ($scope.items.length ? 1000 : 0);
		    $scope.paginating = true;
	
		    $.ajax({
				url: '<?php echo(CSiteConfig::ROOT_URL);?>/core/index/ajax/ajax_get_search_results.php',
				type: 'POST',
				data: {'search_text' : '<?php echo(trim($_POST['search_text']));?>', 'search_category' : '<?php echo($_POST['search_category']);?>', 'limit_start_value' : limit_start_value},
				dataType: 'json',
				async: false,
				success: function(data) {
					$.each(data, function(key, value){
						if(key == "next_limit_start_value")
						{
							limit_start_value = value;
						}
						else
						{
							$scope.items.push({
								product_name: value['product_name'],
								description: value['description'].substring(0, 128),
								keywords: value['keywords'],
								org_name: value['org_name'],
								org_url: '<?php echo(CSiteConfig::ROOT_URL);?>/search-results.php?company-name='+encodeURIComponent(value['org_name']),
								org_id: value['org_id'],
								product_id: value['product_id'],
								product_type: value['product_type'],
								rating: value['rating'],
								inr_cost: value['inr_cost'] ? value['inr_cost'] : 0,
								usd_cost: value['usd_cost'] ? value['usd_cost'] : 0,
								total_reviews: value['total_reviews'],
								product_image: '<?php echo(CSiteConfig::ROOT_URL);?>/lib/fetch_base64_image.php?product_id='+value['product_id']+'&product_type='+value['product_type']+'&random=1',
								product_page: '<?php echo(CSiteConfig::ROOT_URL);?>/product-details.php?product='+encodeURIComponent(value['product_name'])+'&product-id='+value['prod_enct'],
								review_bookmark: '<?php echo(CSiteConfig::ROOT_URL);?>/product-details.php?product='+encodeURIComponent(value['product_name'])+'&product-id='+value['product_id']+'&product-type='+value['product_type']+'#review'
						    });
						}
					});
					$scope.paginating = false;
			
					if(limit_start_value == 0)
					{
						$("#empty_search").show();
					}
					else
					{
						$("#empty_search").hide();
					}
	
					setTimeout(function(){
					    $scope.$apply(function() {
					        // jQuery stuff here
	
					    	$("span[name$='_star']").each(function(){
						    	if($(this).attr("is_rated") === "false")
						    	{
						    		$(this).raty({
						    			readOnly  : true,
									    half      : true,
									    size      : 18,
									    score	  : $(this).attr("data-score"),
									    starHalf  : '<?php echo(CSiteConfig::ROOT_URL);?>/3rd_party/raty/demo/img/star-half-big-sm.png',
									    starOff   : '<?php echo(CSiteConfig::ROOT_URL);?>/3rd_party/raty/demo/img/star-off-big-sm.png',
									    starOn    : '<?php echo(CSiteConfig::ROOT_URL);?>/3rd_party/raty/demo/img/star-on-big-sm.png'
									});
						    		$(this).attr("is_rated","true");
							    }
							});
					    }), 3000
					 });
				},
				error: function (request, status, error) {
			        //$("#main").html(request.responseText);
			    }
			});
			
		  };
	
		  $scope.getMore();
	
		  $scope.reset = function() {
		    $scope.items = [];
		    $scope.getMore();
		  };
	
		  $scope.ShowOverlay = function(test_id, div_id) {
			  var current_date = new Date();
			    var time_zone = -current_date.getTimezoneOffset() / 60;
	
			    var url = "<?php echo(CSiteConfig::ROOT_URL);?>/test/test.php?test_id="+test_id+"&tschd_id=<?php echo(CConfig::FEUC_TEST_SCHEDULE_ID);?>";
				var height	  = $(window).height();
				$("#overlay_frame").attr("src",url+"&time_zone="+time_zone+"&height="+height).ready(function(){
					$("#overlay").show(800);
					$("body").css("overflow", "hidden");
					$("#header").hide();
				});
		  };
		}
	
		// Here "addEventListener" is for standards-compliant web browsers and "attachEvent" is for IE Browsers.
		var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
		var eventer = window[eventMethod];
	
		// Now...
		// if 
		//    "attachEvent", then we need to select "onmessage" as the event. 
		// if 
		// 	  "addEventListener", then we need to select "message" as the event
		
		var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
		
		//Listen to message from child IFrame window
		eventer(messageEvent, function (e) 
		{		
			if (e.origin == '<?php echo(CSiteConfig::ROOT_URL);?>') 
			{
			 	if(e.data == 'RemoveTest')
				{
				  RemoveTest();
				}
				
				if(e.data == 'HideOverlay')
				{
				  HideOverlay();
				}			
			// Do whatever you want to do with the data got from IFrame in Parent form.
			}
		   // Do whatever you want to do with the data got from IFrame in Parent form.
		}, false);    
		
		
		function ShowOverlay(test_id, div_id)
		{
			var current_date = new Date();
		    var time_zone = -current_date.getTimezoneOffset() / 60;
		    
		    var url = "<?php echo(CSiteConfig::ROOT_URL);?>/test/test.php?test_id="+test_id+"&tschd_id=<?php echo(CConfig::FEUC_TEST_SCHEDULE_ID);?>";
			var height	  = $(window).height();
			$("#overlay_frame").attr("src",url+"&time_zone="+time_zone+"&height="+height).ready(function(){
				$("#overlay").show(800);
				$("body").css("overflow", "hidden");
				$("#header").hide();
			});
			
			RemoveTest.div_id = div_id;
		}
		
		function HideOverlay()
		{
			$("#overlay").hide(500);
			$("body").css("overflow", "auto");
			$("#header").show();
		}
		
		$("#ORG_TYPE").change(function(){
			if($("#ORG_TYPE").val() == "<?php echo(CConfig::$ORG_TYPE_ARY[CConfig::OT_OTHER]);?>")
			{
				$("#OTHER_ORG_DIV").show();
			}
			else
			{
				$("#OTHER_ORG_DIV").hide();
			}
		});

		function showResponse(responseText, statusText, xhr, form)
		{
			$(".modal1").hide();

			if($(form).attr("id") == "REQUESTFORM")
			{
				$("#demo_form_content").hide();
				$("#demo_response").html(responseText);
				$("#demo_response").show();
				$("#demo_submit_btn").hide();
				$("#demoRequest").modal();	 
			}
			else if($(form).attr("id") == "form_for_feedback")
			{
				$("#feedback_form_content").hide();
				$("#feedback_response").html(responseText);
				$("#feedback_response").show();
				$("#feedback_submit_btn").hide();
				$('#user_feedback').modal();
			}
		}

		var options = { 
	       	 	//target:        '',   // target element(s) to be updated with server response 
	       		// beforeSubmit:  showRequest,  // pre-submit callback 
	      	 	 success:       showResponse,  // post-submit callback 
	 
	        	// other available options: 
	        	url:      '<?php echo(CSiteConfig::ROOT_URL);?>/core/index/ajax/ajax_free_requests.php',         // override for form's 'action' attribute 
	        	type:      'POST',       // 'get' or 'post', override for form's 'method' attribute 
	        	//dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
	        	clearForm: true        // clear all form fields after successful submit 
	        	//resetForm: true        // reset the form after successful submit 
	 
	        	// $.ajax options can be used here too, for example: 
	        	//timeout:   3000 
	    	};
		
		$(document).ready(function() {
			$("#REQUESTFORM").validate({
	    		rules: {
	        		NAME: {
	            		required:true,
	       		 		minlength: 2
	        		},
	            	EMAIL: {
	            		required: true,
	            		email: true
	        		},
	        		CONTACT:{
	        			required:true,
	           	 		number: true,
	           		},
	        		ORG_TYPE:{
	        			required:true,
	               	},
	               	OTHER_ORG:{
	        			required:true,
	               	},
	               	ORG_NAME:{
	               		required:true,
	               	},	
	            	USAGE:{
	            		required:true,
	           		 },
	            	MESSAGE:{
	                	required:true,
	             	},
	            	VERIF_CODE:"required"
	    		},
	    		messages: {
	    			NAME: {	
	    				required:	"<span style='color:red'>* Please enter your name</span>",
	    				minlength:	"<span style='color:red'>* Minimum length of name should be 2</span>"
	        		},
	        		EMAIL:{
						required:	"<span style='color:red'>* Email id is required</span>",
						email:		"<span style='color:red'>* Please enter a valid email address</span"
					},	
					CONTACT:{
						required:	"<span style='color:red;'>* Please enter your contact no.</span>",
	        	 		number:		"<span style='color:red;'>* contact number must contain digits only</span>"
					},
					ORG_TYPE:{
						required:	"<span style='color:red;'>* Please select organization Type</span>",
		            },
		            OTHER_ORG:{
						required:	"<span style='color: red;'>* Please specify the other organization type</span>",
		            },
		            ORG_NAME:{
						required:	"<span style='color:red;'>* Please enter organization name</span>",
	               	},    
	               	USAGE:{
						required:	"<span style='color:red;'>* Please select your monthly usage</span>",
					},
					MESSAGE:{
						 required:	"<span style='color:red;'>* Please provide a message</span>",
					},
					VERIF_CODE:			"<span style='color:red;'>* Please enter the code shown in image</span>"
		    	},
	    		submitHandler: function(form) {
	    			$('#demoRequest').modal('hide');
	    			$(".modal1").show();
	    			$('#REQUESTFORM').ajaxSubmit(options);
	    		}
			});

			$("#form_for_feedback").validate({
	    		rules: {
	    			FEEDBACK_NAME: {
	            		required:true,
	       		 		minlength: 2
	        		},
	        		FEEDBACK_EMAIL: {
	            		required: true,
	            		email: true
	        		},
		           	FEEDBACK_MESSAGE:{
	                	required:true,
	             	},
	             	FEEDBACK_VERIF_CODE:"required"
	    		},
	    		messages: {
	    			FEEDBACK_NAME: {	
	    				required:	"<span style='color:red'>* Please enter your name</span>",
	    				minlength:	"<span style='color:red'>* Minimum length of name should be 2</span>"
	        		},
	        		FEEDBACK_EMAIL:{
						required:	"<span style='color:red'>* Email id is required</span>",
						email:		"<span style='color:red'>* Please enter a valid email address</span"
					},
					FEEDBACK_MESSAGE:{
						 required:	"<span style='color:red;'>* Please provide a message</span>",
					},
					FEEDBACK_VERIF_CODE:		"<span style='color:red;'>* Please enter the code shown in image</span>"
		    	},
	    		submitHandler: function(form) {
	    			$('#user_feedback').modal('hide');
	    			$(".modal1").show();
	    			$('#form_for_feedback').ajaxSubmit(options);
	    		}
			});
		});

	    function LaunchRequestedModal()
	    {
	    	$("#demo_response").hide();
			$("#demo_form_content").show();
			$("#demo_submit_btn").show();
			$("#REQUESTFORM").validate().resetForm();
			$('#captcha_img_demo').attr('src','core/index/lib/captcha/captcha.php?r=' + Math.random());
			$('#demoRequest').modal();
		}

	    function LaunchFeedbackdModal()
	    {
	    	$("#feedback_response").hide();
			$("#feedback_form_content").show();
			$("#feedback_submit_btn").show();
			$('#form_for_feedback').validate().resetForm();
			$('#captcha_img_feedback').attr('src','core/index/lib/captcha/captcha.php?r=' + Math.random());
			$('#user_feedback').modal();
		}

		angular.module('QuizUS').controller("actionButtonsController", ['$scope', function($scope) {
		    $scope.iItemsInCart = 0;
		    $scope.jsonCartItems = null;
		    $scope.product_name = "";
		    $scope.product_id = -1;
		    $scope.product_type = 0;
		    
		    $scope.OnAddToCart = function(product_name, product_id, product_type) {
		    	$(".modal1").show();

		    	$scope.product_name = product_name;
			    $scope.product_id = product_id;
			    $scope.product_type = product_type;
			    
				$.ajax({
					url: '<?php echo(CSiteConfig::ROOT_URL);?>/core/index/ajax/ajax_add_to_cart.php',
					type: 'POST',
					data: {'product_id' : product_id, 
						'product_type' : product_type},
					dataType: 'json',
					async: false,
					success: $scope.AddToCartSuccess,
					error: $scope.AddToCartError
				});
		    };
		    $scope.OnBuyNow = function(product_name, product_id, product_type) {
		    	$scope.OnAddToCart(product_name, product_id, product_type);

				window.location = "<?php echo(CSiteConfig::ROOT_URL);?>/checkout.php";
		    };
		    $scope.AddToCartSuccess = function(data) {
			    //alert(Object.keys(data).length);
				$scope.iItemsInCart = Object.keys(data).length - 1; // Remove status item
				$scope.jsonCartItems = data;

				/*$.each(data, function(key, value){
					alert($.param( value ));
				});*/
				$("#checkout_badge").text($scope.iItemsInCart);
				$(".modal1").hide();

				if(data['status'] == 0)
				{
					$.Notify({
						 caption: "<b>"+$scope.product_name+"</b> is added to the cart !",
						 content: "Your cart has total "+$scope.iItemsInCart+" items now !",
						 style: {background: 'green', color: '#fff'}, 
						 timeout: 5000
						 });
				}
				else
				{
					$.Notify({
						 caption: "<b>"+$scope.product_name+"</b> already exists in the cart !",
						 content: "Your cart has total "+$scope.iItemsInCart+" items !",
						 style: {background: 'green', color: '#fff'}, 
						 timeout: 1000
						 });
				}
			};
			$scope.AddToCartError = function (request, status, error) {
		        //alert(request.responseText);
		        $(".modal1").hide();
		    };
		}]);
	</script>
</body>
</html>
