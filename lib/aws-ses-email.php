<?php
	include_once(dirname(__FILE__)."/../database/config.php");
	include_once("site_config.php");
	include_once(dirname(__FILE__)."/../3rd_party/aws-sdk/autoload.php");
	include_once(dirname(__FILE__)."/../3rd_party/php-aws-ses/src/SimpleEmailService.php");
	include_once(dirname(__FILE__)."/../3rd_party/php-aws-ses/src/SimpleEmailServiceMessage.php");
	include_once(dirname(__FILE__)."/../3rd_party/php-aws-ses/src/SimpleEmailServiceRequest.php");

	class CEMail
	{
		private $objSes;
		private $from_address;
		private $aryAttach;
		
		/////////////////////////////////////
		////							 ////
		////	PUBLIC FUCCTIONS		 ////
		////							 ////
		/////////////////////////////////////
		public function __construct($from_address, $from_password)
		{	
			$this->aryAttach = array();
			// initialize AWS SES
			$this->from_address = $from_address;
			
			$this->objSes = new SimpleEmailService(CSiteConfig::AWS_ACCESS_KEY_ID, CSiteConfig::AWS_SECRET_ACCESS_KEY, SimpleEmailService::AWS_US_EAST_1, true);
		}
		
		public function __destruct()
		{
			unset($this->objSes);
		}
		
		public function Send($to, $subject, $msg)
		{
			$objMsg = new SimpleEmailServiceMessage();
			
			$objMsg->setFrom($this->from_address);
			$objMsg->addTo($to);
			$objMsg->setSubject($subject);
			$objMsg->setMessageFromString($msg, $msg);
			
			$rawRequest = false;
			foreach ($this->aryAttach as $key => $attachmentPDF)
			{
				$rawRequest = true;
				$objMsg->addAttachmentFromFile($attachmentPDF, '/var/www/quizus/test/ajax/'.$attachmentPDF, 'application/pdf');
			}
			
			$retVal = $this->objSes->sendEmail($objMsg, $rawRequest);
			unset($this->aryAttach);
			
			return $retVal;
		}
		
		public function SendToMany($to_ary, $subject, $msg)
		{
			$objMsgAry = array();
			
			for($i = 0; $i < count($to_ary); $i++)
			{
				$objMsg = new SimpleEmailServiceMessage();
				
				$objMsg->setFrom($this->from_address);
				$objMsg->addTo($to_ary[$i]);
				$objMsg->setSubject($subject);
				$objMsg->setMessageFromString($msg, $msg);

				array_push($objMsgAry, $objMsg);
			}
			
			$this->objSes->setBulkMode(true);

			// Send the messages
			foreach($objMsgAry as $message) {
				$this->objSes->sendEmail($message);
			}

			// Disable bulk sending mode
			$this->objSes->setBulkMode(false);
		}
		
		/*
		 * Inform candidate that he/she had been regitered for test.
		 */
		public function PrepAndSendRegMail($candidate_email, $candidate_name, $organization_name, $user_email, $user_name, $reg_url, $password)
		{
			//echo "EmailTo: ".$candidate_email."<br/>";
			
			$sub_for_candidate = "[".CConfig::SNC_SITE_NAME."] ".$candidate_name." - ".$organization_name." registered you for ability test" ;
			$msg_for_candidate = "Dear <b>".$candidate_name."</b>,<br/><br/>Test administrator <b>".$user_name."</b> ( ".$user_email." ) has registered you to take ability test designed for you. To confirm the registration, please click on following link <a href='".$reg_url."'>".$reg_url."</a> or copy and paste above link to your browser.<br/><br/>Your Username: ".$candidate_email."<br/><br/>Your Password: ".$password."<br/><br/>Regards,<br/>".CConfig::SNC_SITE_NAME." Technical Support<br/><a href='http://www.".strtolower(CConfig::SNC_SITE_NAME).".com'>www.".strtolower(CConfig::SNC_SITE_NAME).".com</a><br/><b>".CConfig::SNC_PUNCH_LINE."</b><br/><br/><br/>This is an auto generated Email. Please don't reply to this mail." ;
			
			$this->Send($candidate_email, $sub_for_candidate, $msg_for_candidate) ;
		}
		
		/*
		 * Inform candidate that a test has been scheduled for him/her.
		 */
		public function PrepAndSendTestScheduleMail($test_name, $candidate_email, $candidate_name, $organization_name, $user_email, $user_name, $date, $hours, $minutes,$expire_on, $expire_hours, $expire_minutes, $time_zone_name)
		{
			//echo "EmailTo: ".$candidate_email."<br/>";
			
			$sub_for_candidate = "[".CConfig::SNC_SITE_NAME."] ".$candidate_name." - ".$organization_name." scheduled a test for you." ;
			if(!empty($expire_on))
			{	
				$msg_for_candidate = "Dear <b>".$candidate_name."</b>,<br/><br/>Test administrator <b>".$user_name."</b> ( ".$user_email." ) has scheduled an assessment test <b>".$test_name."</b> for you <b> dated on ".$date.", [".$hours.":".$minutes."], and will expire on ".$expire_on.", [".$expire_hours.":".$expire_minutes."], (".$time_zone_name.")</b>. Please login to your account on said date to attempt the test.<br/><br/>Regards,<br/>".CConfig::SNC_SITE_NAME." Technical Support<br/><a href='http://www.".strtolower(CConfig::SNC_SITE_NAME).".com'>www.".strtolower(CConfig::SNC_SITE_NAME).".com</a><br/><b>".CConfig::SNC_PUNCH_LINE."</b><br/><br/><br/>This is an auto generated Email. Please don't reply to this mail." ;
				$this->Send($candidate_email, $sub_for_candidate, $msg_for_candidate) ;
				
			}
			else 
			{	
				$msg_for_candidate = "Dear <b>".$candidate_name."</b>,<br/><br/>Test administrator <b>".$user_name."</b> ( ".$user_email." ) has scheduled an assessment test <b>".$test_name."</b> for you <b>dated on ".$date.", [".$hours.":".$minutes."], (".$time_zone_name.")</b>. Please login to your account on said date to attempt the test.<br/><br/>Regards,<br/>".CConfig::SNC_SITE_NAME." Technical Support<br/><a href='http://www.".strtolower(CConfig::SNC_SITE_NAME).".com'>www.".strtolower(CConfig::SNC_SITE_NAME).".com</a><br/><b>".CConfig::SNC_PUNCH_LINE."</b><br/><br/><br/>This is an auto generated Email. Please don't reply to this mail." ;
				$this->Send($candidate_email, $sub_for_candidate, $msg_for_candidate);
				
			}
			
		}
		
		/*
		 * Retrieve Forgotten Password email.
		 */
		public function PrepAndSendPasswordChangeMail($candidate_email, $candidate_name, $candidate_id, $md5_pwd, $ip_addr)
		{
			//echo "EmailTo: ".$candidate_email."<br/>";
			
			$sub_for_candidate = "[".CConfig::SNC_SITE_NAME."] ".$candidate_name." - password change request!" ;
			$msg_for_candidate = "Dear <b>".$candidate_name."</b>,<br/><br/>We have received a password retrieval request (via I.P. address - <b>".$ip_addr."</b>) from our &lsquo;Retrieve Forgotten Password&rsquo; section. Please click on following link <a href='".CSiteConfig::ROOT_URL."/login/forgot_done.php?loc=".$md5_pwd."&offset=".$candidate_id."&rand=".md5($candidate_email)."'>".CSiteConfig::ROOT_URL."/login/forgot_done.php?loc=".$md5_pwd."&offset=".$candidate_id."&rand=".md5($candidate_email)."</a> to change the existing password. If you won&rsquo;t act on this email your password will remain un-touched.<br/><br/>Regards,<br/>".CConfig::SNC_SITE_NAME." Technical Support<br/><a href='http://www.".strtolower(CConfig::SNC_SITE_NAME).".com'>www.".strtolower(CConfig::SNC_SITE_NAME).".com</a><br/><b>".CConfig::SNC_PUNCH_LINE."</b><br/><br/><br/>This is an auto generated Email. Please don't reply to this mail." ;
			
			$this->Send($candidate_email, $sub_for_candidate, $msg_for_candidate) ;
		}
		
		/*
		 * Send Bussiness Associate enquiry email.
		 */
		public function PrepAndSendPwdChangedAckMail($candidate_email, $candidate_name, $ip_addr)
		{
			//echo "EmailTo: ".$candidate_email."<br/>";
			
			$sub_for_candidate = "[".CConfig::SNC_SITE_NAME."] ".$candidate_name." - password change done!" ;
			$msg_for_candidate = "Dear <b>".$candidate_name."</b>,<br/><br/>We have changed your password (via I.P. address - <b>".$ip_addr."</b>). Welcome back, you are important to us - please feel free to use our services.<br/><br/>Regards,<br/>".CConfig::SNC_SITE_NAME." Technical Support<br/><a href='http://www.".strtolower(CConfig::SNC_SITE_NAME).".com'>www.".strtolower(CConfig::SNC_SITE_NAME).".com</a><br/><b>".CConfig::SNC_PUNCH_LINE."</b><br/><br/><br/>This is an auto generated Email. Please don't reply to this mail." ;
			
			$this->Send($candidate_email, $sub_for_candidate, $msg_for_candidate) ;
		}
		
		/*
		 * Send Bussiness Associate enquiry email.
		 */
		public function PrepAndSendBAEnquiryMail($contact, $ba_email, $org_name, $subject, $msg, $ip_addr)
		{
			//echo "EmailTo: ".$ba_email."<br/>";
			
			$sub_for_receptor = "[".CConfig::SNC_SITE_NAME." - Business Associate Request] ".$subject ;
			$msg_for_receptor = "Dear Sir or Madam,<br/><br/>We have received &lsquo;Becoming Business Associate&rsquo; request (via I.P. address - <b>".$ip_addr."</b>) from <b>".$org_name."</b> (Email: ".$ba_email.", Contact #: ".$contact.").<br/><br/><hr/><b><u>Message :</u></b><br/><br/>".$msg.".<br/><hr/><br/>Our Business Development Executive will soon contact you, Thanks for your interest!.<br/><br/>Regards,<br/>".CConfig::SNC_SITE_NAME." Business Associate Support<br/><a href='http://www.".strtolower(CConfig::SNC_SITE_NAME).".com'>www.".strtolower(CConfig::SNC_SITE_NAME).".com</a><br/><b>".CConfig::SNC_PUNCH_LINE."</b><br/><br/><br/><b>Note:</b> This is an auto generated Email. You can reply to this email to know status of your request." ;
			
			// Email ACK to BA requestor.
			$this->Send($ba_email, $sub_for_receptor, $msg_for_receptor) ;
			
			// Email to BA request receptors.
			foreach(CConfig::$ba_req_email_receptors as $rec_email)
			{
				$this->Send($rec_email, $sub_for_receptor, $msg_for_receptor) ;
			}
		}
		
		public function PrepAndSendRealizePaymentMail($user_email, $user_name, $xaction_id, $amount, $currency = "Rs.")
		{
			$sub_for_user = CConfig::SNC_SITE_NAME." recharge successful" ;
			$sub_for_finance  = "One Transaction has been realized";
			
			$body = "Dear ".$user_name.",<br/><br/> Your ".CConfig::SNC_SITE_NAME." account has been recharged successfully with amount ".$currency." ".$amount." whose transaction id is ".$xaction_id.". <br/><br/>You Matter,<br/>Team ".CConfig::SNC_SITE_NAME;
			
			$this->Send($user_email, $sub_for_user, $body);
			
			$this->Send(CConfig::OEI_FINANCE, $sub_for_finance, $body);
		}
		
		public function PrepAndSendVoidPaymentMail($user_email, $user_name, $xaction_id, $void_reason)
		{
			$sub_for_user 	 = CConfig::SNC_SITE_NAME." recharge failed";
			$sub_for_finance = "One Transaction has been made void";
			
			$body = "Dear ".$user_name.",<br/><br/> Your ".CConfig::SNC_SITE_NAME." account could not be recharged successfully whose transaction id is ".$xaction_id." due to ".$void_reason." <br/><br/>You Matter,<br/>Team ".CConfig::SNC_SITE_NAME;
			
			$this->Send($user_email, $sub_for_user, $body);
			
			$this->Send(CConfig::OEI_FINANCE, $sub_for_finance, $body);
		}
		
		public function PrepAndSendFreeRechargeMail($user_email, $user_name, $amount, $currency, $free_tests)
		{
			$sub_for_user 	 = CConfig::SNC_SITE_NAME." Free Recharge" ;
			$sub_for_finance = CConfig::SNC_SITE_NAME." Free Recharge has been processed";
			
			$body_for_user = "Dear ".$user_name.",<br/><br/> You have got free ".CConfig::SNC_SITE_NAME." account recharge of <b>".$currency." ".$amount."</b> which is equivalent to <b>".$free_tests." tests.</b> <br/><br/>You Matter,<br/>Team ".CConfig::SNC_SITE_NAME."<br/><b>".CConfig::SNC_PUNCH_LINE."</b>";
			
			$body_for_finance = CConfig::SNC_SITE_NAME." free recharge has been done with <b>".$currency." ".$amount." (".$free_tests." tests)</b> for one user with details as below: <br /><br />User Name: ".$user_name."<br />Email Id: ".$user_email;
			
			$this->Send($user_email, $sub_for_user, $body_for_user);
			
			$this->Send(CConfig::OEI_FINANCE, $sub_for_finance, $body_for_finance);
		}
		
		public function PrepAndSendEncashPointsRequestMail($contrib_email, $contrib_name, $points)
		{
			$sub_for_contrib = CConfig::SNC_SITE_NAME." encash points request has been received";
			$sub_for_finance = "One encash points request has been received";
			
			$body = "Dear ".$contrib_name.",<br/><br/> Your encash request has been received for encashing ".$points." points successfully, It will take minimum 7 working days to process.Thank you for your contribution.<br/><br/>You Matter,<br/>Team ".CConfig::SNC_SITE_NAME;
			
			$this->Send($contrib_email, $sub_for_contrib, $body);
			
			$this->Send(CConfig::OEI_FINANCE, $sub_for_finance, $body);
		}
		
		public function PrepAndSendContribPaymentMail($contrib_email, $contrib_name, $points, $amount, $cheque_no, $cheque_date, $drawn_bank, $xaction_id)
		{
			$sub_for_contrib = CConfig::SNC_SITE_NAME." contribution points encashed";
			$sub_for_finance = "One contributor payment has been processed";
			
			$body = "Dear ".$contrib_name.",<br/><br/> Your request regarding encashing ".$points." points has been processed successfully with amount Rs. ".$amount." by cheque with cheque number ".$cheque_no." having date ".$cheque_date." of ".$drawn_bank." bank whose ".CConfig::SNC_SITE_NAME." transaction id is ".$xaction_id.". <br/><br/> It will take minimum 7 working days to be delivered by post or courier. <br/><br/>You Matter,<br/>Team ".CConfig::SNC_SITE_NAME;
		
			$this->Send($contrib_email, $sub_for_contrib, $body);
			
			$this->Send(CConfig::OEI_FINANCE, $sub_for_finance, $body);
		}
		
		public function PrepAndSendPromotionalMail($to_email, $recipient_name, $email_body, $subject)
		{
			$body = "Dear ".$recipient_name.",<br/><br/>".$email_body." <br/><br/>Regards,<br/>Dileep Volati<br/>".CConfig::SNC_SITE_NAME." Awareness Team<br/>Contact No.: +91 964 042 0825";
			$body.="<br /><br /><br />Note: This is an awareness and demonstration request email. If you do not want to receive promotional emails from us, then please write us on unsubscribe@".strtolower(CConfig::SNC_SITE_NAME).".com (from email id which should be unsubscribed) and we will unsubscribe you from our list. Please note that after unsubscribing from our list you will not be able to receive upcoming features and advancements from us regarding http://www.".strtolower(CConfig::SNC_SITE_NAME).".com.";
			
			$this->Send($to_email, $subject, $body);
		}
		
		public function PrepAndSendAccountRechargeMail($user_email, $user_name, $payment_mode, $recharge_amount, $payment_ordinal, $payment_date, $payment_agent, $currency)
		{
			$sub_for_user	 = CConfig::SNC_SITE_NAME." account recharge request has been received successfully";
			$sub_for_finance = CConfig::SNC_SITE_NAME." account recharge request has been received";
			
			$body = NULL;
			$currency_symbol = "$";
			if($currency == "INR")
			{
				$currency_symbol = "Rs.";
			}
			
			if($payment_mode == CConfig::PAYMENT_MODE_CHEQUE || $payment_mode == CConfig::PAYMENT_MODE_DD)
			{
				$body = "Dear ".$user_name.",<br/><br/> Your ".CConfig::SNC_SITE_NAME." account recharge request has been received successfully with details as below: <br /><br />Amount: ".$currency_symbol." ".$recharge_amount."<br />Cheque &frasl; DD Number: ".$payment_ordinal."<br />Date On Cheque &frasl; DD Number: ".$payment_date."<br />Drawn Bank Name: ".$payment_agent." <br/><br/>You Matter,<br/>Team ".CConfig::SNC_SITE_NAME;
			}
			else
			{
				$body = "Dear ".$user_name.",<br/><br/> Your ".CConfig::SNC_SITE_NAME." account recharge request has been received successfully with details as below: <br /><br />Amount: ".$currency_symbol." ".$recharge_amount."<br />NEFT Transaction ID: ".$payment_ordinal."<br />Date of Payment: ".$payment_date."<br />Bank (who) Processed: ".$payment_agent." <br/><br/>You Matter,<br/>Team ".CConfig::SNC_SITE_NAME;
			}
			
			$this->Send($user_email, $sub_for_user, $body);
			
			$this->Send(CConfig::OEI_FINANCE, $sub_for_finance, $body);
		}
		
		public function PrepAndSendInvalidPaypalTransactionMail($user_email, $user_name)
		{
			$subject = "Invalid PayPal Transaction";
			
			$body	 = "Dear ".$user_name.",<br/><br/> Your last transaction regarding recharge your ".CConfig::SNC_SITE_NAME." account has been rejected by PayPal. Please try again with proper information.<br/><br/>You Matter,<br/>Team ".CConfig::SNC_SITE_NAME;
		
			$this->Send($user_email, $subject, $body);
			
			$this->Send(CConfig::OEI_FINANCE, $subject, $body);
		}
		
		public function PrepAndSendBAPaymentMail($ba_email, $ba_name, $ba_org, $gross_commission, $net_commission, $service_tax_amount, $tds_amount, $payment_ordinal, $payment_date, $payment_agent)
		{
			$sub_for_ba		 = CConfig::SNC_SITE_NAME." Recharge Commission Processed";
			
			$sub_for_finance = CConfig::SNC_SITE_NAME." Recharge Commission Processed for Business Associate";
			
			$body			 = sprintf("Dear %s(%s),<br /><br />We have settled Rs. %1.2f(Your Share: Rs. %1.2f, Service Tax: Rs. %1.2f, TDS: Rs. %1.2f) and sent you cheque/NEFT payment on %s of %s with payment ordinal %s. You may receive your commission for within 10 working days. If you may not receive the mentioned amount, please contact your relationship Manager at ".CConfig::SNC_SITE_NAME.".com.It is always pleasure doing business with you, looking forward to generate more business with your efforts.<br />Let's Grow !<br /><br />Kind Regards,<br />Finance Department @ ".CConfig::SNC_SITE_NAME.".com<br /><br /><br />Note: You may find details of this transaction at your login under transaction statement navigation (left) menu or please contact us for more information.", $ba_name, $ba_org, $gross_commission, $net_commission, $service_tax_amount, $tds_amount, $payment_date, $payment_agent, $payment_ordinal);
		
			$this->Send($ba_email, $sub_for_ba, $body);
				
			$this->Send(CConfig::OEI_FINANCE, $sub_for_finance, $body);
		}
		
		public function PrepAndSendSubsPlanQuoteRequest($subject, $form_details)
		{
			$this->Send(CConfig::OEI_SALES, $subject, $form_details);
		}
		
		public function PrepAndSendSubsPlanQuoteRequestAck($name, $email, $subject, $ack_messsage)
		{
			$this->Send($email, $subject, $ack_messsage);
		}
		
		public function PrepAndSendDemoRequest($subject, $form_details)
		{
			$this->Send(CConfig::OEI_SALES, $subject, $form_details);
		}
		 
		public function PrepAndSendDemoRequestAck($name, $email, $subject, $ack_messsage)
		{
			$this->Send($email, $subject, $ack_messsage);
		}
		
		public function PrepAndSendTestRequest($form_details)
		{
			$subject = "Test Request Received!";
			$this->Send(CConfig::OEI_FREE, $subject, $form_details);
		}
		
		public function PrepAndSendTestRequestAck($name, $email, $ack_messsage)
		{
			$subject = "Test Request Received Successfully!";
			$this->Send($email, $subject, $ack_messsage);
		}
		
		public function PrepAndSendFreeUserFeedback($form_details)
		{
			$subject = "Free User Feedback Received!";
			$this->Send(CConfig::OEI_FREE, $subject, $form_details);
		}
		
		public function PrepAndSendFreeUserFeedbackAck($name, $email, $ack_messsage)
		{
			$subject = "Feedback Received Successfully!";
			$this->Send($email, $subject, $ack_messsage);
		}
		
		public function PrepAndSendEditTestScheduleMail($candidate_name, $candidate_email, $test_name, $tschd_id, $test_scheduled_date, $scheduled_by)
        {
            $sub_for_user     = "Scheduled test has been cancelled for you";
            $sub_for_support = "One Candidate has been removed from a scheduled test";
           
            $body_for_user = "Dear ".$candidate_name.",<br/><br/> Your name has been removed from a scheduled test with below information :<br /><br /><b>Test Name:</b> ".$test_name."<br /><b>Scheduled Date:</b> ".$test_scheduled_date."(xID : ".$tschd_id.")<br /><b>Scheduled by:</b> ".$scheduled_by."<br/><br/>You Matter,<br/>Team ".CConfig::SNC_SITE_NAME;
           
            $body_for_support = "One Candidate has been removed from a scheduled test with below information :<br /><br />Test Name: ".$test_name."<br />Scheduled Date: ".$test_scheduled_date."(xID : ".$tschd_id.")<br />Scheduled For: ".$candidate_name."(".$candidate_email.")<br />Scheduled by: ".$scheduled_by;
           
            $this->Send($candidate_email, $sub_for_user, $body_for_user);
           
            $this->Send(CConfig::OEI_SUPPORT, $sub_for_support, $body_for_support);
        }
        
        /*
         * Inform candidate that a test package has been provisioned for him/her.
        */
        public function PrepAndSendTestPackageMail($pkg_name, $candidate_email, $candidate_name, $organization_name, $user_email, $user_name, $provisioned_from, $expire, $amnt_sold)
        {
        	//echo "EmailTo: ".$candidate_email."<br/>";
        		
        	$sub_for_candidate = "[".CConfig::SNC_SITE_NAME."] ".$candidate_name." - ".$organization_name." provisioned a test package for you." ;
        	$msg_for_candidate = "Dear <b>".$candidate_name."</b>,<br/><br/>Test administrator <b>".$user_name."</b> ( ".$user_email." ) has scheduled a test package <b>".$pkg_name."</b> for you provisioned from <b>".$provisioned_from."</b> (expired in <b>".$expire." days</b>). <br/><br/>";
        		
        	if(!empty($amnt_sold))
        	{
        		$msg_for_candidate .= sprintf("Amount Charged (Inclusive of All Taxes): %s <br/><br/>", $amnt_sold);
        	}
        		
        	$msg_for_candidate .="You can avail the facility of said test package by logging into your account from provisioned date.<br/><br/>Regards,<br/>".CConfig::SNC_SITE_NAME." Technical Support<br/><a href='http://www.".strtolower(CConfig::SNC_SITE_NAME).".com'>www.".strtolower(CConfig::SNC_SITE_NAME).".com</a><br/><b>".CConfig::SNC_PUNCH_LINE."</b><br/><br/><br/>This is an auto generated Email. Please don't reply to this mail." ;
        		
        	 $this->Send($candidate_email, $sub_for_candidate, $msg_for_candidate) ;
        }
        
        public function PrepAndSendFreeUserResult($candidate_email, $candidate_name, $test_dna_file, $inspect_result_file)
        {
        	$sub_for_candidate = CConfig::SNC_SITE_NAME." Prectice Test Result !";
        	
        	$msg_for_candidate = "Dear ".$candidate_name.",<br /><br />".CConfig::SNC_SITE_NAME."'s practice tests are designed to empower candidates who are appearing in variety of exams and want to practise before appearing. ".CConfig::SNC_SITE_NAME." powered practice tests are constantly growing and your suggestions to improve our quality of service is more than welcome, you can just reply to this email and let us know your thoughts, suggestions or feedbacks about our services.";
          	
        	$msg_for_candidate .= "<br /><br />Please find attached detailed analytics and question paper (with solution) you have attempted.";
        	
        	$msg_for_candidate .= "<br /><br />You Matter,<br />Team ".CConfig::SNC_SITE_NAME."<br /><a href='".CSiteConfig::FREE_ROOT_URL."'>".CSiteConfig::FREE_ROOT_URL."</a>";
        	
			$this->aryAttach[0] = $test_dna_file;
			if($inspect_result_file != -1)
			{
				$this->aryAttach[1] = $inspect_result_file;
        	}

        	return $this->Send($candidate_email, $sub_for_candidate, $msg_for_candidate);
        }
        
        public function PrepAndSendNewOrgRegistrationNotificationMail($umail, $form_details)
        {
        	$subject = "New User Registered!";
        	
        	$body	 = "A new user has completed registration with following details: <br /><br />".$form_details;
        	
        	$this->Send(CConfig::OEI_SUPPORT, $subject, $body);
        }
        
        public function PrepAndSendNewCandRegistrationNotificationMail($owner_name, $owner_email, $cand_name, $cand_email)
        {
        	$subject = "New Candidate Registered!";
        	
        	$body    = "Hi ".ucfirst($owner_name).",<br /><br />";
        	
        	$body 	.= "The candidate ".ucfirst($cand_name)." (".$cand_email."), you either have uploaded his/her details or asked to register via direct registration url is now added in your <b>verified candidates list</b>.<br />"; 
        	
        	$body	.= "You may now start taking the tests for <b>".ucfirst($cand_name)."</b>, happy assessing!.<br /><br />";
        	
        	$body	.= "You Matter,<br />".CConfig::SNC_SITE_NAME." Technical Support<br />".CSiteConfig::ROOT_URL."<br />".CConfig::SNC_PUNCH_LINE;
        	
        	$this->Send($owner_email, $subject, $body);
        	
        	$this->Send(CConfig::OEI_SUPPORT, $subject, $body);
        }
        
        public function PrepAndSendOTFARegLinkMail($email, $test_name, $tschd_id, $user_name, $user_email, $organization_name)
        {
        	$sub_for_candidate = "[".CConfig::SNC_SITE_NAME."] ".$organization_name." registered you for ability test" ;
        	$msg_for_candidate = "Dear Candidate,<br/><br/>Test administrator <b>".$user_name."</b> ( ".$user_email." ) has registered you to take ability test <b>".$test_name."</b> designed for you. To confirm the registration, please click on following link <a href='".CSiteConfig::ROOT_URL."/reg-email/".$tschd_id."'>".CSiteConfig::ROOT_URL."/reg-email/".$tschd_id."</a> or copy and paste above link to your browser.<br/><br/><br/><br/>Regards,<br/>".CConfig::SNC_SITE_NAME." Technical Support<br/><a href='http://www.".strtolower(CConfig::SNC_SITE_NAME).".com'>www.".strtolower(CConfig::SNC_SITE_NAME).".com</a><br/><b>".CConfig::SNC_PUNCH_LINE."</b><br/><br/><br/>This is an auto generated Email. Please don't reply to this mail." ;
        		
        	$this->Send($email, $sub_for_candidate, $msg_for_candidate) ;
        }
    }
?>