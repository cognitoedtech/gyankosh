 <!doctype html>
 <?php
 	include_once(dirname(__FILE__)."/../lib/session_manager.php");
 	include_once(dirname(__FILE__)."/../lib/utils.php");
 	include_once('../database/mcat_db.php');
 	include_once("../lib/include_js_css.php");
 	include_once("lib/tbl_result.php");
 	include_once("lib/test_helper.php");
 	
	// - - - - - - - - - - - - - - - - -
	// On Session Expire Load ROOT_URL
	// - - - - - - - - - - - - - - - - -
	//CSessionManager::OnSessionExpire();
	// - - - - - - - - - - - - - - - - -
	
 	$objDB = new CMcatDB();
	
	$bFreeEZeeAssesUser = CSessionManager::Get(CSessionManager::BOOL_FREE_EZEEASSESS_USER);
	
	$objIncludeJsCSS = new IncludeJSCSS();
	
	$sUserID = "";
	$style="";
	
	$test_rating_score = 0;
	if($bFreeEZeeAssesUser == 1)
	{
		$style = "style=''";
		$sUserID = $_COOKIE[CConfig::FEUC_NAME];
		printf("<script type='text/javascript'> var bIsFree = true;  </script>");
		
		if(isset($_COOKIE["already_rated_tests"]))
		{
			$rated_test_id_ary = explode(",",$_COOKIE["already_rated_tests"]);
				
			$bAlreadyRated = false;
			foreach($rated_test_id_ary as $rating)
			{
				$rating_ary = explode(";", $rating);
				if(in_array($_GET['test_id'], $rating_ary))
				{
					$bAlreadyRated = true;
					$test_rating_score = $rating_ary[1];
					break;
				}
			}
		
			if(!$bAlreadyRated)
			{
				printf("<script type='text/javascript'> var bIsTestRated = false;  </script>");
			}
			else
			{
				printf("<script type='text/javascript'> var bIsTestRated = true;  </script>");
			}
		}
		else
		{
			printf("<script type='text/javascript'> var bIsTestRated = false;  </script>");
		}
	}
	else 
	{
		$style="style='display:none;'";
		$sUserID = CSessionManager::Get(CSessionManager::STR_USER_ID);
		printf("<script type='text/javascript'> var bIsFree = false;  </script>");
	}
	
	$parsAry = parse_url(CUtils::curPageURL());
	$qry = split("[=&]", $parsAry["query"]);
	
	$objTR = new CResult();
	$objTH = new CTestHelper();
	
	$nTestID = null;
	if($qry[0] == "test_id")
	{
		$nTestID = $qry[1];
	}
	
	$nTschdID = null;
	if($qry[2] == "tschd_id")
	{
		$nTschdID = $qry[3];
	}
	
	$test_type = $objDB->GetTestType($nTestID);
	$test_pnr = $objTH->EndExam($sUserID, $nTestID, $nTschdID);
	$res_visibility = $objTH->GetResultVisibility($nTestID);
	
	if($test_type == CConfig::TT_DEFAULT)
	{
		$ResultAry = $objTR->GetResult($test_pnr);
	}
	else if($test_type == CConfig::TT_EQ)
	{
		$ResultAry = $objTR->GetResult($test_pnr, CConfig::TT_EQ);
	}
	
	$test_name = $objDB->GetTestName($nTestID);
	
	printf("<script>var rslt_visibility=%d;</script>", $res_visibility);
	
	/*echo "<pre>";
	print_r($ResultAry);
	echo "</pre>";*/
 ?>
<html>
 <head>
  <title> Exam Ended </title>
  <meta name="Generator" content="Mastishka Intellisys Private Limited">
  <meta name="Author" content="Mastishka Intellisys Private Limited">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
	<?php 
		$objIncludeJsCSS->CommonIncludeCSS ( "../" );
		$objIncludeJsCSS->IncludeFuelUXCSS ( "../" );
		$objIncludeJsCSS->CommonIncludeJS ("../");
		$objIncludeJsCSS->IncludeCanvasMinJS ("../");
		$objIncludeJsCSS->IncludeJqueryFormJS("../");
		$objIncludeJsCSS->IncludeJqueryValidateMinJS("../");
		$objIncludeJsCSS->IncludeJqueryRatyJS("../");
	?>
	
	<style type="text/css">
		.modal1 {
			display:    none;
			position:   fixed;
			z-index:    1000;
			top:        50%;
			left:       50%;
			height:     100%;
			width:      100%;
		}
		
	.modal, .modal.fade.in {
	    top: 15%;
	}
 	</style>
 </head>

<body>
	<?php
  		$CorrectAns = 0;
		$WrongAns   = 0;
		$Unanswered	= 0;
		
		if($test_type == CConfig::TT_DEFAULT)
		{
			foreach ($ResultAry as $sectionName => $SectionAry)
			{
				foreach ($SectionAry as $subjectName => $SubjectAry)
				{
					foreach ($SubjectAry as $topicName => $TopicAry)
					{
						foreach ($TopicAry as $difficulty => $QuestionAry)
						{
							foreach ($QuestionAry as $QuestionIdx => $Answer )
							{
								if($Answer == 0)
								{
									$WrongAns++;
								}
								else if($Answer == 1)
								{
									$CorrectAns++;
								}
								else if($Answer == -1 || $Answer == -2)
								{
									$Unanswered++;
								}
							}
						}
					}
				}
			}	
		}
		else if($test_type == CConfig::TT_EQ)
		{
			$CorrectAns = $ResultAry['attempted'];
			$Unanswered = $ResultAry['unattempted'];
		}
?>
	<div style="color:white;font-weight:bold;background-color:CornflowerBlue;padding:10px 10px;margin: 5px;" id="header">
		<input type="button" id="btn_end_exam" class="btn btn-xs btn-danger" value="Close (X)" style="font-weight:bold;float: right;"/><span>Test: <?php echo $test_name; ?></span>
	</div>
	<?php 
		$total_questions = $CorrectAns+$WrongAns+$Unanswered;
		if($res_visibility != CConfig::RV_NONE)
		{
			echo ("<span id='span_result_summary'>You answered ".$CorrectAns." correct answers and ".$WrongAns." wrong answers out of ".($CorrectAns+$WrongAns+$Unanswered).".</span><br />");
		}
		else
		{
			echo ("<span id='span_result_summary'>You attempted ".($CorrectAns+$WrongAns)." questions out of ".($CorrectAns+$WrongAns+$Unanswered).".</span><br />");
		}
	?>
	<div class="row-fluid">
		<div class="fuelux modal1">
			<div class="preloader"><i></i><i></i><i></i><i></i></div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4">
			<div id="chart1" style="height:250px;" <?php $res_visibility != 0?>></div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
			<fieldset id="information_form_fieldset" <?php echo($style);?>>
				<legend style="color:CornflowerBlue;"><b>Provide information to get detailed result:</b></legend>
				<div id="response_div" style="text-align: center"></div><br />
				<div class="col-lg-6 col-md-6 col-sm-6" style="border-right: 1px solid #ddd;">
					<p style="color:blue;">New User?</p>
					<form id='free_user_registration' class="form-horizontal">
						<div class="form-group">
					      <div class="col-lg-10">
					        <input class="form-control input-sm" name="name" id="name" placeholder="Name" type="text">
					      </div>
					    </div>
					    <div class="form-group">
					      <div class="col-lg-10">
					        <input class="form-control input-sm" name="email" id="email" placeholder="Email" type="text">
					      </div>
					    </div>
					    <div class="form-group">
					      <div class="col-lg-10">
					        <input class="form-control input-sm" name="phone" id="phone" placeholder="Phone#" type="text">
					      </div>
					    </div>
					    <div class="form-group">
					      <div class="col-lg-10">
					        <input class="form-control input-sm" name="city" id="city" placeholder="City" type="text">
					      </div>
					    </div>
					    <div class="form-group">
					      <div class="col-lg-8">
					        <input class="form-control input-sm" name="captch_value" id="captch_value" placeholder="Verification Text" type="text">
					      </div>
					      <div class="col-lg-4">
					      	<img id="captcha_img" src="../3rd_party/captcha/captcha.php">
					      </div>
					    </div>
					    <input type="hidden" name="new_free_user" value='1' />
					    <div class="form-group">
					      <div class="col-lg-10">
					        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
					      </div>
					    </div>
					</form>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<p style="color:green;">Already attempted earlier?</p>
					<form id='email_submit_form' class="form-horizontal">
						 <div class="form-group">
					      <div class="col-lg-10">
					        <input class="form-control input-sm" name="email" id="email" placeholder="Email" type="text">
					      </div>
					    </div>
					    <input type="hidden" name="existing_free_user" value='1' />
					    <div class="form-group">
					      <div class="col-lg-10">
					        <button type="submit" class="btn btn-sm btn-success">Submit</button>
					      </div>
					    </div>
					</form>
				</div>
			</fieldset>
		</div>
		
		<div class="modal" id="dlg_rate_test" data-backdrop="static" data-keyboard="false">
		  	<div class="modal-dialog">
		    	<div class="modal-content">
		      		<div class="modal-header">
		       		 	<button type="button" class="close rate_test_close" disabled='disabled' data-dismiss="modal" aria-hidden="true">&times;</button>
		        		<h4 class="modal-title" id="test_rating_heading">Rate This Test</h4>
		      		</div>
			      	<div class="modal-body" id="options_body">
			      		<div id="test_ratings"></div>
			      	</div>
		      		<div class="modal-footer">
			        	<button type="button" class="btn btn-default rate_test_close" disabled='disabled' data-dismiss="modal">Close</button>
		      		</div>
		    	</div>
		  	</div>
		</div>
		
	</div>
    <script class="code" type="text/javascript">

    if(bIsFree)
	{
		if(bIsTestRated)
		{
			 $("#test_rating_heading").html("You have already rated following");
			 $(".rate_test_close").removeAttr('disabled');
			 $('#test_ratings').raty({ 
				 readOnly: true, 
				 score: <?php echo($test_rating_score);?>,
				 half      : true,
				 size      : 24,
				 starHalf  : '../3rd_party/raty/demo/img/star-half-big.png',
				 starOff   : '../3rd_party/raty/demo/img/star-off-big.png',
				 starOn    : '../3rd_party/raty/demo/img/star-on-big.png' 
			 });
		}
		else
		{
			$("#test_ratings").raty({
			    half      : true,
			    size      : 24,
			    starHalf  : '../3rd_party/raty/demo/img/star-half-big.png',
			    starOff   : '../3rd_party/raty/demo/img/star-off-big.png',
			    starOn    : '../3rd_party/raty/demo/img/star-on-big.png',
			    click: function(score) {
			        $(".rate_test_close").removeAttr('disabled');
			        bIsTestRated = true;
			        $(this).find('img').unbind();
			        $.post("ajax/ajax_rate_test.php",{'test_id':'<?php echo($nTestID);?>', 'score': score}, function(){
				        
				    });
			    }
			});	
		}
	}

    $("#btn_end_exam").click(function(){
    	if(!bIsFree)
			parent.HideOverlay();
		else										
			 window.parent.postMessage("HideOverlay", "<?php echo(CSiteConfig::FREE_ROOT_URL); ?>");
	});

    function ShowTestRating()
	{
		$('#dlg_rate_test').modal("show");
	}
	<?php 
	if($bFreeEZeeAssesUser == 1)
	{
	?>
    ShowTestRating();
    <?php 
	}
    ?>
    jQuery.validator.addMethod("ValidatePhoneNumber", function(value, element) {
	
    	if(value == "9999999999" || /^[0-6]/.test(value) || value == "7777777777" || value == "8888888888" || value == "987654321")
    	{
        	return false;
    	}
    	else
    	{
        	return true;
    	}
	}, "<span style='color:red;'>* Please enter a valid phone number</style>");

    var counter = 20;
    var time_out;
    function timedCount()
    {
	    $("#timer").text(counter+"");
	    counter = counter-1;
	    if(counter == 0)
	    {
	    	if(!bIsFree)
				parent.HideOverlay();
			else										
				 window.parent.postMessage("HideOverlay", "<?php echo(CSiteConfig::FREE_ROOT_URL); ?>");
		}
	    time_out = setTimeout(function(){timedCount()},1000);
    }

    function showResponse(responseText, statusText, xhr, form)
	{
    	$(".modal1").hide();
    	$.each(responseText, function(key,value){
        	if(key == "error")
        	{
        		$("#response_div").html(value);	
        	}
        	else if(key == "success")
        	{
            	$("#chart1").hide();
            	$("#information_form_fieldset").hide();
            	$("#span_result_summary").html("Detailed result has been sent successfully on your EMail Id. This window will be closed automatically just after <b><span id='timer'>"+counter+"</span> seconds</b>.");
            	timedCount();
            }
        });
   	 	$("#captcha_img").attr("src","../3rd_party/captcha/captcha.php?r=" + Math.random());
	}

	function handleError(xhr, status, ex)
	{
		$(".modal1").hide();
		$("#response_div").html("<span style='color:red;'>Request Error: "+ex.toString()+"</span>");
		//alert(xhr.responseText);
	}

    var time_zone = get_time_zone_offset( );
    var options = { 
    	    data: {'test_id': '<?php echo($nTestID);?>', 'test_pnr' : '<?php echo($test_pnr);?>', 'time_zone' : time_zone},
       	 	//target:        '',   // target element(s) to be updated with server response 
       		// beforeSubmit:  showRequest,  // pre-submit callback 
      	 	 success:       showResponse,  // post-submit callback 
			 error:         handleError,
 
        	// other available options: 
        	url:      'ajax/ajax_free_user_result.php',         // override for form's 'action' attribute 
        	type:      'POST',       // 'get' or 'post', override for form's 'method' attribute 
        	dataType:  'json',        // 'xml', 'script', or 'json' (expected server response type) 
        	clearForm: false        // clear all form fields after successful submit 
        	//resetForm: true        // reset the form after successful submit 
 
        	// $.ajax options can be used here too, for example: 
        	//timeout:   3000 
    	}; 
	$(document).ready(function(){
		<?php 
		if($res_visibility != CConfig::RV_NONE && $test_type != CConfig::TT_EQ)
		{
		?>

		CanvasJS.addColorSet("customColors",
				[//colorSet Array

				 	"#4bb2c5",
	                "#eaa228",
	                "#c5b47f"               
	            ]);

		var chart = new CanvasJS.Chart("chart1", {
			  colorSet: "customColors",
			  axisX:{
				  labelFontSize: 15,
			  },
			  axisY:{
				  labelFontSize: 15,
			  },
		      data: [//array of dataSeries              
		        { //dataSeries object

		         /*** Change type "column" to "bar", "area", "line" or "pie"***/
		         type: "column",
		         dataPoints: [
		         { label: "Correct", y: <?php echo($CorrectAns);?>},
		         { label: "Wrong", y: <?php echo($WrongAns);?>},
		         { label: "Unanswered", y: <?php echo($Unanswered);?>}
		         ]
		       }
		       ]
		     });

		    chart.render();
		<?php 
		}
		else 
		{
		?>
		CanvasJS.addColorSet("customColors",
				[//colorSet Array

				 	"#4bb2c5",
	                "#eaa228"               
	            ]);

		var chart = new CanvasJS.Chart("chart1", {
			  colorSet: "customColors",
			  axisX:{
				  labelFontSize: 15,
			  },
			  axisY:{
				  labelFontSize: 15,
			  },
		      data: [//array of dataSeries              
		        { //dataSeries object

		         /*** Change type "column" to "bar", "area", "line" or "pie"***/
		         type: "column",
		         dataPoints: [
		         { label: "Answered", y: <?php echo($CorrectAns+$WrongAns);?>},
		         { label: "Unanswered", y: <?php echo($Unanswered);?>}
		         ]
		       }
		       ]
		     });

		    chart.render();
		<?php
		}
		?>
		});

		$("#free_user_registration").validate({
        	rules: {

        		name: {
                 required: true,
                 minlength: 2
             },
            	email: {
                	required: true,
                	email: true
            	},
            	phone:{
                	required:true,
               	 	number: true,
                  	minlength: 10,
                  	maxlength: 10,
                  	'ValidatePhoneNumber' : true
            		
            	},
           		city:"required",
           		captch_value:"required"

        	},
        	messages: {
        		name: 	{
        			required:	"<span style='color:red;'>* Please enter your name</span>",
           		 	minlength:	"<span style='color:red;'>* Minimum length of name should be 2</span>"
            		},
            		email: 	{
            			email:	"<span style='color:red;'>* Please enter a valid email address</span>",
               		 	required:	"<span style='color:red;'>* Please enter the email address</span>"
                		},

            	city: 			"<span style='color:red;'>* Please enter your city name</span>",
            	captch_value:	"<span style='color:red;'>* Please enter the code shown in image</span>",

            	phone:{
           		 	required:	"<span style='color:red;'>* Please enter your phone no.</span>",
            	 	number:		"<span style='color:red;'>* Phone number must contain digits only</span>",
            	 	minlength:	"<span style='color:red;'>* Minimum length of phone no. should be 10</span>",
            	 	maxlength:	"<span style='color:red;'>* Maximum length of phone no. should be 10</span>"
            	}
        	},
        
        	submitHandler: function(form) {
        		$(".modal1").show();
    			$('#free_user_registration').ajaxSubmit(options);
        	}
    	});

		$("#email_submit_form").validate({
        	rules: {

        		email: {
                	required: true,
                	email: true
            	}
        	},
        	messages: {
        		email: 	{
        			email:	"<span style='color:red;'>* Please enter a valid email address</span>",
           		 	required:	"<span style='color:red;'>* Please enter the email address</span>"
            		}
        	},
        
        	submitHandler: function(form) {
        		$(".modal1").show();
        		$('#email_submit_form').ajaxSubmit(options);
        	}
    	});

	function get_time_zone_offset( ) 
	{
	    var current_date = new Date();
	    return -current_date.getTimezoneOffset() / 60;
	}
	</script>
	<div class="modal1"></div>
 </body>
</html>
