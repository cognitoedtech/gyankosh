<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
include_once ("../../lib/session_manager.php");
include_once ("../../database/mcat_db.php");
include_once (dirname ( __FILE__ ) . "/../../lib/include_js_css.php");
include_once (dirname ( __FILE__ ) . "/../../lib/site_config.php");
include_once (dirname ( __FILE__ ) . "/../../database/product_queries.php");

$objProductQueries = new CProductQuery ();

$aryCategories = $objProductQueries->GetProductCategories ();

function PopulateCategory() {
	foreach ( $GLOBALS ['aryCategories'] as $strCategory => $aryValues ) {
		if (count ( $aryValues ) > 0)
			printf ( "<option value='%s'>%s</option>", $strCategory, $strCategory );
	}
}

function PopulateSubCategory() {
	foreach ( $GLOBALS ['aryCategories'] as $strCategory => $aryValues ) {
		foreach ( $aryValues as $subCategory ) {
			printf ( "<option value='%s'>%s</option>", $subCategory, $subCategory );
		}
		break;
	}
}
// - - - - - - - - - - - - - - - - -
// On Session Expire Load ROOT_URL
// - - - - - - - - - - - - - - - - -
CSessionManager::OnSessionExpire ();
// - - - - - - - - - - - - - - - - -

$objDB = new CMcatDB ();

$user_id = CSessionManager::Get ( CSessionManager::STR_USER_ID );
$time_zone = CSessionManager::Get ( CSessionManager::FLOAT_TIME_ZONE );

$bKYCDone = $objDB->IsUserKYCDone ( $user_id );

$objIncludeJsCSS = new IncludeJSCSS ();

$menu_id = CSiteConfig::UAMM_DESIGN_MANAGE_TEST;
$page_id = CSiteConfig::UAP_MANAGE_TEST;
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="Generator" content="Mastishka Intellisys Private Limited">
<meta name="Author" content="Mastishka Intellisys Private Limited">
<meta name="Keywords" content="">
<meta name="Description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo(CConfig::SNC_SITE_NAME); ?>: Manage Test</title>
<?php
$objIncludeJsCSS->CommonIncludeCSS ( "../../" );
$objIncludeJsCSS->IncludeDatatablesBootstrapCSS ( "../../" );
$objIncludeJsCSS->IncludeDatatablesResponsiveCSS ( "../../" );
$objIncludeJsCSS->IncludeIconFontCSS ( "../../" );
$objIncludeJsCSS->IncludeMipcatCSS ( "../../" );
$objIncludeJsCSS->IncludeFuelUXCSS ( "../../" );

$objIncludeJsCSS->CommonIncludeJS ( "../../" );
$objIncludeJsCSS->IncludeMoneyJS ( "../../" );
$objIncludeJsCSS->IncludeJqueryDatatablesMinJS ( "../../" );
$objIncludeJsCSS->IncludeDatatablesTabletoolsMinJS ( "../../" );
$objIncludeJsCSS->IncludeDatatablesBootstrapJS ( "../../" );
$objIncludeJsCSS->IncludeDatatablesResponsiveJS ( "../../" );
$objIncludeJsCSS->IncludeJqueryFormJS ( "../../" );
$objIncludeJsCSS->IncludeJqueryValidateMinJS ( "../../", "1.16.0" );
$objIncludeJsCSS->IncludeTwitterBootstrapWizardJS ( "../../" );
$objIncludeJsCSS->IncludeZeroClipboardJS ( "../../" );
$objIncludeJsCSS->IncludeMetroNotificationJS ( CSiteConfig::ROOT_URL . "/" );
$objIncludeJsCSS->IncludeMetroDatepickerJS ( "../../" );
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

.modal,.modal.fade.in {
	top: 15%;
}

.js-responsive-table thead {
	font-weight: bold
}

.js-responsive-table td {
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-o-box-sizing: border-box;
	-ms-box-sizing: border-box;
	box-sizing: border-box;
	padding: 0px;
}

.js-responsive-table td span {
	display: none
}

@media all and (max-width:767px) {
	.js-responsive-table {
		width: 100%;
		max-width: 400px;
	}
	.js-responsive-table thead {
		display: none
	}
	.js-responsive-table td {
		width: 100%;
		display: block
	}
	.js-responsive-table td span {
		float: left;
		font-weight: bold;
		display: block
	}
	.js-responsive-table td span:after {
		content: ' : '
	}
	.js-responsive-table td {
		border: 0px;
		border-bottom: 1px solid #ddd
	}
	.js-responsive-table tr:last-child td:last-child {
		border: 0px
	}
}

.modal1 {
	display: none;
	position: fixed;
	z-index: 1000;
	top: 50%;
	left: 60%;
	height: 100%;
	width: 100%;
}

.wizard-tab-button {
	border-left: 1px solid #ddd;
	border-radius: 5px;
	";
}

.btn-file {
	position: relative;
	overflow: hidden;
}

.btn-file input[type=file] {
	position: absolute;
	top: 0;
	right: 0;
	min-width: 100%;
	min-height: 100%;
	font-size: 100px;
	text-align: right;
	filter: alpha(opacity =     0);
	opacity: 0;
	outline: none;
	background: white;
	cursor: inherit;
	display: block;
}

#img-upload {
	width: 100%;
}
</style>
</head>
<body>
	<div id="overlay" style="display: none">
		<iframe id="overlay_frame" src="#" width="100%" height="100%"></iframe>
	</div>
	<?php
	include_once (dirname ( __FILE__ ) . "/../../lib/header.php");
	?>

	<!-- --------------------------------------------------------------- -->
	<br />
	<br />
	<br />
	<div class='row-fluid'>
		<div class="col-sm-3 col-md-3 col-lg-3">
			<?php
			include_once (dirname ( __FILE__ ) . "/../../lib/sidebar.php");
			?>
		</div>
		<div class="col-sm-9 col-md-9 col-lg-9"
			style="border-left: 1px solid #ddd; border-top: 1px solid #ddd;">
			<div class="fuelux modal1">
				<div class="preloader">
					<i></i><i></i><i></i><i></i>
				</div>
			</div>
			<br />
			<div id='TableToolsPlacement'></div>
			<br />
			<div class="form-inline">
				<table id="example" class="table table-striped table-bordered"
					cellspacing="0" width="100%">
					<thead>
						<tr>
							<th data-class="expand"><font color="#000000">Test Name</font></th>
							<th data-hide="phone,tablet"><font color="#000000"># Questions</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Create Date</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Price</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Published On</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Will Unpublish
									On...</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Preview Test
									(free)</font></th>
							<th data-hide="phone,tablet"><font color="#000000">View Details</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Publish Test</font></th>
						</tr>
					</thead>
					<?php
					$objDB->PopulateTests ( $user_id, $time_zone );
					?>
					<tfoot>
						<tr>
							<th data-class="expand"><font color="#000000">Test Name</font></th>
							<th data-hide="phone,tablet"><font color="#000000"># Questions</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Create Date</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Price</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Published On</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Will Unpublish
									On...</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Preview Test
									(free)</font></th>
							<th data-hide="phone,tablet"><font color="#000000">View Details</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Publish Test</font></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="modal" id="test_details_modal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body" id="test_details_modal_body"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default"
								data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal" id="delete_test_modal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"
								aria-hidden="true">&times;</button>
							<h4 class="modal-title">Delete Test</h4>
						</div>
						<div class="modal-body" id="delete_test_modal_body"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default"
								data-dismiss="modal">Close</button>
							<button type="button" id="delete_btn" class="btn btn-primary"
								onclick="DeleteTest();">Delete</button>
						</div>
					</div>
				</div>
			</div>

			<div id="publish_test_box" class="modal">
				<div class="modal-dialog">
					<div class="modal-content">
						<form class='form-horizontal' id="publish_test"
							name="form_publish_test" onsubmit="return false;">
							<div class="modal-header">
								<button type="button" class="close" id="cancel"
									data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3 id="header_test_name"></h3>
							</div>
							<div class="modal-body" id="request_modal_body">
								<div id="publish_test_form_content">
									<div id="rootwizard">
										<div class="navbar">
											<div class="navbar-inner"
												style="border-bottom: 1px solid #eee; padding-bottom: 5px;">
												<div class="container">
													<ul>
														<li class="wizard-tab-button"><a href="#tab1"
															data-toggle="tab">Basic Information</a></li>
														<li class="wizard-tab-button"><a href="#tab2"
															data-toggle="tab">SEO Helper</a></li>
														<li class="wizard-tab-button"><a href="#tab3"
															data-toggle="tab">Product Essentials</a></li>
														<li class="wizard-tab-button"><a href="#tab4"
															data-toggle="tab">Launch Test</a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="tab-content">
											<div class="tab-pane" id="tab1">
												<div class="form-group">
													<label for="publish_keywords"
														class="col-lg-4 control-label">Keywords :</label>
													<div class="col-lg-6">
														<input class="form-control" id="publish_keywords"
															name="publish_keywords" type="text" />
													</div>
												</div>
												<div class="form-group">
													<label for="publish_test_desc"
														class="col-lg-4 control-label">Description :</label>
													<div class="col-lg-8">
														<textarea class="form-control" rows="2"
															id="publish_test_desc" name="publish_test_desc"></textarea>
													</div>
												</div>
												<div class="form-group">
													<label for="publish_test_category"
														class="col-lg-4 control-label">Category :</label>
													<div class="col-lg-8">
														<select class="form-control" id="publish_test_category"
															name="publish_test_category">
															<?php PopulateCategory();?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label for="publish_test_sub_category"
														class="col-lg-4 control-label">Sub-Category :</label>
													<div class="col-lg-8">
														<select class="form-control"
															id="publish_test_sub_category"
															name="publish_test_sub_category">
															<?php PopulateSubCategory();?>
														</select> <br /> <small style="color: maroon;"> If your
															choice of Category &#47; Sub-Category is not listed here
															then, <a style="cursor: pointer; cursor: hand;"
															onclick="OnAddCategory();">place an add request</a>. We
															will validate the request in next 24 hours and honor it
															if found legitimate.
														</small>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="tab2">
												<div class="form-group">
													<label for="suggested_reads" class="col-lg-4 control-label">Suggested
														Reads :</label>
													<div class="col-lg-8">
														<input class="form-control" id="suggested_reads"
															name="suggested_reads" type="text" />
													</div>
												</div>
												<div class="form-group">
													<label for="who_should_buy" class="col-lg-4 control-label">Who
														Should Buy :</label>
													<div class="col-lg-8">
														<textarea class="form-control" rows="2"
															id="who_should_buy" name="who_should_buy"></textarea>
													</div>
												</div>
												<div class="form-group">
													<label for="what_will_you_acheive"
														class="col-lg-4 control-label">What will user acheive :</label>
													<div class="col-lg-8">
														<textarea class="form-control" rows="2"
															id="what_will_you_acheive" name="what_will_you_acheive"></textarea>
														<input type="hidden" id="publish_test_id"
															name="pub_test_id">
													</div>
												</div>
											</div>
											<div class="tab-pane" id="tab3">
												<div class="form-group">
													<div class="col-lg-3 col-lg-offset-1">
														<label for="inr_cost" class="control-label">Cost of test :</label>
													</div>
													<div class="col-lg-2">
														<div class="checkbox">
															<label> <input type="checkbox" id="free_cost"
																onclick="OnFreeCheck(this);" checked /> Free <label>
														
														</div>
													</div>
													<div class="col-lg-3">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-inr"
																aria-hidden="true"></i></span> <input type="text"
																class="form-control" id="inr_cost" name="inr_cost"
																aria-describedby="basic-addon3" />
														</div>
													</div>
													<div class="col-lg-3">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-usd"
																aria-hidden="true"></i></span> <input type="text"
																class="form-control" id="usd_cost" name="usd_cost"
																aria-describedby="basic-addon3" />
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-lg-offset-4">
														<div class="col-lg-12 col-md-12 col-sm-12">
															<?php
															if (! $bKYCDone) {
																echo ("<b><i>You can't publish <span style='color:red;'>paid tests</span>.</i></b><br/><br/>Your account doesn't have <b><span style='color:red;'>K</span>now <span style='color:red;'>Y</span>our <span style='color:red;'>C</span>lient</b> check done, please fill <a href='../account/kyc-form.php'>this form</a> to sell paid tests at " . CConfig::SNC_SITE_NAME . ".");
															}
															?>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-lg-3 col-lg-offset-1">
														<label for="product_img" class="control-label">Upload
															Image :<br />(300px by 300px)
														</label>
													</div>
													<div class="col-lg-6">
														<div class="form-group">
															<div class="input-group">
																<input type="text" class="form-control" readonly> <span
																	class="input-group-btn"> <span
																	class="btn btn-default btn-file"> Browse <i
																		class="fa fa-file-image-o" aria-hidden="true"></i> <input
																		type="file" accept="image/gif, image/jpeg, image/png"
																		id="product_img" name="product_img">
																</span>
																</span>
															</div>
															<img id="img-upload" alt="" />
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="tab4">
												<div class="form-group">
													<div class="col-lg-3 col-lg-offset-1">
														<label for="schedule_start" class="control-label">Launch
															Date :</label>
													</div>
													<div class="col-lg-3">
														<div class="checkbox">
															<label> <input type="checkbox"
																onclick="OnStartDateCheck(this);"
																id="schedule_start_check" /> Launch now! <label>
														
														</div>
													</div>
													<div class="col-lg-4">
														<div class="metro">
															<div class="input-control text" id="datepicker1">
																<input id="schedule_start" name="schedule_start"
																	type="text">
																<button class="btn-date" onclick="return false;"></button>
															</div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-lg-3 col-lg-offset-1">
														<label for="schedule_start" class="control-label">Unpublish
															On :</label>
													</div>
													<div class="col-lg-3">
														<div class="checkbox">
															<label> <input type="checkbox"
																onclick="OnEndDateCheck(this);" id="schedule_end_check" />
																Never! <label>
														
														</div>
													</div>
													<div class="col-lg-4">
														<div class="metro">
															<div class="input-control text" id="datepicker2">
																<input id="schedule_end" name="schedule_end" type="text">
																<button class="btn-date" onclick="return false;"></button>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div id="error_callback"></div>
											<ul class="pager wizard">
												<li class="previous"><a href="#">Previous</a></li>
												<li class="next"><a href="#">Next</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-default" id="cancel1"
									data-dismiss="modal" aria-hidden="true">Close</button>
								<button type="submit" class="btn btn-primary" id="btn_publish">Publish</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div id="add_category_box" class="modal">
				<div class="modal-dialog">
					<div class="modal-content">
						<form class='form-horizontal' id="form_add_category"
							name="form_add_category" onsubmit="return false;">
							<div class="modal-header">
								<button type="button" class="close" id="add_category_cancel"
									data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Submit Add Category Request</h3>
							</div>
							<div class="modal-body" id="request_modal_body">
								<div class="form-group">
									<label for="submit_category" class="col-lg-4 control-label">Category
										:</label>
									<div class="col-lg-6">
										<input class="form-control" id="submit_category"
											name="category" type="text" />
									</div>
								</div>
								<div class="form-group">
									<label for="submit_sub_category" class="col-lg-4 control-label">Sub-Category
										:</label>
									<div class="col-lg-6">
										<input class="form-control" id="submit_sub_category"
											name="sub_category" type="text" />
									</div>
								</div>
								<div id="category_error_callback"></div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-default" id="cancel2"
									data-dismiss="modal" aria-hidden="true">Close</button>
								<button type="submit" class="btn btn-primary" id="btn_publish">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php
			include_once (dirname ( __FILE__ ) . "/../../lib/footer.php");
			?>
		</div>
	</div>
	<script type="text/javascript">
		var row_count = 0;
		var delete_test_id;
		var table;
		$(document).ready(function () {
			'use strict';
	
			var table;
			var tableElement;
			var responsiveHelper = undefined;
			var breakpointDefinition = {
			        tablet: 1024,
			        phone : 480
			    };

			TableTools.BUTTONS.custom_button = $.extend( true, TableTools.buttonBase, {
				"sNewLine": "<br>",
				"sButtonText": "Delete",
				"fnClick": function() {
					if(row_count != 0)
					{
						$("#delete_test_modal_body").html("Do you want to delete selected test?");
						$("#delete_btn").show();
						$("#delete_test_modal").modal("show");
					}
					else
					{
						$("#delete_test_modal_body").html("Please select the test to delete.");
						$("#delete_btn").hide();
						$("#delete_test_modal").modal("show");
					}
				}
			} );
			
			$.fn.dataTable.TableTools.defaults.sSwfPath = "<?php $objIncludeJsCSS->IncludeDatatablesCopy_CSV_XLS_PDF("../../");?>";
			    tableElement = $('#example');
			    table = tableElement.dataTable({
			    	"sDom": 'T<"clear">lfrtip<"clear spacer">T',
			    	"bPaginate": true,
			    	"bFilter": true,
			    	"oTableTools": {
			    		"sRowSelect": "single",
			            "aButtons": [
				            {
							    "sExtends": "csv",
							    "mColumns": [ 0, 1, 2, 3, 4, 5 ]
							},
							{
							    "sExtends": "pdf",
							    "mColumns": [ 0, 1, 2, 3, 4, 5 ]
							},
				            {
								"sExtends":    "custom_button",
								"sButtonText": "Delete",
							}
			            ]
			        },
			        autoWidth      : false,
			        //ajax           : './arrays.txt',
			        preDrawCallback: function () {
			            // Initialize the responsive datatables helper once.
			            if (!responsiveHelper) {
			                responsiveHelper = new ResponsiveDatatablesHelper(tableElement, breakpointDefinition);
			            }
			            var oTableTools = TableTools.fnGetInstance( 'example' );
			            $('#TableToolsPlacement').before( oTableTools.dom.container );
			        },
			        rowCallback    : function (nRow) {
			            responsiveHelper.createExpandIcon(nRow);
			        },
			        drawCallback   : function (oSettings) {
				        //alert("hello");
			            responsiveHelper.respond();
			            $('#example tbody').on( 'click', 'tr', function () {
			            	if( $(this).hasClass('active') ) {
			            		row_count = 1;
			            		delete_test_id = $(this).attr("id");
			                }
			            	else
			            	{
			            		row_count = 0;
				            }
			            } );
			        }
			    });

			    var image_width, image_height, image_size;
			    jQuery.validator.addMethod("ValidateKeyword", function(value, element) {
					if(/^,.*,$/.test(value) || value.trim() == "," || /^.*,$/.test(value) || /^,.*/.test(value))
					{
		    			return false;
					}
					else
					{
		    			return true;
					}
				}, "<span style='color:red;'>* Comma is not allowed in starting and ending!</style>");

			    jQuery.validator.addMethod("ValidateImageExt", function(value, element) {
					if(!value.trim())
						return true;
					
			    	var extension = value.replace(/^.*\./, '');
			    	var aryImage = ["jpg","jpeg","png","gif"];

					var retVal = false;
			    	$.each(aryImage, function (index,value) {
			    	    if(extension == value)
			    	    {
				    	    retVal = true;
			    	    }
			    	});

			    	return retVal;
				}, "<span style='color:red;'>* Supported image extensions are only jpg / jpeg / png / gif");

			    jQuery.validator.addMethod("ValidateImageDim", function(value, element) {
			    	if(!value.trim())
						return true;
					
			    	var retVal = true;

			    	if(image_width != 300 || image_height != 300)
				    	retVal = false;
			    	
			    	return retVal;
				}, "<span style='color:red;'>* Supported image dimensions are 300 by 300 pixels");

			    $("#publish_test").validate({
					errorPlacement: function(error, element) {
						$('#error_callback').append(error);
					},
	        		rules: {
	        			publish_keywords: {
	                		required:true,
	           		 		'ValidateKeyword':true
	            		},
	            		publish_test_desc: {
	                		required:true,
	                		maxlength: 160
	                	},
	                	suggested_reads: {
	                		required:true,
	                		maxlength: 160
	                	},
	                	who_should_buy: {
	                		required:true,
	                		maxlength: 160
	                	},
	                	what_will_you_acheive: {
	                		required:true,
	                		maxlength: 160
	                	},
	                	inr_cost: {
	                		required:true,
	                		maxlength: 160
	                	},
	                	usd_cost: {
	                		required:true,
	                		maxlength: 160
	                	},
	                	product_img: {
	                		'ValidateImageExt':true,
	                		'ValidateImageDim':true
	                	},
	                	schedule_start: {
	                		required:true
	                	},
	                	schedule_end: {
	                		required:true
	                	}
	        		},
	        		messages: {
	        			publish_keywords: {	
	        				required:	"<div style='color:red'>* Please enter keywords</div>",
	            		},
	            		publish_test_desc:{
	        				required:	"<div style='color:red'>* Please provide test description</div>",
	        				maxlength:	"<div style='color:red'>* Maximum letters for description should be 160</div>"
	    				},
	    				suggested_reads:{
	    					required:	"<div style='color:red'>* Please provide suggessted reads for this test</div>",
		    			},
		    			who_should_buy:{
		    				required:	"<div style='color:red'>* Please provide suggesstions about who should buy this test</div>",
		    			},
		    			what_will_you_acheive:{
		    				required:	"<div style='color:red'>* Please provide what will user acheive from this test</div>",
		    			},
		    			inr_cost:{
		    				required:	"<div style='color:red'>* Please provide cost of this test in Indian Rupees</div>",
		    			},
		    			usd_cost:{
		    				required:	"<div style='color:red'>* Please provide cost of this test in US Dollars</div>",
		    			},
		    			product_img:{
		    				required:	"<div style='color:red'>* Please provide image for the test to display</div>",
		    			},
		    			schedule_start:{
		    				required:	"<div style='color:red'>* Please provide launch date for the test</div>",
		    			},
		    			schedule_end:{
		    				required:	"<div style='color:red'>* Please provide test expiry/unpublish date</div>",
		    			}
	    	    	},
	    	    	submitHandler: function(form) {
	    				//$('#publish_test_box').modal('modal');
	    	    		$(".modal1").show();
	    				$('#publish_test').ajaxSubmit({success:showResponse, url: 'ajax/ajax_publish_test.php', type:'POST', data: {publish : '1'},clearForm: true});
	    				$("#"+check_box_id).attr("made_publish", "1");
	    				
	    				var test_id = $("#"+check_box_id).attr('test_id');
	    				$("#"+test_id+"_keywords").html($("#publish_keywords").val());
	    				$("#"+test_id+"_description").html($("#publish_test_desc").val());
	    				$("#"+test_id+"_suggested_reads").html($("#suggested_reads").val());
	    				$("#"+test_id+"_who_should_buy").html($("#who_should_buy").val());
	    				$("#"+test_id+"_what_will_you_acheive").html($("#what_will_you_acheive").val());
	    				$("#"+test_id+"_inr_cost").html($("#inr_cost").val());
	    				$("#"+test_id+"_usd_cost").html($("#usd_cost").val());
	    				$("#"+test_id+"_schedule_start").html($("#schedule_start").val());
	    				if($("#schedule_end").val())
	    					$("#"+test_id+"_schedule_end").html($("#schedule_end").val());
	    				else
	    				{
	    					$("#"+test_id+"_schedule_end").html("Never");
	    					$("#"+test_id+"_schedule_end").text("<?php echo(CConfig::CONST_NEVER);?>>");
	    				}
	    				$("#"+test_id+"_copy").show();
	    				$("#"+test_id+"_edit").show();
	    				$('#publish_test_box').modal('hide');
	    			}
	    		});
				
			    $("#form_add_category").validate({
					errorPlacement: function(error, element) {
						$('#category_error_callback').append(error);
					},
	        		rules: {
	        			category: {
	                		required:true,
	                		maxlength: 250
	            		},
	            		sub_category: {
	                		required:true,
	                		maxlength: 250
	                	}
	        		},
	        		messages: {
	        			category:{
	        				required:	"<div style='color:red'>* Please enter category</div>",
	        				maxlength:	"<div style='color:red'>* Maximum letters for category should be 250</div>"
	    				},
	    				sub_category:{
	    					required:	"<div style='color:red'>* Please enter sub-category</div>",
	    					maxlength:	"<div style='color:red'>* Maximum letters for category should be 250</div>"
		    			}
	    	    	},
	    	    	submitHandler: function(form) {
		    	    	$(".modal1").show();
	    				$('#form_add_category').ajaxSubmit({success:addCategorySuccess,
		    					url: 'ajax/ajax_add_category_request.php', 
		    					type:'POST', data: {user_id : '<?php echo($user_id);?>'}, clearForm: true});
	    				$('#add_category_box').modal('hide');
	    			}
	    		});

	    		function addCategorySuccess(data)
	    		{
		    		$(".modal1").hide();

    				$.Notify({
						 caption: "Add Category Request Success",
						 content: "We have received your request for adding new category and sub-category!",
						 style: {background: 'green', color: '#fff'}, 
						 timeout: 5000
						 });
	    		}

				$(document).ready(function() {  	
					$('#rootwizard').bootstrapWizard({withVisible:false, onNext:OnNextStep, 
						onTabClick:OnNextStep, onTabShow:OnTabShow});
					});

				// ------------------------
				// [ Start Money.js ]
				// ------------------------
				var GetLatestCurrencyRates = function(data) {
					  fx.rates = data.rates;
					}

				$.getJSON("http://api.fixer.io/latest", GetLatestCurrencyRates);
				// ------------------------
				// [ End Money.js ]
				// ------------------------

				// ------------------------
				// [ Product Image ]
				// ------------------------
				$(document).on('change', '.btn-file :file', function() {
					var input = $(this),
						label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
					input.trigger('fileselect', [label]);
					});

				$('.btn-file :file').on('fileselect', function(event, label) {
				    
				    var input = $(this).parents('.input-group').find(':text'),
				        log = label;
				    
				    if( input.length ) {
				        input.val(log);
				    } else {
				        //if( log ) alert(log);
				    }

				    readURL(this);

				    var file, img;
				    if ((file = this.files[0])) {
					    img = new Image();
				        img.onload = function () {
				        	//this will give you image width and height and you can easily validate here....
				        	image_width = img.width;
				        	image_height = img.height;
				        };
				        img.src = URL.createObjectURL(file);
				        image_size	 = file.size;
				    }
				});
				function readURL(input) {
				    if (input.files && input.files[0]) {
				        var reader = new FileReader();
				        
				        reader.onload = function (e) {
				            $('#img-upload').attr('src', e.target.result);
				        }
				        
				        reader.readAsDataURL(input.files[0]);
				    }
				}
				
				jQuery.validator.addMethod("logo_image_dim", function(val, elem) {

					if(image_width == 300 && image_height == 400)
					{
						return true;
					}
					return false;
			    }, 'Image dimensions are not proper!');

				jQuery.validator.addMethod("logo_image_size", function(val, elem) {
					if(image_size > 1048576)
					{
						return false;
					}
					return true;
			    }, 'Image file should not exceed 1MB size limit!');
				// ------------------------
				// [ Product Image ]
				// ------------------------

				// ------------------------
				// [ On Category Change ]
				// ------------------------
				$('#publish_test_category').on('change', function() {
					<?php echo "var jsonCategories = ". json_encode($aryCategories) . ";\n";?>

					$('#publish_test_sub_category').html("");
					$.each( jsonCategories[this.value], function( key, value ) {
						$('#publish_test_sub_category').append("<option value='"+value+"'>"+value+"</option>");
						$('#publish_test_sub_category').attr("disabled", false);
					});

					if( jsonCategories[this.value].length <=0 ) {
						$('#publish_test_sub_category').attr("disabled", true);
					}
					//alert( this.value );
				});
		});

		function OnTabShow()
		{
			var retVal = true;
			var curIndex = $('#rootwizard').bootstrapWizard('currentIndex');
			
			if(curIndex == 3)
				$("#btn_publish").prop("disabled", false);
			else
				$("#btn_publish").prop("disabled", true);

			return retVal;
		}

		function OnNextStep()
		{
			var retVal = true;

			var curIndex = $('#rootwizard').bootstrapWizard('currentIndex');

			switch(curIndex)
			{
				case 0:
					retVal = retVal && $("#publish_test").validate().element("#publish_keywords");
					retVal = retVal && $("#publish_test").validate().element("#publish_test_desc");
					break;
				case 1:
					retVal = retVal && $("#publish_test").validate().element("#suggested_reads");
					retVal = retVal && $("#publish_test").validate().element("#who_should_buy");
					retVal = retVal && $("#publish_test").validate().element("#what_will_you_acheive");
					break;
				case 2:
					retVal = retVal && $("#publish_test").validate().element("#inr_cost");
					retVal = retVal && $("#publish_test").validate().element("#usd_cost");
					retVal = retVal && $("#publish_test").validate().element("#product_img");
					break;
				case 3:
					retVal = retVal && $("#publish_test").validate().element("#schedule_start");
					retVal = retVal && $("#publish_test").validate().element("#schedule_end");
					
					if(retVal)
						$("#btn_publish").prop("disabled", false);
					break;
			}

			return retVal;
		}

		function DeleteTest()
		{
			$(".modal1").show();
			
			$("#delete_test_modal").modal("hide");
			$.post("ajax/ajax_delete_test.php",{"action": "remove", "data": [delete_test_id]},function(){
				$("#example").dataTable().api().rows( ".active" )
		        .remove()
		        .draw();

				$(".modal1").hide();
			});
		}

		function OnTestDetails(test_id)
		{
			$(".modal1").show();
			
			$("#test_details_modal_body").load("../ajax/ajax_test_details.php?test_id="+test_id, function(){
				$("#test_details_modal").modal("show"); 
				$(".modal1").hide();
			});
		}

		function ShowOverlay(url, div_id)
		{
			$("#sidebar").hide();
			$("#header").hide();
			
			var current_date = new Date();
		    var time_zone = -current_date.getTimezoneOffset() / 60;
		    
			var height	  = $(window).height();
			$("#overlay_frame").attr("src",url+"&time_zone="+time_zone+"&height="+height).ready(function(){
				$("#overlay").show(800);
				$("body").css("overflow", "hidden");
			});
			
			RemoveTest.div_id = div_id;
		}
		
		function HideOverlay()
		{
			$("#overlay").hide(500);
			$("#sidebar").show();
			$("#header").show();
			$("body").css("overflow", "auto");
		}
		
		function RemoveTest()
		{
			console.log("Test Removed");
		}

		function showResponse(responseText, statusText, xhr, form)
		{
			var values = {};
			$.each(form.serializeArray(), function(i, field) {
			    values[field.name] = field.value;
			});

			var test_id = values["pub_test_id"];

			$("#"+test_id+"_row_start_date").text($("#"+test_id+"_schedule_start").text());
			$("#"+test_id+"_row_end_date").text($("#"+test_id+"_schedule_end").text());
			//alert($("#"+test_id+"_schedule_start").text() +" to "+$("#"+test_id+"_schedule_end").text())
			$(".modal1").hide();
		}

		var check_box_id = "";
		function OnPublish(obj)
		{
			if ($(obj).is(':checked',true)){
				var test_id = $(obj).attr('test_id');
				$("#publish_test").validate().resetForm();
				$("#publish_test_id").val($(obj).attr('test_id')+'');
				$("#header_test_name").text('Publish "'+$(obj).attr('test_name')+'"');
				$("#publish_keywords").val($("#"+test_id+"_keywords").html()+'');
				$("#publish_test_desc").val($("#"+test_id+"_description").html()+'');
				$("#suggested_reads").val($("#"+test_id+"_suggested_reads").html()+'');
				$("#who_should_buy").val($("#"+test_id+"_who_should_buy").html()+'');
				$("#what_will_you_acheive").val($("#"+test_id+"_what_will_you_acheive").html()+'');

				var inr_cost = $("#"+test_id+"_inr_cost").text();
				var usd_cost = $("#"+test_id+"_usd_cost").text();
				$("#inr_cost").val(inr_cost);
				$("#usd_cost").val(usd_cost);

				if(inr_cost <= 0 && usd_cost <= 0)
				{
					$("#free_cost").prop("checked", true);
					$("#inr_cost").val(0);
					$("#usd_cost").val(0);
					$("#inr_cost").prop('disabled', true);
					$("#usd_cost").prop('disabled', true);
				}
				else
				{
					$("#free_cost").prop("checked", false);
					$("#inr_cost").prop('disabled', false);
					$("#usd_cost").prop('disabled', false);
				}

				try{
					$("#datepicker1").datepicker("destroy");
				}catch(e){}

				var objDate = new Date();
				$("#schedule_start_check").prop("checked", true);
				
				var valDate = $("#"+test_id+"_schedule_start").text();
				if(valDate != <?php echo(CConfig::CONST_NOT_APPLICABLE); ?>)
				{
					objDate = new Date(valDate);
					$("#schedule_start_check").prop("checked", false);
					$("#datepicker1").css("pointer-events","auto");
					$("#schedule_start").css("background-color","#fff");
				}
				else
				{
					$("#datepicker1").css("pointer-events","none");
					$("#schedule_start").css("background-color","#ddd");
				}
				$("#datepicker1").datepicker({
					format: "dd mmmm, yyyy",
					date : objDate
				});
				
				try{
					$("#datepicker2").datepicker("destroy");
				}catch(e){}

				objDate = undefined;
				//objDate.setFullYear(objDate.getFullYear() + 1);
				$("#schedule_end_check").prop("checked", false);
				
				valDate = $("#"+test_id+"_schedule_end").text();
				if(valDate == <?php echo(CConfig::CONST_NOT_APPLICABLE); ?> || valDate == <?php echo(CConfig::CONST_NEVER); ?>)
				{
					$("#schedule_end_check").prop("checked", true);
					$("#datepicker2").css("pointer-events","none");
					$("#schedule_end").css("background-color","#ddd");
				}
				else
				{
					objDate = new Date(valDate);
				}
				$("#datepicker2").datepicker({
					format: "dd mmmm, yyyy",
					date : objDate
				});

				$("#btn_publish").prop("disabled", true);
				$('#rootwizard a:first').tab('show');
				$('#publish_test_box').modal('show');
			}
			else{

					$("#publish_test_id").val($(obj).attr('test_id')+'');
					var test_id= $("#publish_test_id").val();

					$(".modal1").show();
					$.post("ajax/ajax_publish_test.php",{'unpublish':0,'test_id':test_id},function(data){
						$(".modal1").hide();
						$("#"+test_id+"_row_start_date").text("Test is not live");
	    				$("#"+test_id+"_row_end_date").text("Not Applicable");
						$("#"+check_box_id).attr("made_publish", "0");
						$("#"+test_id+"_copy").hide();
						$("#"+test_id+"_edit").hide();
					});
				}
			check_box_id = $(obj).attr("id");
		}

		$('#publish_test_box').on('hidden.bs.modal', function () {
			 if($("#"+check_box_id).attr("made_publish") == "0")
			 {
			 	$("#"+check_box_id).prop("checked", false);
			 }
			 check_box_id ="";
		});

		$(".btn-success").each(function(){
			if($(this).attr("id").slice(-4)== "edit")
				return;
			
			var test_name = $(this).attr("test_name");
			var client = new ZeroClipboard( document.getElementById($(this).attr("id")) );
	
			client.on( "ready", function( readyEvent ) {
			  // alert( "ZeroClipboard SWF is ready!" );
	
			  client.on( "aftercopy", function( event ) {
				  $.Notify({
						 caption: "Test Link Copied",
						 content: "<b>"+test_name+"</b> URL <b>"+event.data["text/plain"]+"</b> is copied to clipboard!",
						 style: {background: 'green', color: '#fff'}, 
						 timeout: 5000
						 });
			  } );
			} );
			
		});

		$("#inr_cost").keyup(function(){
				var usd_cost = fx($("#inr_cost").val()).from("INR").to("USD");
				usd_cost = Math.round(usd_cost*100)/100 || 0; 
				$("#usd_cost").val(usd_cost);
			});

		function OnFreeCheck(obj)
		{
			var kyc = <?php echo($bKYCDone);?>;
			if(!kyc)
			{
				$(obj).prop("checked", true);
			}
			
			if ($(obj).is(':checked',true))
			{
				$("#inr_cost").val(0);
				$("#usd_cost").val(0);
				$("#inr_cost").prop('disabled', true);
				$("#usd_cost").prop('disabled', true);
			}
			else
			{
				$("#inr_cost").prop('disabled', false);
				$("#usd_cost").prop('disabled', false);
			}
		}

		function OnStartDateCheck(obj)
		{
			var test_id = $("#publish_test_id").val();
			var schedule_start = $("#"+test_id+"_schedule_start").text();
			var date;
			if(schedule_start == -1)
			{
				date = new Date();
			}
			else
			{
				date = new Date(schedule_start);
			}
			var sMonths = ["Jan","Feb","Mar","Apr","May","Jun",
							"Jul","Aug","Sep","Oct","Nov","Dec"];
			
			$("#schedule_start").val(date.getDate()+" "+sMonths[date.getMonth()]+", "+date.getFullYear());

			if ($(obj).is(':checked',true))
			{
				$("#datepicker1").css("pointer-events","none");
				$("#schedule_start").css("background-color","#ddd");
			}
			else
			{
				$("#datepicker1").datepicker("destroy");

				$("#datepicker1").datepicker({
					format: "dd mmmm, yyyy",
					date : date
				});
				
				$("#datepicker1").css("pointer-events","auto");
				$("#schedule_start").css("background-color","#fff");
			}
		}

		function OnEndDateCheck(obj)
		{
			var test_id = $("#publish_test_id").val();
			var schedule_end = $("#"+test_id+"_schedule_end").text();
			var date;
			if(schedule_end == -1 || schedule_end == 0)
			{
				date = new Date();
				date.setFullYear(date.getFullYear() + 1);
			}
			else
			{
				date = new Date(schedule_end);
			}
			var sMonths = ["Jan","Feb","Mar","Apr","May","Jun",
							"Jul","Aug","Sep","Oct","Nov","Dec"];
			
			if ($(obj).is(':checked',true))
			{
				$("#schedule_end").val(undefined);
				
				$("#datepicker2").css("pointer-events","none");
				$("#schedule_end").css("background-color","#ddd");
			}
			else
			{
				$("#schedule_end").val(date.getDate()+" "+sMonths[date.getMonth()]+", "+date.getFullYear());
				$("#datepicker2").datepicker("destroy");

				$("#datepicker2").datepicker({
					format: "dd mmmm, yyyy",
					date : date
				});
				
				$("#datepicker2").css("pointer-events","auto");
				$("#schedule_end").css("background-color","#fff");
			}
		}

		function OnEditTest(obj)
		{
			var test_id = $(obj).attr('test_id');

			$("#publish_test").validate().resetForm();
			$("#publish_test_id").val($(obj).attr('test_id')+'');
			$("#publish_test_category").val($("#"+test_id+"_test_category").text()).change();
			$("#publish_test_sub_category").val($("#"+test_id+"_test_sub_category").text()).change();
			$("#header_test_name").text('Publish "'+$(obj).attr('test_name')+'"');
			$("#publish_keywords").val($("#"+test_id+"_keywords").html()+'');
			$("#publish_test_desc").val($("#"+test_id+"_description").html()+'');
			$("#suggested_reads").val($("#"+test_id+"_suggested_reads").html()+'');
			$("#who_should_buy").val($("#"+test_id+"_who_should_buy").html()+'');
			$("#what_will_you_acheive").val($("#"+test_id+"_what_will_you_acheive").html()+'');

			var inr_cost = $("#"+test_id+"_inr_cost").text();
			var usd_cost = $("#"+test_id+"_usd_cost").text();
			$("#inr_cost").val(inr_cost);
			$("#usd_cost").val(usd_cost);

			if(inr_cost <= 0 && usd_cost <= 0)
			{
				$("#free_cost").prop("checked", true);
				$("#inr_cost").val(0);
				$("#usd_cost").val(0);
				$("#inr_cost").prop('disabled', true);
				$("#usd_cost").prop('disabled', true);
			}
			else
			{
				$("#free_cost").prop("checked", false);
				$("#inr_cost").prop('disabled', false);
				$("#usd_cost").prop('disabled', false);
			}

			$('#img-upload').attr('src', $("#"+test_id+"_product_image").text());

			var sMonths = ["Jan","Feb","Mar","Apr","May","Jun",
							"Jul","Aug","Sep","Oct","Nov","Dec"];

			try{
				$("#datepicker1").datepicker("destroy");
			}catch(e){}

			var objDate = new Date();
			$("#schedule_start_check").prop("checked", true);
			
			var valDate = $("#"+test_id+"_schedule_start").text();
			if(valDate != <?php echo(CConfig::CONST_NOT_APPLICABLE); ?>)
			{
				objDate = new Date(valDate);
				$("#schedule_start_check").prop("checked", false);
				$("#datepicker1").css("pointer-events","auto");
				$("#schedule_start").css("background-color","#fff");
			}
			else
			{
				$("#datepicker1").css("pointer-events","none");
				$("#schedule_start").css("background-color","#ddd");
			}
			$("#datepicker1").datepicker({
				format: "dd mmmm, yyyy",
				date : objDate
			});
			$("#schedule_start").val(objDate.getDate()+" "+sMonths[objDate.getMonth()]+", "+objDate.getFullYear());
			
			try{
				$("#datepicker2").datepicker("destroy");
			}catch(e){}

			objDate = undefined;
			//objDate.setFullYear(objDate.getFullYear() + 1);
			$("#schedule_end_check").prop("checked", false);
			
			valDate = $("#"+test_id+"_schedule_end").text();
			if(valDate == <?php echo(CConfig::CONST_NOT_APPLICABLE); ?> || valDate == <?php echo(CConfig::CONST_NEVER); ?>)
			{
				$("#schedule_end_check").prop("checked", true);
				$("#datepicker2").css("pointer-events","none");
				$("#schedule_end").css("background-color","#ddd");
			}
			else
			{
				objDate = new Date(valDate);
			}
			$("#datepicker2").datepicker({
				format: "dd mmmm, yyyy",
				date : objDate
			});
			if(objDate)
				$("#schedule_end").val(objDate.getDate()+" "+sMonths[objDate.getMonth()]+", "+objDate.getFullYear());

			$("#btn_publish").prop("disabled", true);
			$('#rootwizard a:first').tab('show');
			$('#publish_test_box').modal('show');

			check_box_id = test_id+"_checkbox";
		}

		function OnAddCategory()
		{
			$('#add_category_box').modal('show');
		}
	</script>
</body>
</html>