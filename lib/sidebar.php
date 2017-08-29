<?php 
	include_once(dirname(__FILE__)."/../database/config.php");
	include_once(dirname(__FILE__)."/site_config.php");
	include_once(dirname(__FILE__)."/session_manager.php");
	include_once (dirname ( __FILE__ ) . "/../database/product_queries.php");
	
	$objProductQueries = new CProductQuery ();
	
	$aryCategories = $objProductQueries->GetProductCategories ();
	
	$aryIcons = array ("Banking & Insurance" => "<i class='fa fa-money fa-lg'></i>",
			"Government Jobs" => "<i class='fa fa-globe fa-lg'></i>",
			"Engineering Entrance" => "<i class='fa fa-gears fa-lg'></i>",
			"Medical Entrance" => "<i class='fa fa-user-md fa-lg'></i>",
			"MBA Entrance" => "<i class='fa fa-mortar-board fa-lg'></i>",
			"Campus Preparation" => "<i class='fa fa-university fa-lg'></i>",
			"Diploma Preparation" => "<i class='fa fa-certificate fa-lg'></i>",
			"Misc Preparation" => "<i class='fa fa-navicon fa-lg'></i>" );
	
	$jsonCartItems = CSessionManager::Get(CSessionManager::JSON_CART_ITEMS);
	
	$aryCartItems = json_decode($jsonCartItems, TRUE);
	
	if(empty($aryCartItems))
		$iItemsInCart = 0;
	else
		$iItemsInCart = count($aryCartItems) - 1; // Remove status item
	
	// - - - - - - - - - - - - - - - - -
	// On Session Expire Load ROOT_URL
	// - - - - - - - - - - - - - - - - -
	CSessionManager::OnSessionExpire();
	// - - - - - - - - - - - - - - - - -
	$menu_class_ary = array();
	if($menu_id === CSiteConfig::UAMM_DASHBOARD)
	{
		$menu_class_ary[$menu_id] = "class='active stick bg-red'";
	}
	else 
	{
		$menu_class_ary[$menu_id] = "open";
	}
	
	$pages_class_ary = array();
	if(isset($page_id))
	{
		$pages_class_ary[$page_id] = "class='active stick2 bg-red'";
	}
	
	$user_type = CSessionManager::Get ( CSessionManager::INT_USER_TYPE );
	
	$plan_type = CSessionManager::Get ( CSessionManager::INT_APPLIED_PLAN );
	
	$plan_ary = array(CConfig::SPT_BASIC=>"Basic SaaS", CConfig::SPT_PROFESSIONAL=>"Professional SaaS", CConfig::SPT_ENTERPRISE=>"Enterprise SaaS");
?>
	<div id='sidebar' style="padding-bottom: 100px;">
		<div class="metro">
			<div class="grid fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<nav class="sidebar light">
							<ul>
								<?php 
								if($user_type == CConfig::UT_SUPER_ADMIN)
								{
								?>
								<li class="title" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;color: #317eac;"><b>Super Admin</b></li>
								<?php 
								}
								else if($user_type != CConfig::UT_INDIVIDAL)
								{
								?>
								<li class="title" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;color: #317eac;"><b>Admin Panel</b></li>
								<?php 
								}
								?>
								<li <?php echo($menu_class_ary[CSiteConfig::UAMM_DASHBOARD]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/dashboard.php"><i class="icon-home fg-steel"></i>Dashboard</a></li>
								<?php 
								if($user_type != CConfig::UT_INDIVIDAL)
								{
								?>
								<li><a href="<?php echo(CSiteConfig::ROOT_URL);?>/search-results.php"><i class="icon-list fg-steel"></i>Store Front</a></li>
								<?php 
								}
								?>
								<li <?php echo($menu_class_ary[CSiteConfig::UAMM_PURCHASED_PRODUCTS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/purchased-products.php"><i class="icon-credit-card fg-red"></i>Purchased Products</a></li>
								<?php 
								if($user_type != CConfig::UT_INDIVIDAL)
								{
								?>
								<li><a class="dropdown-toggle" href="#"><i class="icon-github-6 fg-steel"></i>Sneak Peek</a>
									<ul class="dropdown-menu <?php echo($menu_class_ary[CSiteConfig::UAMM_SNEAK_PEEK]);?>" data-role="dropdown">
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_SNEAK_PEEK_MIPCAT]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/sneak-peek/sneak_peek_mipcat.php"><i class="icon-arrow-right-4"></i><?php echo(CConfig::SNC_SITE_NAME);?> Knowledge Base</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_SNEAK_PEEK_PERSONAL]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/sneak-peek/sneak_peek_personal.php"><i class="icon-arrow-right-4"></i> Personal Knowledge Base</a></li>
									</ul></li>
								<?php
								}
								if($user_type == CConfig::UT_INDIVIDAL)
								{
									foreach ( $aryCategories as $strCategory => $aryValues )
									{
										// Remove whitespace from name to form html id.
										$element_id = preg_replace ( "/[^a-zA-Z]+/", "", $strCategory );
											
										if(count($aryValues) > 0)
										{
											printf ( "<li class='stick bg-blue'><a class='dropdown-toggle' href='#'>%s %s</a>", $aryIcons [$strCategory], $strCategory );
											printf ( "<ul class='dropdown-menu' data-role='dropdown' id='%s'>", $element_id );
									
											foreach ( $aryValues as $subCategory ) {
												//class='active'
												printf ( "<li><a href='%s/search-results.php?ci=%d'><i class='icon-arrow-right-4'></i> %s</a></li>", CSiteConfig::ROOT_URL, $subCategory[0], $subCategory[1] );
											}
									
											printf ( "</ul></li>" );
										}
									}
								}
								
								if($user_type == CConfig::UT_SUPER_ADMIN)
								{
								?>
								<li><a class="dropdown-toggle" href="#"><i class="icon-user fg-steel"></i>Super Admin</a>
									<ul class="dropdown-menu <?php echo($menu_class_ary[CSiteConfig::UAMM_SUPER_ADMIN]);?>" data-role="dropdown">
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_DT_REGISTERED_USERS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/super-admin/dt_registered_users.php"><i class="icon-arrow-right-4"></i>Registered Users</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_REALIZE_PAYMENT]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/super-admin/realize_payment.php"><i class="icon-arrow-right-4"></i>Realize Payment</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_FREE_EVALUATION_RECHARGE]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/super-admin/free_test_credit.php"><i class="icon-arrow-right-4"></i>Free Evaluation Recharge</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_INDIVIDUAL_USERS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/super-admin/dt_indv_users.php"><i class="icon-arrow-right-4"></i>Individual Users</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_CONTRIBUTOR_USERS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/super-admin/dt_contrib_users.php"><i class="icon-arrow-right-4"></i>Contributors</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_PROCESS_CONTRIBUTOR_PAYMENT]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/super-admin/contrib_payment_process.php"><i class="icon-arrow-right-4"></i>Process Contributor Payment</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_BA_PAYMENT_PROCESS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/super-admin/ba_payment_process.php"><i class="icon-arrow-right-4"></i>Process BA Payment</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_ACCOUNT_STATUS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/super-admin/dt_acc_status.php"><i class="icon-arrow-right-4"></i>Account Status</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_SCHEDULED_TEST]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/super-admin/dt_scheduled_tests.php"><i class="icon-arrow-right-4"></i>Scheduled Tests</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_REGISTER_VERIFIERS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/super-admin/register-verif.php"><i class="icon-arrow-right-4"></i>Register Verifiers</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_REGISTER_BUSINESS_ASSOCIATE]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/super-admin/register-ba.php"><i class="icon-arrow-right-4"></i>Register Business Associate</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_EMAIL_PROMOTIONS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/super-admin/promotional_email.php"><i class="icon-arrow-right-4"></i>Email Promotions</a></li>
									</ul></li>
								<?php 
								}
								?>
								<li><a class="dropdown-toggle" href="#"><i class="icon-grid-view fg-steel"></i>My Account</a>
									<ul class="dropdown-menu <?php echo($menu_class_ary[CSiteConfig::UAMM_MY_ACCOUNT]);?>" data-role="dropdown">
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_PERSONAL_DETAILS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/account/personal-details.php"><i class="icon-arrow-right-4"></i>Personal Details</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_ACCOUNT_SECURITY]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/account/security.php"><i class="icon-arrow-right-4"></i>Account Security</a></li>
										<?php 
										if($user_type != CConfig::UT_INDIVIDAL)
										{
										?>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_ABOUT_ORGANIZATION]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/account/about.php"><i class="icon-arrow-right-4"></i>About Organization</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_BILLING_INFORMATION]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/account/billing.php"><i class="icon-arrow-right-4"></i>Settlement Information</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_ACCOUONT_USAGE]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/account/usage.php"><i class="icon-arrow-right-4"></i>Account Usage</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_ACOOUNT_KYC_FORM]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/account/kyc-form.php"><i class="icon-arrow-right-4"></i>KYC Form</a></li>
										<?php 
										}
										?>
									</ul></li>
								<?php 
								if(FALSE)//$user_type == CConfig::UT_SUPER_ADMIN
								{
								?>
								<li><a class="dropdown-toggle" href="#"><i class="icon-share-2 fg-steel"></i>My Coordinators</a>
									<ul class="dropdown-menu <?php echo($menu_class_ary[CSiteConfig::UAMM_MY_COORDINATORS]);?>" data-role="dropdown">
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_REGISTERED_COORDINATORS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/coordinators/create.php"><i class="icon-arrow-right-4"></i>Register Coordinators</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_MANAGE_COORDINATORS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/coordinators/manage.php"><i class="icon-arrow-right-4"></i>Manage Coordinators</a></li>
									</ul></li>
								<?php 
								}
								
								if($user_type != CConfig::UT_INDIVIDAL)
								{
								?>
								<li><a class="dropdown-toggle" href="#"><i class="icon-help fg-steel"></i>Manage Questions</a>
									<ul class="dropdown-menu <?php echo($menu_class_ary[CSiteConfig::UAMM_MANAGE_QUESTIONS]);?>" data-role="dropdown">
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_SUBMIT_QUESTION]);?> ><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/manage-questions/submit_single_ques.php"><i class="icon-arrow-right-4"></i>Submit Question</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_BULK_UPLOAD_EXCEL]);?> ><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/manage-questions/bulk_upload_ques.php"><i class="icon-arrow-right-4"></i>Bulk Upload(Excel)</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_RECONCILE_QUESTIONS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/manage-questions/dt_reconcile_questions.php"><i class="icon-arrow-right-4"></i>Reconcile Questions</a></li>
									</ul></li>
								<li><a class="dropdown-toggle" href="#"><i class="icon-book fg-steel"></i>Design &amp; Manage Test</a>
									<ul class="dropdown-menu <?php echo($menu_class_ary[CSiteConfig::UAMM_DESIGN_MANAGE_TEST]);?>" data-role="dropdown">
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_TEST_DESIGN_WIZARD]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/design-and-manage-test/tdwizard.php"><i class="icon-arrow-right-4"></i>Test Design Wizard</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_MANAGE_TEST]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/design-and-manage-test/manage_test.php"><i class="icon-arrow-right-4"></i>Manage Tests</a></li>
									</ul></li>
								<?php 
								if(false)
								{
								?>
								<li><a class="dropdown-toggle" href="#"><i class="icon-flickr fg-steel"></i>Batch Management</a>
									<ul class="dropdown-menu <?php echo($menu_class_ary[CSiteConfig::UAMM_BATCH_MANAGEMENT]);?>" data-role="dropdown">
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_MANAGE_BATCH]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/batch-management/manage_batch.php"><i class="icon-arrow-right-4"></i>Manage Batch</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_CAHNGE_BATCH]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/batch-management/change_cand_batch.php"><i class="icon-arrow-right-4"></i>Change Batch</a></li>
									</ul></li>
								<?php 
								}
								?>
								<li><a class="dropdown-toggle" href="#"><i class="icon-user-3 fg-steel"></i>Register Candidates</a>
									<ul class="dropdown-menu <?php echo($menu_class_ary[CSiteConfig::UAMM_REGISTER_CANDITATES]);?>" data-role="dropdown">
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_REGISTER_USERS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/register-candidates/register_cands.php"><i class="icon-arrow-right-4"></i>Register Users</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_REGISTERED_USERS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/register-candidates/dt_candidates.php"><i class="icon-arrow-right-4"></i>Manage Registered Users</a></li>
									</ul></li>
								<?php 
								if(false)
								{
								?>
								<li><a class="dropdown-toggle" href="#"><i class="icon-clock fg-steel"></i>Launch Test</a>
									<ul class="dropdown-menu <?php echo($menu_class_ary[CSiteConfig::UAMM_SCHEDULE_TEST]);?>" data-role="dropdown">
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_SCHEDULE_TEST]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/schedule-test/schedule_new_test.php"><i class="icon-arrow-right-4"></i>Schedule Test</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_MANAGE_SCHEDULED_TEST]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/schedule-test/edit_scheduled_test.php"><i class="icon-arrow-right-4"></i>Manage Scheduled Tests</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_MONITOR_ACTIVE_TEST]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/schedule-test/monitor_active_tests.php"><i class="icon-arrow-right-4"></i>Monitor Active Tests</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_VIEW_SCHEDULED_TEST]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/schedule-test/view_scheduled_test.php"><i class="icon-arrow-right-4"></i>View Scheduled Tests</a></li>
									</ul></li>
								<?php
								}
								} 
								/*
								?>
								<li><a class="dropdown-toggle" href="#"><i class="icon-dollar fg-steel"></i>Trade Test Packges</a>
									<ul class="dropdown-menu <?php echo($menu_class_ary[CSiteConfig::UAMM_TRADE_TEST_PACKGES]);?>" data-role="dropdown">
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_TRADE_TEST_PACKGE]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/trade-test-package/trade_test_pkg.php"><i class="icon-arrow-right-4"></i>Trade Test Packge</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_VIEW_SOLD_TEST_PACKGES]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/trade-test-package/view_sold_pkg.php"><i class="icon-arrow-right-4"></i>View Sold Test Packges</a></li>
									</ul></li>
								<?php 
								*/
								?>
								
								<li><a class="dropdown-toggle" href="#"><i class="icon-stats-up fg-steel"></i>Result Analytics</a>
									<ul class="dropdown-menu <?php echo($menu_class_ary[CSiteConfig::UAMM_RESULT_ANALYTICS]);?>" data-role="dropdown">
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_BRIEF_RESULT]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/result-analytics/dt_brief_result.php"><i class="icon-arrow-right-4"></i>Brief Result</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_BENCHMARK]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/result-analytics/benchmark.php"><i class="icon-arrow-right-4"></i>Bench-marking</a></li>
										<?php
										if(false) //$user_type != CConfig::UT_INDIVIDAL)
										{
										?>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_ANALYZE_QUESTION]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/result-analytics/analyze_questions.php"><i class="icon-arrow-right-4"></i>Analyze Question Usage</a></li>
										<?php 
										}
										?>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_TEST_DNA_ANALYSIS]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/result-analytics/detailed_result_analytics.php"><i class="icon-arrow-right-4"></i>Result Data Analysis</a></li>
										<li <?php echo($pages_class_ary[CSiteConfig::UAP_RESULT_INSPECTION]);?>><a href="<?php echo(CSiteConfig::ROOT_URL);?>/core/result-analytics/inspection_result_analytics.php"><i class="icon-arrow-right-4"></i>Attempted Tests</a></li>
									</ul></li>
									<?php 
									if($user_type == CConfig::UT_INDIVIDAL)
									{
									?>
									<li class="stick bg-green sr-sidebar-checkout"><a href="<?php echo(CSiteConfig::ROOT_URL);?>/checkout.php"> Checkout <i
										class="fa fa-shopping-cart fa-lg"></i> <span
										class="badge badge-warning" id="checkout_badge" style="margin-top: -5px;"><?php echo($iItemsInCart);?></span>
									</a></li>
									<?php 
									}
									?>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>