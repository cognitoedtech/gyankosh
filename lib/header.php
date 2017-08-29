<?php
	include_once(dirname(__FILE__)."/../database/config.php");
	include_once(dirname(__FILE__)."/include_js_css.php");
	include_once(dirname(__FILE__)."/utils.php");
	include_once(dirname(__FILE__)."/user_manager.php");
	include_once(dirname(__FILE__)."/site_config.php");
	include_once(dirname(__FILE__)."/session_manager.php");
	
	$login_name = CSessionManager::Get(CSessionManager::STR_LOGIN_NAME);
	
	// -----------------------------------------------------------------------------
	// By default show CKEditor, on pages it's not required make this variable FALSE
	// -----------------------------------------------------------------------------
	$bShowCKEditor = TRUE;
	// -----------------------------------------------------------------------------
	
	$logged_in = FALSE;
	$logo_name  = CConfig::SNC_SITE_NAME;
	
	$punch_line = CConfig::SNC_PUNCH_LINE;
	
	$logo_image = sprintf("<img src='%s/images/quizus-beta-small-logo.png' style='width: %spx; height: %spx;'/>", CSiteConfig::ROOT_URL, CConfig::OL_WIDTH, CConfig::OL_HEIGHT);
	
	if($login_name != null)
	{
		$objUM = new CUserManager();
		$OrgInfo = $objUM->GetOrgInfoFromLoginName($login_name);
		
		if($OrgInfo != -1 && !empty($OrgInfo['logo_image']))
		{
			$logo_image = sprintf("<img src='%s/test/lib/print_image.php?org_logo_img=%s' style='width: %spx; height: %spx;'/>", CSiteConfig::ROOT_URL, $OrgInfo['organization_id'], CConfig::OL_WIDTH, CConfig::OL_HEIGHT);
		}
		else if($OrgInfo != -1 && !empty($OrgInfo['logo_name']))
		{
			$logo_name  = $OrgInfo['logo_name'];
			//$punch_line = $OrgInfo['punch_line'];
		}
	}
	
	$login = CSessionManager::Get(CSessionManager::BOOL_LOGIN);
	if($login)
	{
		$logged_in = true;
	}
?>
	<!-- McAfee Right Bottom Scurity Logo --> 
	<!-- <script type="text/javascript" src="https://cdn.ywxi.net/js/1.js" async></script>-->
	<script type="text/javascript">
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-2246912-20', 'auto');
	  ga('send', 'pageview');
	</script>
	
	<div id='header' class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" style="<?php echo(!empty($logo_image)?"padding-top: 5px;" : "");?>width: 200px;text-decoration: none;outline : none;" href="<?php echo (CSiteConfig::ROOT_URL.'/');?>"><?php echo(!empty($logo_image)?$logo_image : "<b>".$logo_name."</b>");?></a>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav">
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown">About <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/company/about-us.php">About Us</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/company/partner-orgs.php">Test Providers</a></li>
					</ul></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown">Features <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/features/candidate-management.php">Candidate Management</a></li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/features/knowledge-base-management.php">Question Management</a></li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/features/test-design-and-managment.php">Test Design &amp; Management</a></li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/features/test-scheduling-and-monitoring.php">Test Scheduling &amp; Monitoring</a></li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/features/result-analytics.php">Result Analytics</a></li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/features/batch-management.php">Batch Management</a></li>
							<li class="alert-danger"><a href="<?php echo CSiteConfig::ROOT_URL;?>/features/publish-and-promote.php">Publish &amp; Promote&nbsp;&nbsp;<i class="icon-broadcast"></i></a></li>
						</ul></li>
					<?php 
						/*
						<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/pricing.php">Pricing</a></li>
						<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/subdomain/support/index.php">Support</a></li>
						*/
					?>
					<li><a href="https://groups.google.com/forum/#!forum/quizus" target="_blank">Support Forum</a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown">Help &amp; FAQ <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="dropdown-header">Help Manual</li>							
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/help-and-faq/help-manual/gs_help_corp.php">for Organization</a></li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/help-and-faq/help-manual/gs_help_candidate.php">for Candidate</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Frequently Asked Questions</li>							
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/help-and-faq/faq/corp_faq.php">Organization F.A.Q.</a></li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/help-and-faq/faq/indv_faq.php">Candidate F.A.Q.</a></li>
						</ul></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown">Terms of Use <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="dropdown-header">Terms &amp; Privacy</li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/terms/terms-of-service.php">Terms of Service</a></li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/terms/privacy_policy.php">Privacy Policy</a></li>
							<?php
							/*
							<li class="divider"></li>
							<li class="dropdown-header">Dossier We Sign</li>
							<li><a target="_blank" href="<?php echo CSiteConfig::ROOT_URL;?>/terms/EZeeAssess-SLA-v2.pdf">Service Level Agreement <span class="badge"><i class="icon-file-pdf alert-danger"></i></span></a></li>
							<li class="disabled"><a href="<?php echo CSiteConfig::ROOT_URL;?>/terms/non-disclosure-agreement.php">Non-Disclosure Agreement (Client provided)</a></li>
							*/
							?>
						</ul></li>
						<li>
							<form class="navbar-form navbar-left" action="<?php echo CSiteConfig::ROOT_URL;?>/search-results.php" method="post">
								<input type="text"  name="search_text" class="form-control" placeholder="Search Tests ..."/>
								<i style="margin-top: 18px; margin-right:10px" class="fa fa-search form-control-feedback" aria-hidden="true"></i>
								<input type="hidden" name="search_category" value="keywords"/>
		    				</form>
	    				</li>
					<?php
					/*
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown">Company <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/company/about-us.php">About Us</a></li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/company/our-story.php">Our Story</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/company/contact-us.php">Contact Us</a></li>
						</ul></li>
					*/
					?>
				</ul>
				
    			<ul class="nav navbar-nav navbar-right">
    			<?php 
				if(!$logged_in)
				{
				?>
					<!-- <li><a href="<?php echo CSiteConfig::FREE_ROOT_URL;?>">Free Practice Tests</a></li> -->
					<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/login/register-org.php" class="btn btn-primary">Publisher Sign-up!</a></li>
					<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/signin.php" class="btn btn-danger">Sign-in</a></li>
				<?php 
				}
				else 
				{
				?>
					<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/core/dashboard.php"><span class="badge">My Home <i
								class="icon-home"></i></span></a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"><span class="badge">Logout <i
								class="icon-user"></i></span> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="dropdown-header"><?php echo CSessionManager::Get(CSessionManager::STR_EMAIL_ID);?></li>
							<li><a href="<?php echo CSiteConfig::ROOT_URL;?>/login/logout.php">Logout</a></li>
						</ul></li>
				<?php 
				}
				?>
				</ul>
			</div>
		</div>
	</div>
