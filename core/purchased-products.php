<!doctype html>
<?php
	include_once(dirname(__FILE__)."/../lib/session_manager.php");
	include_once(dirname(__FILE__)."/../database/mcat_db.php");
	include_once(dirname(__FILE__)."/../lib/include_js_css.php");
	include_once(dirname(__FILE__)."/../lib/site_config.php");
	include_once(dirname(__FILE__)."/../lib/billing.php");
	
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
	
	function PopulateCustomerBillingTBody()
	{
		foreach($GLOBALS['aryCustomerBilling'] as $billingEntry)
		{
			$aryProducts 	= json_decode($billingEntry['products_purchased']);
			$aryPaymentInfo	= json_decode($billingEntry['payment_info']);
			
			if(isset($aryProducts['tests']) && is_array($aryProducts['tests']))
			{
				foreach($aryProducts['tests'] as $aryTests)
				{
					printf("<tr>");
					printf("<td>%s</td>", $billingEntry['xaction_id']);
					printf("<td>%s</td>", $GLOBALS['objDB']->GetTestName($aryTests['id']));
					printf("<td>%s</td>", $billingEntry['timestamp']);
					printf("<td>%.2f</td>", $aryTests['amount_base']+$aryTests['taxes']);
					printf("<td>--</td>");
					printf("<td><a href='javascript;' onclick='ShowOverlay('http://localhost/QuizUS/test/test.php?test_id=%d&tschd_id=%d','st_x');' class='btn btn-info'>Start Test</a></td>", $aryTests['id'], $aryTests['scheduled_id']);
					printf("</tr>");
				}
			}
			
			if(isset($aryProducts['packages']) && is_array($aryProducts['packages']))
			{
				foreach($aryProducts['packages'] as $aryPkgs)
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
	.modal1 {
		display:    none;
		position:   fixed;
		z-index:    1000;
		top:        50%;
		left:       60%;
		height:     100%;
		width:      100%;
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
			include_once (dirname ( __FILE__ ) . "/../../lib/footer.php");
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
			$("#sidebar").show();
			$("#header").show();
			$("body").css("overflow", "auto");
		}
	</script>
</body>
</html>