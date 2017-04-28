<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
include_once (dirname ( __FILE__ ) . "/../../lib/session_manager.php");
include_once (dirname ( __FILE__ ) . "/../../database/mcat_db.php");
include_once (dirname ( __FILE__ ) . "/../../lib/billing.php");
include_once (dirname ( __FILE__ ) . "/../../lib/include_js_css.php");
include_once (dirname ( __FILE__ ) . "/../../lib/site_config.php");

// - - - - - - - - - - - - - - - - -
// On Session Expire Load ROOT_URL
// - - - - - - - - - - - - - - - - -
CSessionManager::OnSessionExpire ();
// - - - - - - - - - - - - - - - - -

$objDB = new CMcatDB ();
$objBilling = new CBilling ();

$user_id = CSessionManager::Get ( CSessionManager::STR_USER_ID );

$currencyPrefix = NULL;
$currency = $objBilling->GetCurrencyType ( $user_id );

$currencyPrefix = ($currency == "USD") ? '$' : 'Rs.';

$user_type = CSessionManager::Get ( CSessionManager::INT_USER_TYPE );
$time_zone = CSessionManager::Get ( CSessionManager::FLOAT_TIME_ZONE );

$objIncludeJsCSS = new IncludeJSCSS ();

$menu_id = CSiteConfig::UAMM_MY_ACCOUNT;
$page_id = CSiteConfig::UAP_BILLING_INFORMATION;

$plan_type = CSessionManager::Get ( CSessionManager::INT_APPLIED_PLAN );

$plan_ary = array (CConfig::SPT_BASIC => "Basic SaaS", CConfig::SPT_PROFESSIONAL => "Professional SaaS", CConfig::SPT_ENTERPRISE => "Enterprise SaaS" );
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="Generator" content="Mastishka Intellisys Private Limited">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo(CConfig::SNC_SITE_NAME);?>: Account Billing</title>
<?php
$objIncludeJsCSS->IncludeDatatablesBootstrapCSS ( "../../" );
$objIncludeJsCSS->IncludeDatatablesResponsiveCSS ( "../../" );
$objIncludeJsCSS->CommonIncludeCSS ( "../../" );
$objIncludeJsCSS->IncludeIconFontCSS ( "../../" );
$objIncludeJsCSS->CommonIncludeJS ( "../../" );
$objIncludeJsCSS->IncludeJqueryDatatablesMinJS ( "../../" );
$objIncludeJsCSS->IncludeDatatablesTabletoolsMinJS ( "../../" );
$objIncludeJsCSS->IncludeDatatablesBootstrapJS ( "../../" );
$objIncludeJsCSS->IncludeDatatablesResponsiveJS ( "../../" );
?>
<style type="text/css">
.js-responsive-table {
	margin: 50px auto
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
	padding: 20px;
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
		border-bottom: 1px solid #ff0000
	}
	.js-responsive-table tr:last-child td:last-child {
		border: 0px
	}
}
</style>
</head>
<body>

	<?php
	include_once (dirname ( __FILE__ ) . "/../../lib/header.php");
	?>

	<!-- --------------------------------------------------------------- -->
	<br />
	<br />
	<br />
	<div class='row-fluid'>
		<div class="col-lg-3 col-md-3 col-sm-3">
			<?php
			include_once (dirname ( __FILE__ ) . "/../../lib/sidebar.php");
			?>
		</div>
		<div class=" col-lg-9 col-sm-9 col-md-9"
			style="border-left: 1px solid #ddd; border-top: 1px solid #ddd;">
			<br />
			<h3 style="color: DarkBlue; text-align: center;">
				Weekly Settlement History
			</h3>
			<div id='TableToolsPlacement'></div>
			<br />
			<div class="form-inline">
				<table id="example" class="table table-striped table-bordered"
					cellspacing="0">
					<thead>
						<tr>
							<th data-class="expand"><font color="#000000">Transaction Id</font></th>
							<th><font color="#000000">Paid Amount</font></th>
							<th data-hide="phone"><font color="#000000">Payment Mode</font></th>
							<th data-hide="phone"><font color="#000000">Payment Agent</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Payment
									Ordinal</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Payment Date</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Audit Comments</font></th>
						</tr>
					</thead>
						<?php
						$objBilling->PopulateSettlementHistory ( $user_id, $time_zone );
						?>
						<tfoot>
						<tr>
							<th data-class="expand"><font color="#000000">Transaction Id</font></th>
							<th><font color="#000000">Paid Amount</font></th>
							<th data-hide="phone"><font color="#000000">Payment Mode</font></th>
							<th data-hide="phone"><font color="#000000">Payment Agent</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Payment
									Ordinal</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Payment Date</font></th>
							<th data-hide="phone,tablet"><font color="#000000">Audit Comments</font></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<br />
			<br />
			    <?php
							include_once (dirname ( __FILE__ ) . "/../../lib/footer.php");
							?>
			</div>
	</div>
	<script type="text/javascript">
	'use strict';
	
	$(document).ready(function () {
		
	    var responsiveHelper = undefined;
	    var breakpointDefinition = {
	        tablet: 1024,
	        phone : 480
	    };
	    $.fn.dataTable.TableTools.defaults.aButtons = [ "csv", "pdf" ];
	    $.fn.dataTable.TableTools.defaults.sSwfPath = "<?php $objIncludeJsCSS->IncludeDatatablesCopy_CSV_XLS_PDF("../../");?>";
	    var tableElement = $('#example');
	    var table = tableElement.dataTable({
	    	"dom": 'T<"clear">lfrtip',
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
	            responsiveHelper.respond();
	        }
	    });
	    responsiveTable();
	});

	function responsiveTable(){
	    var array = new Array();
	    $('table.js-responsive-table').each(function(){
	        $(this).find('thead th').each(function(i){
	        array[i] = $(this).html();
	        })
	        $(this).find('tbody tr').each(function(){
	            var attrInt =0;
	            $(this).find('td').each(function(i){
	                 var attr = $(this).attr('colspan');
	                 if (typeof attr !== 'undefined' && attr !== false){
	                     $(this).prepend('<span>' + array[attrInt] + '</span>')
	                     var attrInt1 = parseInt(attr)-1;
	                     attrInt = attrInt + attrInt1;
	                 }
	                 else{
	                     $(this).prepend('<span>' + array[attrInt] + '</span>')
	                 }
	                 attrInt++;
	             })
	        })
	  })

	}
	</script>
</body>
</html>