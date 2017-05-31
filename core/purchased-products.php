<!doctype html>
<?php
	include_once(dirname(__FILE__)."/../lib/session_manager.php");
	include_once(dirname(__FILE__)."/../database/mcat_db.php");
	include_once(dirname(__FILE__)."/../lib/include_js_css.php");
	include_once(dirname(__FILE__)."/../lib/site_config.php");
	include_once(dirname(__FILE__)."/../lib/billing.php");
	include_once(dirname(__FILE__)."/../test/lib/tbl_result.php");
	
	// - - - - - - - - - - - - - - - - -
	// On Session Expire Load ROOT_URL
	// - - - - - - - - - - - - - - - - -
	CSessionManager::OnSessionExpire();
	// - - - - - - - - - - - - - - - - -
	
	$user_id = CSessionManager::Get(CSessionManager::STR_USER_ID);
	$time_zone = CSessionManager::Get(CSessionManager::FLOAT_TIME_ZONE);
	
	$objBilling = new CBilling();
	$aryCustomerBilling = $objBilling->GetFromCustomerBilling($user_id);
	
	$objDB = new CMcatDB();
	
	$objIncludeJsCSS = new IncludeJSCSS();
	
	$menu_id = CSiteConfig::UAMM_PURCHASED_PRODUCTS;
	
	$objResult = new CResult();
	function PopulateCustomerBillingTBody()
	{
		foreach($GLOBALS['aryCustomerBilling'] as $billingEntry)
		{
			$aryProducts 	= json_decode($billingEntry['products_purchased'],true);
			$aryPaymentInfo	= json_decode($billingEntry['payment_info'],true);
			
			if(isset($aryProducts['products']['tests']) && is_array($aryProducts['products']['tests']))
			{
				foreach($aryProducts['products']['tests'] as $aryTests)
				{
					if($GLOBALS['objResult']->IsResultAlreadyExist($GLOBALS['user_id'], $aryTests['id'], $aryTests['scheduled_id']) != TRUE)
					{
						printf("<tr>");
						printf("<td>%s</td>", $billingEntry['xaction_id']);
						printf("<td>%s</td>", $GLOBALS['objDB']->GetTestName($aryTests['id']));
						printf("<td>%s</td>", $billingEntry['timestamp']);
						printf("<td>%.2f</td>", $aryTests['amount_base']+$aryTests['taxes']);
						printf("<td>%s</td>", $aryPaymentInfo['payment_info']['transaction_id']);
						printf("<td><a onclick=\"ShowOverlay('%s/test/test.php?test_id=%d&tschd_id=%d','st_x');\" class='btn btn-info btn-sm'>Start Test</a></td>", CSiteConfig::ROOT_URL, $aryTests['id'], $aryTests['scheduled_id']);
						printf("</tr>");
					}
				}
			}
			
			if(isset($aryProducts['products']['packages']) && is_array($aryProducts['products']['packages']))
			{
				foreach($aryProducts['products']['packages'] as $aryPkgs)
				{
					/*
					 * Add code here once packages are launched
					 */
				}
			}
		}
	}
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="Generator" content="Mastishka Intellisys Private Limited">
<meta name="Author" content="Mastishka Intellisys Private Limited">
<meta name="Keywords" content="">
<meta name="Description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo(CConfig::SNC_SITE_NAME); ?>: Purchased Products</title>
<?php 
$objIncludeJsCSS->IncludeDatatablesBootstrapCSS("../");
$objIncludeJsCSS->IncludeDatatablesResponsiveCSS("../");
$objIncludeJsCSS->CommonIncludeCSS("../");
$objIncludeJsCSS->IncludeIconFontCSS("../");
$objIncludeJsCSS->IncludeMipcatCSS("../");
$objIncludeJsCSS->IncludeFuelUXCSS ( "../" );

$objIncludeJsCSS->CommonIncludeJS("../");
$objIncludeJsCSS->IncludeJqueryDatatablesMinJS("../");
$objIncludeJsCSS->IncludeDatatablesTabletoolsMinJS("../");
$objIncludeJsCSS->IncludeDatatablesBootstrapJS("../");
$objIncludeJsCSS->IncludeDatatablesResponsiveJS("../");
?>
<style type="text/css">
	.modal, .modal.fade.in {
	    top: 10%;
	}
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
</style>
</head>
<body>
	<div id="overlay" style="display: none">
		<iframe id="overlay_frame" src="#" width="100%" height="100%"></iframe>
	</div>
	<?php 
	include_once(dirname(__FILE__)."/../lib/header.php");
	?>

	<!-- --------------------------------------------------------------- -->
	<br />
	<br />
	<br />
	<div class='row-fluid'>
		<div class="col-sm-3 col-md-3 col-lg-3">
			<?php 
			include_once(dirname(__FILE__)."/../lib/sidebar.php");
			?>
		</div>
		<div class="col-sm-9 col-md-9 col-lg-9" style="border-left: 1px solid #ddd; border-top: 1px solid #ddd;">
			<div class="fuelux modal1">
				<div class="preloader"><i></i><i></i><i></i><i></i></div>
			</div>
			<br />
			<div id='TableToolsPlacement'>
			</div><br />
		    <div class="form-inline">
		        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		        	<thead>
						<tr>
							<th data-class="expand"><font color="#000000">Transaction ID</font></th>
							<th><font color="#000000">Test Name</font></th>
							<th data-hide="phone"><font color="#000000">Purchased On</font></th>
							<th data-hide="phone"><font color="#000000">Cost</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Payment Reference</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Attempt Test</font></th>
						</tr>
					</thead>
					<?php
						PopulateCustomerBillingTBody();
					?>
					<tfoot>
						<tr>
							<th data-class="expand"><font color="#000000">Transaction ID</font></th>
							<th><font color="#000000">Test Name</font></th>
							<th data-hide="phone"><font color="#000000">Purchased On</font></th>
							<th data-hide="phone"><font color="#000000">Cost</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Payment Reference</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Attempt Test</font></th>
						</tr>
					</tfoot>
		        </table>
		    </div><br /><br />
		    <?php
			include_once (dirname ( __FILE__ ) . "/../lib/footer.php");
			?>
		</div>
	</div>
	<script type="text/javascript">
		var row_count = 0;
		var selected_xaction = -1;
		$(document).ready(function () 
		{
			var table;
			var tableElement;
			var responsiveHelper = undefined;
			var breakpointDefinition = {
			        tablet: 1024,
			        phone : 480
			    };
		    
			$.fn.dataTable.TableTools.defaults.sSwfPath = "<?php $objIncludeJsCSS->IncludeDatatablesCopy_CSV_XLS_PDF("../");?>";
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
		            		selected_xaction = $(this).attr("id");
		                }
		            	else
		            	{
		            		row_count = 0;
			            }
		            } );
		        }
		    });
		});

		function ShowOverlay(url, div_id)
		{
			$("#sidebar").hide();
			$("#header").hide();
			$("#minimized_ckeditor_panel").removeClass( "minimized-shown" ).addClass( "minimized-hidden" );
			
			var current_date = new Date();
		    var time_zone = -current_date.getTimezoneOffset() / 60;
		    
			var height	  = $(window).height();
			$("#overlay_frame").attr("src",url+"&time_zone="+time_zone+"&height="+height).ready(function(){
				$("#overlay").show(800);
				$("body").css("overflow", "hidden");
			});
			
			//RemoveTest.div_id = div_id;
		}
		
		function HideOverlay()
		{
			$("#overlay").hide(500);
			$("#minimized_ckeditor_panel").removeClass( "minimized-hidden" ).addClass( "minimized-shown" );
			$("#sidebar").show();
			$("#header").show();
			$("body").css("overflow", "auto");
			window.location = window.location;
		}
	</script>
</body>
</html>