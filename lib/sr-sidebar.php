<?php
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
	
	// -----------------------------------
	// Prepare menu bootstrap class array
	// -----------------------------------
	$menu_class_ary = array();
	if($menu_id === CSiteConfig::UAMM_DASHBOARD)
	{
		$menu_class_ary[$menu_id] = "class='active stick bg-red'";
	}
	else
	{
		$menu_class_ary[$menu_id] = "open";
	}
	// -----------------------------------
	
	// -----------------------------------
	// Prepare array for active menu item
	// -----------------------------------
	$pages_class_ary = array();
	if(isset($page_id))
	{
		$pages_class_ary[$page_id] = "class='active stick2 bg-red'";
	}
	// -----------------------------------
	
	$user_type = CSessionManager::Get ( CSessionManager::INT_USER_TYPE );
?>
<div id='sidebar' class="col-sm-3 col-md-3 col-lg-3" style='position: fixed;padding-right:30px;'>
		<div class="metro">
			<div class="grid fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<nav class="sidebar light">
							<ul>
								<li><a href="<?php echo(CSiteConfig::ROOT_URL);?>"> <i
										class="fa fa-home fa-lg"></i> Home
								</a></li>
								
								<?php
								if($user_type == CConfig::UT_INDIVIDAL)
								{
									printf("<li %s><a href='%s/core/purchased-products.php'><i class='icon-credit-card fg-red'></i>Purchased Products</a></li>",
									$menu_class_ary[CSiteConfig::UAMM_PURCHASED_PRODUCTS], CSiteConfig::ROOT_URL);
								}
								
								foreach ( $aryCategories as $strCategory => $aryValues ) 
								{
									// Remove whitespace from name to form html id.
									$element_id = preg_replace ( "/[^a-zA-Z]+/", "", $strCategory );
									
									if(count($aryValues) > 0)
									{
										printf ( "<li><a class='dropdown-toggle' href='#'>%s %s</a>", $aryIcons [$strCategory], $strCategory );
										printf ( "<ul class='dropdown-menu' data-role='dropdown' id='%s'>", $element_id );
										
										foreach ( $aryValues as $subCategory ) {
											//class='active'
											printf ( "<li><a href='%s/search-results.php?ci=%d'><i class='icon-arrow-right-4'></i> %s</a></li>", CSiteConfig::ROOT_URL, $subCategory[0], $subCategory[1] );
										}
										
										printf ( "</ul></li>" );
									}
								}
								
								if($user_type == CConfig::UT_INDIVIDAL)
								{
									printf("<li><a class='dropdown-toggle' href='#'><i class='icon-grid-view fg-steel'></i>My Account</a>");
									printf("<ul class='dropdown-menu %s' data-role='dropdown'>", $menu_class_ary[CSiteConfig::UAMM_MY_ACCOUNT]);
									printf("<li %s><a href='%s/core/account/personal-details.php'><i class='icon-arrow-right-4'></i>Personal Details</a></li>", $pages_class_ary[CSiteConfig::UAP_PERSONAL_DETAILS], CSiteConfig::ROOT_URL);
									printf("<li %s><a href='%s/core/account/security.php'><i class='icon-arrow-right-4'></i>Account Security</a></li>", $pages_class_ary[CSiteConfig::UAP_ACCOUNT_SECURITY], CSiteConfig::ROOT_URL);
									printf("</ul></li>");
								
									printf("<li><a class='dropdown-toggle' href='#'><i class='icon-stats-up fg-steel'></i>Result Analytics</a>");
									printf("<ul class='dropdown-menu %s' data-role='dropdown'>", $menu_class_ary[CSiteConfig::UAMM_RESULT_ANALYTICS]);
									printf("<li %s><a href='%s/core/result-analytics/dt_brief_result.php'><i class='icon-arrow-right-4'></i>Brief Result</a></li>", $pages_class_ary[CSiteConfig::UAP_BRIEF_RESULT], CSiteConfig::ROOT_URL);
									printf("<li %s><a href='%s/core/result-analytics/detailed_result_analytics.php'><i class='icon-arrow-right-4'></i>Result Data Analysis</a></li>", $pages_class_ary[CSiteConfig::UAP_TEST_DNA_ANALYSIS], CSiteConfig::ROOT_URL);
									printf("<li %s><a href='%s/core/result-analytics/inspection_result_analytics.php'><i class='icon-arrow-right-4'></i>Attempted Tests</a></li>", $pages_class_ary[CSiteConfig::UAP_RESULT_INSPECTION], CSiteConfig::ROOT_URL);
									printf("</ul></li>");
								}
								?>
								<li class="sr-sidebar-checkout"><a href="<?php echo(CSiteConfig::ROOT_URL);?>/checkout.php"> Checkout <i
										class="fa fa-shopping-cart fa-lg"></i> <span
										class="badge badge-warning" id="checkout_badge" style="margin-top: -5px;"><?php echo($iItemsInCart);?></span>
								</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>