<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
include_once (dirname ( __FILE__ ) . "/../../lib/session_manager.php");
include_once (dirname ( __FILE__ ) . "/../../database/mcat_db.php");
include_once (dirname ( __FILE__ ) . "/../../lib/user_manager.php");
include_once (dirname ( __FILE__ ) . "/../../lib/include_js_css.php");
include_once (dirname ( __FILE__ ) . "/../../lib/site_config.php");

// - - - - - - - - - - - - - - - - -
// On Session Expire Load ROOT_URL
// - - - - - - - - - - - - - - - - -
CSessionManager::OnSessionExpire ();
// - - - - - - - - - - - - - - - - -

$objDB = new CMcatDB ();
$objUM = new CUserManager ();

$user_id = CSessionManager::Get ( CSessionManager::STR_USER_ID );
$objUser = $objUM->GetUserById ( $user_id );
$billingInfo = $objUM->GetBillingInfo ( $user_id );

$user_type = CSessionManager::Get ( CSessionManager::INT_USER_TYPE );

if ($user_type == CConfig::UT_INDIVIDAL) {
	echo ("<script> var tab_id='tab2'; </script>");
} else {
	echo ("<script> var tab_id='tab1'; </script>");
}
$orgAry = $objUM->GetOrgInfo ( $objUser->GetOrganizationId () );

$objIncludeJsCSS = new IncludeJSCSS ();

$logoSrc = "../../images/product-details/boy-with-books.jpg";
if(!empty($orgAry[CUser::FIELD_LOGO_IMAGE]))
	$logoSrc = "../../test/lib/print_image.php?org_logo_img=".$objUser->GetOrganizationId();

$YouTubeURL = "https://www.youtube.com/watch?v=dqTTojTija8";
if(!empty($orgAry[CUser::FIELD_ORGANIZATION_YOUTUBE]))
	$YouTubeURL = $orgAry[CUser::FIELD_ORGANIZATION_YOUTUBE];

$index = 0;
$element = "";
$aryCourses = json_decode($orgAry['courses'], TRUE);
foreach($aryCourses as $sCourseName => $sCourseDesc)
{
	$element .= sprintf("<div class='input-group' id='ig-%d'>", $index);
	$element .= sprintf("<input type='text' value='%s' id='course_name_%d' value='' name='course_name[]' class='form-control' placeholder='Course Name'>", $sCourseName, $index);
	$element .= sprintf("<span class='input-group-addon'>");
	$element .= sprintf("<i class='fa fa-book' aria-hidden='true'></i>");
	$element .= sprintf("</span>");
	$element .= sprintf("<input type='text' value='%s' id='course_desc_%d' value='' name='course_desc[]' class='form-control' placeholder='Course Description'>", $sCourseDesc, $index);
	$element .= sprintf("<span class='input-group-addon'>");
	$element .= sprintf("<a href='#' elm='ig-%d' onclick='OnRemove(this);' class='btn-danger btn-sm'><i class='fa fa-times' aria-hidden='true'></i></a>", $index);
	$element .= sprintf("</span>");
	$element .= sprintf("</div>");
	
	$index++;
}

function YoutubeIdFromUrl($url) 
{
	$pattern =
	'%^# Match any youtube URL
	(?:https?://)?  # Optional scheme. Either http or https
	(?:www\.)?      # Optional www subdomain
	(?:             # Group host alternatives
	youtu\.be/    # Either youtu.be,
	| youtube\.com  # or youtube.com
	(?:           # Group path alternatives
	/embed/     # Either /embed/
	| /v/         # or /v/
	| /watch\?v=  # or /watch\?v=
	)             # End path alternatives.
	)               # End host alternatives.
	([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
	$%x'
	;
	$result = preg_match($pattern, $url, $matches);
	if ($result) {
		return $matches[1];
	}
	return false;
}

$menu_id = CSiteConfig::UAMM_MY_ACCOUNT;
$page_id = CSiteConfig::UAP_ABOUT_ORGANIZATION;
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
		$objIncludeJsCSS->IncludeClipboardJS ( "../../" );
		$objIncludeJsCSS->IncludeMetroNotificationJS ( CSiteConfig::ROOT_URL . "/" );
		?>
		<script src="https://apis.google.com/js/api.js" type="text/javascript"> </script>
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
		<div id="tab1" class="col-lg-9 col-sm-9col-md-9"
			style="border-left: 1px solid #ddd; border-top: 1px solid #ddd;">
			<br />
			<h4 class="text-center">
				<b>About Publisher</b> page details
			</h4>
			<br />
			<form class="form-horizontal" id="acnt_dtls"
				action="ajax/ajax_account_details.php?sec=3" method="POST"
				enctype="multipart/form-data">
				<div id="abt_org_form_content">
					<div class="col-lg-3 col-sm-3 col-md-3">
						<div class="row">
							<div class="col-lg-11 col-sm-11 col-md-11">
								<img id="img-upload" alt="" class="img-thumbnail img-responsive" 
									src="<?php echo($logoSrc);?>"/>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-lg-11 col-sm-11 col-md-11">
								<div class="form-group">
									<textarea id="organization_address" rows="3" 
										name="organization_address" class="form-control"
										placeholder="Address of the organization"><?php echo($orgAry['organization_address']);?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-11 col-sm-11 col-md-11">
								<div class="form-group">
									<input type="text" id="organization_phone"
										value="<?php echo($orgAry['organization_phone']);?>"
										name="organization_phone" class="form-control"
										placeholder="Phone"
										aria-describedby="organization_phone">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-11 col-sm-11 col-md-11">
								<div class="form-group">
									<input type="text" id="organization_email"
										value="<?php echo($orgAry['organization_email']);?>"
										name="organization_email" class="form-control"
										placeholder="Email"
										aria-describedby="organization_email">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-11 col-sm-11 col-md-11">
								<div class="form-group">
									<input type="text" id="organization_city"
										value="<?php echo($orgAry['organization_city']);?>"
										name="organization_city" class="form-control"
										placeholder="City"
										aria-describedby="organization_city">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-11 col-sm-11 col-md-11">
								<div class="form-group">
									<input type="text" id="organization_state"
											value="<?php echo($orgAry['organization_state']);?>"
											name="organization_state" class="form-control"
											placeholder="State"
											aria-describedby="organization_state">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-11 col-sm-11 col-md-11">
								<div class="form-group">
									<input type="text" id="organization_country"
											value="<?php echo($orgAry['organization_country']);?>"
											name="organization_country" class="form-control"
											placeholder="Country"
											aria-describedby="organization_country">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-11 col-sm-11 col-md-11">
								<div class="form-group">
									<input type="text" id="zip_code"
											value="<?php echo($orgAry['zip_code']);?>"
											name="zip_code" class="form-control"
											placeholder="Zip code"
											aria-describedby="zip_code">
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-9 col-sm-9 col-md-9">
						<div class="row">
							<div class="input-group">
								<span class="input-group-addon" id="about_publisher_span">Your <?php echo(CConfig::SNC_SITE_NAME);?> About 
									URL</span> <input type="text" readonly id="about_publisher"
									name="about_publisher" class="form-control"
									aria-describedby="about_publisher">
								<span class='input-group-addon'>
									<a href='#' id='copy_btn' class='btn-info btn-sm'
									data-clipboard-text=''>
									<i class='fa fa-copy' aria-hidden='true'></i></a>
								</span>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="input-group">
								<span class="input-group-addon" id="organization_name_span">Organization
									Name</span> <input type="text" id="organization_name"
									value="<?php echo($orgAry['organization_name']);?>"
									name="organization_name" class="form-control"
									placeholder="Organization Name"
									aria-describedby="organization_name">
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="input-group">
								<span class="input-group-addon" id="organization_url_span">Organization
									URL</span> <input type="text" id="organization_url"
									value="<?php echo($orgAry['organization_url']);?>"
									name="organization_url" class="form-control"
									placeholder="http://www.your-organization.com"
									aria-describedby="organization_url">
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="input-group">
								<span class="input-group-addon" id="youtube_videos_span">Youtube 
									URL</span> <input type="text" id="youtube_videos"
									value="<?php echo($YouTubeURL);?>"
									name="youtube_videos" class="form-control"
									placeholder="<?php echo($YouTubeURL);?>"
									aria-describedby="youtube_videos">
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="input-group">
								<span class="input-group-addon" id="organization_img_span">Organization
									Logo</span>
								<input type="text" class="form-control" readonly> <span
									class="input-group-btn"> <span class="btn btn-default btn-file">
										Browse <i class="fa fa-file-image-o" aria-hidden="true"></i> <input
										type="file" accept="image/gif, image/jpeg, image/png"
										id="organization_img" name="organization_img">
								<input 	type="hidden" id="organization_id" 
										value="<?php echo($orgAry['organization_id']);?>" name="organization_id">
								</span>
								</span>
							</div>
						</div>
						<br/>
						<div class="row">
							<textarea class="form-control" rows="4" name="description"
									placeholder="Organization Introductory Description"><?php echo($orgAry['description']);?></textarea>
						</div>
						<br/>
						<div class="row">
							<fieldset>
								<legend>Add Courses/Streams</legend>
								<button class="btn btn-success btn-sm" id="add_course">Add <i class="fa fa-plus" aria-hidden="true"></i>
								</button>
								<br/><br/>
								<div class="row">
									<div class="col-lg-12 col-sm-12 col-md-12" id="courses_fieldset">
										<?php echo($element);?>
									</div>
								</div>
							</fieldset>
						</div>
						<br/>
						<div class="checkbox">
							<label> <input type="checkbox" onclick="OnTerms(this);"> I confirms that all of the details 
								provided by me above are true. I will be responsible, if any mis-information are 
								communicated in aforementioned fields.
							</label>
						</div>
						<br/>
						<div class="row">
							<div class="text-center">
								<button type="submit" id="submit_btn" class="btn btn-success" disabled>Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			<?php
			include (dirname ( __FILE__ ) . "/../../lib/footer.php");
			?>
		</div>
	</div>
</body>
<script type="text/javascript">

		var clipboard = new Clipboard('.btn-info');
		
		clipboard.on('success', function(e) {
			$.Notify({
				caption: "Your about page URL is copied",
				content: "URL <b>"+e.text+"</b> is copied to clipboard!",
				style: {background: 'green', color: '#fff'}, 
				timeout: 5000
				});
		});
		
		function OnRemove(obj)
		{
			var id = $(obj).attr("elm");

			$("#"+id).remove();

			return false;
		}

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
		
		onGAPILoad = function(){
			gapi.client.setApiKey('AIzaSyCJ6dEjX52Yb2pRO2QktXa6iRtL_9T_r3E');
			gapi.client.load('urlshortener', 'v1', function() {
				$("#copy_btn").attr("data-clipboard-text", "");

				var request = gapi.client.urlshortener.url.insert({
					'resource': {
						'longUrl': '<?php printf(CSiteConfig::ROOT_URL.'/about-publisher.php?pub=%s&pub-enct=%s', urlencode($orgAry['organization_name']), $orgAry['organization_id']);?>'
					}
				});
				request.execute(function(response) {
					if (response.id != null) {
						$("#copy_btn").attr("data-clipboard-text", response.id);
						$("#about_publisher").val(response.id);
					}
					else
					{
						$("#copy_btn").attr("data-clipboard-text", '<?php printf(CSiteConfig::ROOT_URL.'/about-publisher.php?pub=%s&pub-enct=%s', urlencode($orgAry['organization_name']), $orgAry['organization_id']);?>');
						$("#about_publisher").val('<?php printf(CSiteConfig::ROOT_URL.'/about-publisher.php?pub=%s&pub-enct=%s', urlencode($orgAry['organization_name']), $orgAry['organization_id']);?>');
					}
				});
			});
		}
		
		jQuery.validator.addMethod("complete_url", function(val, elem) {
		    // if no url, don't do anything
		    if (val.length == 0) { return true; }
		 
		    // if user has not entered http:// https:// or ftp:// assume they mean http://
		    if(!/^(https?|ftp):\/\//i.test(val)) {
		        val = 'http://'+val; // set both the value
		        $(elem).val(val); // also update the form element
		    }
		    // now check if valid url
		    // http://docs.jquery.com/Plugins/Validation/Methods/url
		    return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(val);
		}, '<div style="color:red">You must enter a valid URL</div>');
			
	    jQuery.validator.addMethod("ValidateImageExt", function(value, element) {
			if(!value.trim())
				return true;
			
	    	var extension = value.replace(/^.*\./, '');
	    	var aryImage = ["jpg","jpeg","png","gif"];

			var retVal = false;
	    	$.each(aryImage, function (index,value) {
	    	    if(extension == value)
	    	    {
		    	    retVal = true;
	    	    }
	    	});

	    	return retVal;
		}, "<div style='color:red;'>* Supported image extensions are only jpg / jpeg / png / gif</div>");

	    jQuery.validator.addMethod("ValidateImageDim", function(value, element) {
	    	if(!value.trim())
				return true;
			
	    	var retVal = true;

	    	if(image_width != 300 || image_height != 300)
		    	retVal = false;
	    	
	    	return retVal;
		}, "<div style='color:red;'>* Supported image dimensions are 300 by 300 pixels</div>");
			
		jQuery.validator.addMethod("YouTubeUrl", function(value, element) {
			var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;

			return (value.match(p)) ? RegExp.$1 : false;
		}, "<div style='color:red'>* Please enter correct youtube url !</div");

		$(document).ready(function () {
			gapi.load('client', onGAPILoad);
			
			$('#add_course').on("click", function(){
				var index = $('#courses_fieldset').children().length;
				var element = "<div class='input-group' id='ig-"+index+"'>";
				var element = element + "<input type='text' id='course_name_"+index+"' value='' name='course_name[]' class='form-control' placeholder='Course Name'>";
				var element = element + "<span class='input-group-addon'>";
				var element = element + "<i class='fa fa-book' aria-hidden='true'></i>";
				var element = element + "</span>";
				var element = element + "<input type='text' id='course_desc_"+index+"' value='' name='course_desc[]' class='form-control' placeholder='Course Description'>";
				var element = element + "<span class='input-group-addon'>";
				var element = element + "<a href='#' elm='ig-"+index+"' onclick='OnRemove(this);' class='btn-danger btn-sm'><i class='fa fa-times' aria-hidden='true'></i></a>";
				var element = element + "</span>";
				var element = element + "</div>";

				$('#courses_fieldset').append(element);

				return false;
			});
			
			// ------------------------
			// [ Product Image ]
			// ------------------------
			$(document).on('change', '.btn-file :file', function() {
				var input = $(this),
					label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
				input.trigger('fileselect', [label]);
				});
		
			$('.btn-file :file').on('fileselect', function(event, label) {
			    
			    var input = $(this).parents('.input-group').find(':text'),
			        log = label;
			    
			    if( input.length ) {
			        input.val(log);
			    } else {
			        //if( log ) alert(log);
			    }
		
			    readURL(this);
		
			    var file, img;
			    if ((file = this.files[0])) {
				    img = new Image();
			        img.onload = function () {
			        	//this will give you image width and height and you can easily validate here....
			        	image_width = img.width;
			        	image_height = img.height;
			        };
			        img.src = URL.createObjectURL(file);
			        image_size	 = file.size;
			    }
			});
			function readURL(input) {
			    if (input.files && input.files[0]) {
			        var reader = new FileReader();
			        
			        reader.onload = function (e) {
			            $('#img-upload').attr('src', e.target.result);
			        }
			        
			        reader.readAsDataURL(input.files[0]);
			    }
			}
			
			jQuery.validator.addMethod("logo_image_dim", function(val, elem) {
		
				if(image_width == 300 && image_height == 300)
				{
					return true;
				}
				return false;
		    }, "<div style='color:red'>* Image dimensions has to be <b>300 by 300</b> pixels!</div");
		
			jQuery.validator.addMethod("logo_image_size", function(val, elem) {
				if(image_size > 1048576)
				{
					return false;
				}
				return true;
		    }, "<div style='color:red'>* Image file should not exceed 1MB size limit!</div");
			// ------------------------
			// [ Product Image ]
			// ------------------------
			
			$('#acnt_dtls').validate({
				errorPlacement: function(error, element) {			
					//$('#acadamic_details div.reg-error').append(error);
					$(error).insertAfter(element.parent());
				}, 
				rules: {
					organization_address: {
						required: true
					},
					organization_phone: {
						required: true
					},
					organization_email: {
	            		required:true,
	            		email: true
	            	},
					organization_city: {
						required: true
					},
					organization_state: {
						required: true
					},
					organization_country: {
						required: true
					},
					zip_code: {
						required: true
					},
					organization_name: {
						required: true
					},
					organization_url: {
						required: true,
						'complete_url': true
					},
					youtube_videos: {
						required: true,
						'YouTubeUrl': true
					},
					organization_img: {
						'ValidateImageExt':true,
	            		'ValidateImageDim':true
					},
					description: {
						required: true
					},
					'course_name[]': {
						required: true
					},
					'course_desc[]': {
						required: true
					}
				}, 
				messages: {
					organization_address: {	
	    				required:	"<div style='color:red'>* Please provide your organization's address</div>",
	        		},
					organization_phone: {	
	    				required:	"<div style='color:red'>* Please provide your organization's phone</div>",
	        		},
	        		organization_email:{
						required:	"<div style='color:red'>* Please enter your valid email-id</div>",
						email: 		"<div style='color:red'>* Please enter your valid email-id</div>"
	    			},
					organization_city: {	
	    				required:	"<div style='color:red'>* Please provide city name where your organization is located</div>",
	        		},
					organization_state: {	
	    				required:	"<div style='color:red'>* Please provide state name where your organization is located</div>",
	        		},
					organization_country: {	
	    				required:	"<div style='color:red'>* Please provide country name where your organization is located</div>",
	        		},
					zip_code: {	
	    				required:	"<div style='color:red'>* Please provide zip/pin code where your organization is located</div>",
	        		},
					organization_name: {	
	    				required:	"<div style='color:red'>* Please provide your organization's name</div>",
	        		},
					organization_url: {	
	    				required:	"<div style='color:red'>* Please provide your organization's website URL</div>",
	        		},
					youtube_videos: {	
	    				required:	"<div style='color:red'>* Please provide your organization's introduction youtube video URL</div>",
	        		},
					organization_img: {	
	    				required:	"<div style='color:red'>* Please provide your organization's image logo</div>",
	        		},
					description: {	
	    				required:	"<div style='color:red'>* Please provide introductory paragraph</div>",
	        		},
					'course_name[]': {	
	    				required:	"<div style='color:red'>* Please provide course name</div>",
	        		},
					'course_desc[]': {	
	    				required:	"<div style='color:red'>* Please provide course description</div>",
	        		}
				},submitHandler: function(form) {
					form.submit();
				}
			});
		});
	</script>
</html>