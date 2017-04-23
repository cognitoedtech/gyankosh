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
								foreach ( $aryCategories as $strCategory => $aryValues ) 
								{
									$element_id = preg_replace ( "/[^a-zA-Z]+/", "", $strCategory );
									
									if(count($aryValues) > 0)
									{
										printf ( "<li><a class='dropdown-toggle' href='#'>%s %s</a>", $aryIcons [$strCategory], $strCategory );
										printf ( "<ul class='dropdown-menu' data-role='dropdown' id='%s'>", $element_id );
										
										foreach ( $aryValues as $subCategory ) {
											//class='active'
											printf ( "<li><a href='#'><i class='icon-arrow-right-4'></i> %s</a></li>", $subCategory );
										}
										
										printf ( "</ul></li>" );
									}
								}
								?>
								<li class="sr-sidebar-checkout"><a href="checkout.php"> Checkout <i
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