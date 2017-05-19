<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
include_once (dirname ( __FILE__ ) . "/../../lib/session_manager.php");
include_once (dirname ( __FILE__ ) . "/../../database/mcat_db.php");
include_once (dirname ( __FILE__ ) . "/../../lib/user_manager.php");
include_once (dirname ( __FILE__ ) . "/../../lib/include_js_css.php");
include_once (dirname ( __FILE__ ) . "/../../lib/site_config.php");
include_once (dirname ( __FILE__ ) . "/../../lib/billing.php");

// - - - - - - - - - - - - - - - - -
// On Session Expire Load ROOT_URL
// - - - - - - - - - - - - - - - - -
CSessionManager::OnSessionExpire ();
// - - - - - - - - - - - - - - - - -

$objDB = new CMcatDB ();
$objUM = new CUserManager ();
$objIncludeJsCSS = new IncludeJSCSS ();

$user_id = CSessionManager::Get ( CSessionManager::STR_USER_ID );
$objUser = $objUM->GetUserById ( $user_id );

$user_type = CSessionManager::Get ( CSessionManager::INT_USER_TYPE );

$objBilling = new CBilling();
$arySellerBilling = $objBilling->GetSellerBilling($user_id);

$bSellerKYCEntryPresent = FALSE;
$bKYCDone = FALSE;
if(!is_null($arySellerBilling))
{
	$bSellerKYCEntryPresent = TRUE;
	$bKYCDone = $arySellerBilling['kyc_done'];
}

$menu_id = CSiteConfig::UAMM_MY_ACCOUNT;
$page_id = CSiteConfig::UAP_ACOOUNT_KYC_FORM;
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="Generator" content="Mastishka Intellisys Private Limited">
<meta name="Author" content="Mastishka Intellisys Private Limited">
<meta name="Keywords" content="">
<meta name="Description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo(CConfig::SNC_SITE_NAME);?>: About Organization </title>
		<?php
		$objIncludeJsCSS->CommonIncludeCSS ( "../../" );
		$objIncludeJsCSS->IncludeBootStrapFileUploadCSS ( "../../" );
		$objIncludeJsCSS->IncludeIconFontCSS ( "../../" );
		
		$objIncludeJsCSS->CommonIncludeJS ( "../../" );
		$objIncludeJsCSS->IncludeBootStrapFileUploadMinJS ( "../../" );
		$objIncludeJsCSS->IncludeJqueryValidateMinJS ( "../../" );
		$objIncludeJsCSS->IncludeMetroNotificationJS ( "../../" );
		?>
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
		<div class="col-lg-9 col-sm-9 col-md-9"
			style="border-left: 1px solid #ddd; border-top: 1px solid #ddd;">
			<br />
			<h4>
				<u>Know your client</u> verification form <?php echo($bKYCDone?"":"(<span style='color:red;'>Your details verification is pending</span>)");?>
			</h4>
			<br />
			<form class="form-horizontal" id="kyc_form"
				action="ajax/ajax_submit_kyc_form.php" method="POST">
				<div
					class="col-lg-6 col-sm-6 col-md-6 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
					<div class="row">
						<div class="input-group">
							<span class="input-group-addon" id="bank_account_number">Bank Account
								#</span> <input type="text" id="bank_account_number" 
								value="<?php echo($bSellerKYCEntryPresent ? $arySellerBilling['bank_account_number'] : '');?>"
								name="bank_account_number" class="form-control"
								placeholder="Bank Account Number"
								aria-describedby="bank_account_number">
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-group">
							<span class="input-group-addon" id="bank_ifsc_code">IFSC Code</span>
							<input type="text" id="bank_ifsc_code" name="bank_ifsc_code"
								value="<?php echo($bSellerKYCEntryPresent ? $arySellerBilling['bank_ifsc_code'] : '');?>"
								class="form-control" placeholder="Bank Branch IFSC Code"
								aria-describedby="bank_ifsc_code">
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-group">
							<span class="input-group-addon" id="bank_name">Bank Name</span> <input
								type="text" id="bank_name" name="bank_name" class="form-control"
								value="<?php echo($bSellerKYCEntryPresent ? $arySellerBilling['bank_name'] : '');?>"
								placeholder="Bank Name" aria-describedby="bank_name">
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-group">
							<span class="input-group-addon" id="bank_user_name">Account Name</span>
							<input type="text" id="bank_user_name" name="bank_user_name"
								value="<?php echo($bSellerKYCEntryPresent ? $arySellerBilling['bank_user_name'] : '');?>"
								class="form-control" placeholder="Bank Account Name"
								aria-describedby="bank_user_name">
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-group">
							<span class="input-group-addon" id="pan_number">PAN #</span> <input
								type="text" id="pan_number" name="pan_number"
								value="<?php echo($bSellerKYCEntryPresent ? $arySellerBilling['pan_number'] : '');?>"
								class="form-control"
								placeholder="Permanent Account Number for tax filing"
								aria-describedby="pan_number"
								<?php echo($bSellerKYCEntryPresent ? 'readonly' : '');?>>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="input-group">
							<span class="input-group-addon" id="market_percentage_sharing">Your
								Revenue Share on Market Place (in %)</span> <input readonly type="text"
								id="market_percentage_sharing" name="market_percentage_sharing" 
								value="<?php echo($bSellerKYCEntryPresent ? $arySellerBilling['market_percentage_sharing'] : '50');?>"
								class="form-control" aria-describedby="market_percentage_sharing"/>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="checkbox">
							<label> <input type="checkbox" onclick="OnTerms(this);"> I agree to the <a href="#">terms of revenue
								sharing</a> and confirms that all of the details provided by me
								above are true. If any issues are found in aforementioned
								information, I will be responsible.
							</label>
						</div>
					</div>
					<br/>
					<div class="row">
						<div class="text-center">
							<button type="submit" id="submit_btn" class="btn btn-success" disabled>Submit Form</button>
						</div>
					</div>
				</div>
				<div
					class="col-lg-4 col-sm-4 col-md-4 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
					<div class="row">
						<p style="color: purple;">We understand that you will be creating best tests/sets at 
						<?php echo(CConfig::SNC_SITE_NAME);?>. <?php echo(CConfig::SNC_SITE_NAME);?> is also commited 
						to have budget for effective marketing to sell publisher's tests/sets via our various channel 
						partner.  We fairly share commission with every channel partners and offer discount coupons 
						to end users. We cover all of these expenses from our share.
						<br />
						<br /> We would want to assure you that you are the highest revenue earner from your efforts!
						<br />
						<br /> <b>Note:</b> As per government norms, taxes will be charged extra to test/set buyer.
						</p>
						<hr />
						<p>Get in touch with us if you have any questions or concerns, we
							will be happy to help.</p>
						<address>
							<abbr title="Phone"><i class="fa fa-phone" aria-hidden="true"></i>
								: </abbr> +91 903 957 9039 <br /> <abbr title="Phone"><i
								class="fa fa-phone" aria-hidden="true"></i> : </abbr> +91 982 660 0457 <br /> 
								<abbr title="Email"><i class="fa fa-paper-plane"
								aria-hidden="true"></i> : </abbr> <a
								href="mailto:quizus.co@gmail.com">quizus.co(at)gmail.com</a><br />
						</address>
					</div>
					<br />
				</div>
			</form>
		</div>
		<?php
		include (dirname ( __FILE__ ) . "/../../lib/footer.php");
		?>
	</div>
</body>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#kyc_form').validate({
				errorPlacement: function(error, element) {			
					//$('#acadamic_details div.reg-error').append(error);
					$(error).insertAfter(element.parent());
				}, rules: {
					pan_number : {
	            		required:true
	        		},
					bank_account_number : {
	            		required:true
	        		},
					bank_ifsc_code : {
	            		required:true
	        		},
					bank_name : {
	            		required:true
	        		},
					bank_user_name : {
	            		required:true
	        		} 
				}, messages: {
					pan_number : {	
	    				required:	"<div style='color:red'>* Please provide your tax identification (PAN) number.</div>",
	        		},
					bank_account_number : {	
	    				required:	"<div style='color:red'>* Please provide your bank account number.</div>",
	        		},
					bank_ifsc_code : {	
	    				required:	"<div style='color:red'>* Please provide your bank's branch IFSC code.</div>",
	        		},
					bank_name : {	
	    				required:	"<div style='color:red'>* Please provide your bank's name.</div>",
	        		},
					bank_user_name : {	
	    				required:	"<div style='color:red'>* Please provide your registered name with bank.</div>",
	        		},
				},submitHandler: function(form) {
					form.submit();
				}
			});
		});

		function OnTerms(obj)
		{
			if ($(obj).is(':checked',true))
			{
				$("#submit_btn").attr('disabled', false);
			}
			else
			{
				$("#submit_btn").attr('disabled', true);
			}
		}

		<?php 
		if($_GET["status"] == 1)
		{
		?>
		$.Notify({
			 caption: "Your request is submitted !",
			 content: "We have received your request, our representative will soon contact you !",
			 style: {background: 'green', color: '#fff'}, 
			 timeout: 10000
			 });
		<?php 
		}
		?>
	</script>
</html>