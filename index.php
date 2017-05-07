<!doctype html>
<?php
//header("Location: http://practice.quizus.co"); /* Redirect browser */
//exit();

include_once (dirname ( __FILE__ ) . "/lib/include_js_css.php");
include_once (dirname ( __FILE__ ) . "/lib/session_manager.php");
include_once (dirname ( __FILE__ ) . "/lib/site_config.php");
include_once (dirname ( __FILE__ ) . "/lib/utils.php");
include_once (dirname ( __FILE__ ) . "/database/config.php");
include_once (dirname ( __FILE__ ) . "/3rd_party/recaptcha/recaptchalib.php");

$page_id = CSiteConfig::HF_INDEX_ID;
$login = CSessionManager::Get ( CSessionManager::BOOL_LOGIN );

$parsAry = parse_url ( CUtils::curPageURL () );
$qry = split ( "[=&]", $parsAry ["query"] );

/*
 * if($login) { CUtils::Redirect("core/dashboard.php"); } else
 * if(CSiteConfig::DEBUG_SITE == true && stristr($parsAry["host"],
 * strtolower(CConfig::SNC_SITE_NAME).".com") == FALSE) { if($qry[0] != "debug"
 * && $qry[1] != "639") { CUtils::Redirect(CSiteConfig::ROOT_URL, true); } }
 */

$login_name = $_GET ['ln'];
if (! empty ( $login_name )) {
	CSessionManager::Set ( CSessionManager::STR_LOGIN_NAME, $login_name );
} else if (! $login) {
	CSessionManager::UnsetSessVar ( CSessionManager::STR_LOGIN_NAME );
}

$objIncludeJsCSS = new IncludeJSCSS ();
?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="Generator" content="">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo(CConfig::SNC_SITE_NAME." - ".CConfig::SNC_PUNCH_LINE);?></title>
<?php
$objIncludeJsCSS->CommonIncludeCSS ( "" );
$objIncludeJsCSS->IncludeTVCSS ( "" );
$objIncludeJsCSS->IncludeMipcatCSS ( "" );
$objIncludeJsCSS->IncludeIconFontCSS( "" );
$objIncludeJsCSS->CommonIncludeJS ( "" );
?>
		<!-- CSS -->

        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/responsive.css">
		<link rel="icon" href="images/gini-favicon.png" type="image/png">
        

        <!-- Js -->
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
        <script src="js/wow.min.js"></script>
		<script src="js/mipcat/utils.js"></script>
        <script>
         new WOW(
            ).init();
        </script>
</head>
<body>

	<?php
	include_once (dirname ( __FILE__ ) . "/lib/header.php");
	$bShowCKEditor = FALSE;
	?>
	
	<!-- ************************* -->
	
	<section id="banner" class="wow fadeInUp">
		<div class="container">
	        <div class="row">
	            <div class="col-lg-3 col-md-3 col-sm-3">
	            	<div class="drop-shadow">
	            		<a href="search-results.php?category-name=banking+insurance+sector+exams&category-id=8932900"><img class="app-img img-responsive" src="images/home/banking-mini.jpg" alt=""/>
	            		<br/>
	            		<h5 class="text-center">Banking &amp; Insurance Exams</h5></a>
	            	</div>
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3">
	            	<div class="drop-shadow">
	            		<a href="search-results.php?category-name=government+sector+exams&category-id=8932900"><img class="app-img img-responsive" src="images/home/government-mini.jpg" alt=""/>
	            		<br/>
	            		<h5 class="text-center">Government Sector Exams</h5></a>
	            	</div>
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3">
	            	<div class="drop-shadow">
	            		<a href="search-results.php?category-name=engineering+entrance+exams&category-id=8932900"><img class="app-img img-responsive" src="images/home/engineering-mini.jpg" alt=""/>
	            		<br/>
	            		<h5 class="text-center">Engineering Entrance Exams</h5></a>
	            	</div>
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3">
	            	<div class="drop-shadow">
	            		<a href="search-results.php?category-name=medical+entrance+exams&category-id=8932900"><img class="app-img img-responsive" src="images/home/medical-mini.jpg" alt=""/>
	            		<br/>
	            		<h5 class="text-center">Medical Entrance Exams</h5></a>
	            	</div>
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3">
	            	<div class="drop-shadow">
	            		<a href="search-results.php?category-name=mba+entrance+exams&category-id=8932900"><img class="app-img img-responsive" src="images/home/mba-mini.jpg" alt=""/>
	            		<br/>
	            		<h5 class="text-center">MBA Entrance Exams</h5></a>
	            	</div>
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3">
	            	<div class="drop-shadow">
	            		<a href="search-results.php?category-name=campus+recruitment+preparation+exams&category-id=8932900"><img class="app-img img-responsive" src="images/home/campus-mini.jpg" alt=""/>
	            		<br/>
	            		<h5 class="text-center">Campus Preparation</h5></a>
	            	</div>
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3">
	            	<div class="drop-shadow">
	            		<a href="search-results.php?category-name=diploma+preparation+exams&category-id=8932900"><img class="app-img img-responsive" src="images/home/diploma-mini.jpg" alt=""/>
	            		<br/>
	            		<h5 class="text-center">Diploma Preparation</h5></a>
	            	</div>
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3">
	            	<div class="drop-shadow">
	            		<a href="search-results.php?category-name=miscellaneous+exam+preparation+exams&category-id=8932900"><img class="app-img img-responsive" src="images/home/misc-mini.jpg" alt=""/>
	            		<br/>
	            		<h5 class="text-center">Misc Preparation</h5></a>
	            	</div>
	            </div>
            </div>
        </div>
    </section>


	<section id="service">
        <div class="container">
            <div class="service-wrapper">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="block wow fadeInRight" data-wow-delay="0.1s" onclick="location.href='./features/test-design-and-managment.php';">
                            <div class="icon">
                               <i class="icon-search"></i> 
                            </div>
                            
                            <h3>Self Service</h3>
                            <p>Just create your login and start using, you don't need special skills to use <?php echo(CConfig::SNC_SITE_NAME); ?>. Just follow help instructions and you are good to go.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="block wow fadeInRight" data-wow-delay="0.3s" onclick="location.href='./features/publish-and-promote.php';">
                            <div class="icon">
                                <i class="icon-support"></i>
                            </div>
                            <h3>User Friendly Design</h3>
                            <p>We have designed <?php echo(CConfig::SNC_SITE_NAME); ?> in such a way that you don't need to get dependent on anyone to get your tasks done. Simply create tests and deploy, we will do the rest.</p>
                        </div>
                    </div>                    
                     <div class="col-md-3 col-sm-6">
                        <div class="block wow fadeInRight" data-wow-delay="0.5s" onclick="location.href='<?php echo(CSiteConfig::FREE_ROOT_URL); ?>';">
                            <div class="icon">
                                <i class="icon-laptop"></i>
                            </div>
                            <h3>Practice Tests</h3>
                            <p>We allow publishers to publish &frasl; sell practice tests and let the walk-in user/visitor attempt it. This provision is to market yourself to visitors. You will know more once you publish a practice test.</p>
                        </div>
                    </div>
					<div class="col-md-3 col-sm-6">
                        <div class="block wow fadeInRight" data-wow-delay="0.7s" onclick="window.open('https://groups.google.com/forum/#!forum/quizus', '_blank').focus();">
                            <div class="icon">
                                <i class="icon-mail"></i>
                            </div>
                            <h3>Support Forum</h3>
                            <p>We are forum driven, if you need help then join Quizus's Google Group and we shall help you there. </p>
                        </div>
						<br/><p class="block wow fadeInRight" data-wow-delay="1.2s">Wana know if <?php echo(CConfig::SNC_SITE_NAME); ?> is covered in your use case?<!--  Watch two mins video. --><br/>Scroll down <i class="icon-arrow-down"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

  <!--  <section id="utility">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-8 wow fadeInUp" data-wow-delay="0.2s">
					<div id="TVcontainer" class="drop-shadow">
						<div class="outerEdge">
							<div class="outerBox">
								<div class="TVscreen">
									<div id="theVideo" class="text-center">
										<iframe width="100%" height="100%"
											src="//www.youtube.com/embed/c7bGwsT1e0E?rel=0"
											frameborder="0" allowfullscreen></iframe>
									</div>
								</div>
								<h1 class="TVname">QUIZUS</h1>
							</div>
						</div>
						<div class="glare"></div>
						<div class="post"></div>
						<div class="base"></div>
					</div>
                </div>
                <div class="col-md-4 col-sm-4 wow fadeInDown" data-wow-delay="0.2s">
                    <div class="block">
                        <h2><?php echo(CConfig::SNC_SITE_NAME); ?> Use Cases</h2>
                        <p>
                            Just sit back and relax, let us navigate you through most popular use cases of <?php echo(CConfig::SNC_SITE_NAME); ?>. That includes but no limited to Quizes, Subject Knowledge Evaluation, Training Assessment, Compliance Assessment, Campus Recruitment, Lateral Hiring, Professional Cources Entrance Examination and Product Knowledge Test etc.<br/>
							<br/>Still wana know more, okay scroll down <i class="icon-arrow-down"></i>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section> -->


	<section id="feature">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 wow fadeInRight" data-wow-delay="0.2s">
                    <h2 class="title">Our Focus on Features</h2>

                    <div class="feature-item">

                        <div class="media">
                            <div class="pull-left icon" href="#">
                                <i class="icon-satellite"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Reliable and International Platform</h4>
                                <p>We have engineered <?php echo(CConfig::SNC_SITE_NAME); ?> in a way that it fullfills demand of all geographies by supporting 99 most spoken languages of the world. <a href="./features/knowledge-base-management.php">Click here to know more</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="feature-item">

                        <div class="media">
                            <div class="pull-left icon" href="#">
                                <i class="icon-grid"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Everything is perfectly orgainized</h4>
                                <p>With elegant UI and simple navigation we have made sure that nothing looses your eye sight. The UI and product navigation is designed considering ease for users. <a href="./help-and-faq/help-manual/gs_help_corp.php">Click here to know more</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="feature-item">

                        <div class="media">
                            <div class="pull-left icon" href="#">
                                <i class="icon-book"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Easiest Test Designing and Scheduling</h4>
                                <p>We would like to call it a 2 minute utility to design any kind of objective test on the fly followed with simple steps (through wizard). It has all that you need to design an quiz / test, in fast, robust and reliable manner. <a href="./features/test-design-and-managment.php">Click here to know more</a>.</p>
                            </div>
                        </div>
                    </div>

					<div class="feature-item">

                        <div class="media">
                            <div class="pull-left icon" href="#">
                                <i class="icon-stats-up"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Best in class analytics</h4>
                                <p>With our result data analytics you can get the visual plots via charts - that illustrates candidate's over all performance in assessment/test. Not to mention that we understand the requirement of PDF export and that is included. <a href="./features/result-analytics.php">Click here to know more</a>.</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 col-sm-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="block drop-shadow">
                        <img class="img-responsive" src="images/home/international.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="utility-2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="block">
                        <h2><?php echo(CConfig::SNC_SITE_NAME); ?> Question Database</h2>
                        <p>
                            We have comunity questions database which consists of question on various subjects and topics. You can use them to start with or use your own questions. If you are interested to donate questions, please contact us on support forum.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 wow fadeInRight" data-wow-delay="0.2s">
					<div class="drop-shadow">
						<img class="img-responsive" src="images/home/data_processing.jpg" alt="">
					</div>
                </div>
            </div>
        </div>
    </section>


    <section id="subscribe" >
        <div class="container">
            <div class="row">
                <div class="col-md-12 wow fadeInDown" data-wow-delay="0.3s">
                    <div class="block">
                        <div class="title text-center">
                            <h2>Still Thinking</h2>
                            <p>Let us know your email-id and we will send you updates, yes we are desperate to have you with us!</p>
                        </div>
                        <div id="stay-connected-div">
							<form id="stay-connected" class="form-inline text-center col-sm-12 col-xs-12" role="form" onsubmit="return stay_connected();">
								<div class="form-group">
									<input type="text" class="form-control" id="signup-form" name="email" placeholder="Your email-id ..." >
								</div>
								<a href="javascript:stay_connected();" class="btn btn-default btn-signup">
									<i class="icon-rocket"></i>
								</a>
							</form>
						</div>
                    </div>
                    

                </div>
            </div>
        </div>
    </section>

    <footer class="wow fadeInUp" data-wow-delay="0.3s">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                        <a class="footer-logo"href="#">
                            <img class="img-responsive" src="images/quizus-logo.png" width="100%" height="100%" alt="Pocket Gini">
                        </a>
                    <p><?php include ("lib/footer.php"); ?></p>
                    
                </div>
            </div>
        </div>
    </footer>
	<script type="text/javascript">
		function stay_connected()
		{
			return objUtils.stay_connected();
		}
		
		$(".icon-home").addClass("glyphicon");
		$(".icon-home").addClass("glyphicon-home");
	
		$(".icon-user").addClass("glyphicon");
		$(".icon-user").addClass("glyphicon-user");
	</script>
</body>
</html>
