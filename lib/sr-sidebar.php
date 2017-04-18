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

<div class="nav-side-menu">
	<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse"
		data-target="#menu-content"></i>
	<div class="menu-list">
		<ul id="menu-content" class="menu-content collapse out">
			<li><a href="<?php echo(CSiteConfig::ROOT_URL);?>"> <i
					class="fa fa-home fa-lg"></i> Home
			</a></li>
			<?php
			foreach ( $aryCategories as $strCategory => $aryValues ) 
			{
				$element_id = preg_replace ( "/[^a-zA-Z]+/", "", $strCategory );
				
				if(count($aryValues) > 0)
				{
					printf ( "<li data-toggle='collapse' data-target='#%s' class='collapsed'><a href='#'>%s %s<span class='arrow'></span></a></li>", $element_id, $aryIcons [$strCategory], $strCategory );
					printf ( "<ul class='sub-menu collapse' id='%s'>", $element_id );
					
					foreach ( $aryValues as $subCategory ) {
						printf ( "<li class='active'><a href='#'>%s</a></li>", $subCategory );
					}
					
					printf ( "</ul>" );
				}
			}
			?>
			<li class="sr-sidebar-checkout"><a href="#"> Checkout <i
					class="fa fa-shopping-cart fa-lg"></i> <span
					class="badge badge-warning" id="checkout_badge" style="margin-top: -17px;"><?php echo($iItemsInCart);?></span>
			</a></li>
		</ul>
	</div>
</div>