<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
	include_once("../../lib/session_manager.php");
	include_once('../../test/lib/tbl_result.php');
	include_once(dirname(__FILE__)."/../../lib/include_js_css.php");
	include_once(dirname(__FILE__)."/../../lib/site_config.php");
	
	// - - - - - - - - - - - - - - - - -
	// On Session Expire Load ROOT_URL
	// - - - - - - - - - - - - - - - - -
	CSessionManager::OnSessionExpire();
	// - - - - - - - - - - - - - - - - -
	
	$objTR = new CResult();
	
	$user_id = CSessionManager::Get(CSessionManager::STR_USER_ID);
	$nUserType = CSessionManager::Get(CSessionManager::INT_USER_TYPE);
	
	$TNameAry = $objTR->GetCompletedTestNames($user_id, $nUserType, true);
	
	$objIncludeJsCSS = new IncludeJSCSS();
	
	$menu_id = CSiteConfig::UAMM_RESULT_ANALYTICS;
	$page_id = CSiteConfig::UAP_BENCHMARK;
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="Generator" content="Mastishka Intellisys Private Limited">
<meta name="Author" content="Mastishka Intellisys Private Limited">
<meta name="Keywords" content="">
<meta name="Description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo(CConfig::SNC_SITE_NAME);?>: Test DNA Analysis</title>
<?php 
$objIncludeJsCSS->CommonIncludeCSS ( "../../" );
$objIncludeJsCSS->IncludeIconFontCSS ( "../../" );
$objIncludeJsCSS->IncludeFuelUXCSS ( "../../" );
$objIncludeJsCSS->CommonIncludeJS ( "../../");
$objIncludeJsCSS->IncludeCanvasMinJS ( "../../");
$objIncludeJsCSS->CommonIncludeHighchartsJS("../../");
$objIncludeJsCSS->IncludeJQueryNouisliderMinJS("../../");
$objIncludeJsCSS->IncludeResultAnalyticsJS("../../");
?>
<style type="text/css">
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

	<?php 
	include_once(dirname(__FILE__)."/../../lib/header.php");
	?>

	<!-- --------------------------------------------------------------- -->
	<br />
	<br />
	<br />
	<div class='row-fluid'>
		<div class="col-lg-3 col-md-3 col-sm-3">
			<?php 
			include_once(dirname(__FILE__)."/../../lib/sidebar.php");
			?>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9" style="border-left: 1px solid #ddd; border-top: 1px solid #ddd;">
			<div class="fuelux modal1">
				<div class="preloader"><i></i><i></i><i></i><i></i></div>
			</div>
			<br />
			<div class="row fluid">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-4">
							<select class="form-control" id="chosen_product">
								<option value='-1'>Select Product</option>
								<?php 
								$objTR->PopulateTestsForBenchmark($user_id, $nUserType);
								?>
							</select>
						</div>
						<?php 
						if($nUserType == CConfig::UT_INDIVIDAL) {
						?>
						<div class="col-lg-4 col-md-4 col-sm-4">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">Your Rank</span>
								<input readonly type="text" class="form-control" id="user_rank" aria-describedby="basic-addon1">
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon2">Your Percentage</span>
								<input readonly type="text" class="form-control" id="user_percent" aria-describedby="basic-addon2">
							</div>
						</div>
						<?php 
						}
						else {
						?>
						<div class="col-lg-4 col-md-4 col-sm-4">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon3">Total Candidates</span>
								<input readonly type="text" class="form-control" id="total_candidates" aria-describedby="basic-addon3">
							</div>
						</div>
						<?php 
						}
						?>
					</div>
					<br/><br/><br/><br/>
					<div class="row">
						<div id="standard_deviation"></div>
					</div>
				</div>
			</div>
			<?php
			include_once (dirname ( __FILE__ ) . "/../../lib/footer.php");
			?>
		</div>
	</div>
	<script type="text/javascript">
	$(document).ready(function() {
		$("#chosen_product").on("change", function() {
			if(this.value < 0) {
				return;
			}

			var sPNR = $(this).children(":selected").attr("pnr");
			if (typeof sPNR === typeof undefined && sPNR === false) {
				sPNR = "";
			}
			//alert(sPNR);

			$(".modal1").show();
			$.post("ajax/ajax_get_test_stats.php", { test_id: this.value, test_pnr: sPNR }).done(function( data ) {
					//alert( "Data Loaded: " + data );
					var obj = $.parseJSON(data);

					var rank = $("#user_rank").val();
					if (typeof rank !== typeof undefined && rank !== false) {
						$("#user_rank").val(obj.meta.rank);
					}

					var marks = $("#user_marks").val();
					if (typeof rank !== typeof undefined && rank !== false) {
						$("#user_percent").val(obj.meta.percent_obtained);
					}
					
					//alert(obj[0].marks_scored); 
					var aryTestData = [];
					var index = 0;
					var nTotalCandidates = 0;
					$.each(obj.normalized, function( key, value ) {
						  aryTestData[index] = value;
						  nTotalCandidates = nTotalCandidates + value;
						  index++;
					});

					var total_cand = $("#total_candidates").val();
					if (typeof total_cand !== typeof undefined && total_cand !== false) {
						$("#total_candidates").val(nTotalCandidates);
					}
					
				   	$('#standard_deviation').highcharts({
				        chart: {
				            type: 'areaspline'
				        },
				        title: {
				            text: 'Score Distribution'
				        },
				        legend: {
				            enabled:false
				        },
				        xAxis: {
				            title: {
				                text: 'Percentage Score'
				            },
				            labels: {
								step: 1
						    },
							categories:[
					            '0 - 10',
					            '10 - 20',
					            '20 - 30',
					            '30 - 40',
					            '40 - 50',
					            '50 - 60',
					            '60 - 70',
					            '70 - 80',
					            '80 - 90',
					            '90 - 100'
					        ],
					        plotBands: [{ // visualize the weekend
					            from: 4.5,
					            to: 9.5,
					            color: 'rgba(68, 170, 213, .2)'
					        }]
				        },
				        yAxis: {
				            title: {
				                text: 'Number of Aspirants'
				            }
				        },
				        tooltip: {
				            enabled:true
				        },
				        credits: {
				            enabled: false
				        },
				        plotOptions: {
				            enabled:false
				        },
				        series: [ {
				            name: 'Candidates',
				           	data: aryTestData,     
				            zoneAxis: 'x',
				            zones: [{
				               value: 0,
				               color: 'red'
				            }, {
				               value: 0.5,
				               color: 'yellow'
				            }, {
				                value: 1,
				               color: 'blue'
				            }, {
				                value: 2,
				               color: 'green'
				            }, {
				                value: 3,
				               color: 'black'
				            }, {
				                 value: 4,
				               color: 'red'
				            }, {
				                
				               color: 'gray'
				            }]
				        }]
				    });
				   	$(".modal1").hide();
				});
		});
	});
	</script>
</body>
</html>