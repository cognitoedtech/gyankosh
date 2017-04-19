<?php
	//Start session
	include_once("../lib/session_manager.php");
	include_once("../database/config.php");
	include_once("../database/mcat_db.php");
	include_once("../lib/user_manager.php");
	include_once("../lib/utils.php");
	include_once("../lib/billing.php");
	
	$captcha_value = CSessionManager::Get(CSessionManager::INT_CAPTCH_VALUE);
	
	$redirect_url		= $_POST['redirect_url'] ;
    $owner_id 			= clean($_POST['owner_id']);
    $owner_param 		= empty($owner_id) ? "" : "?owner=".$owner_id."&batch_id=".$_POST['batch_id'];
    $verif_code 		= clean($_POST['captcha_code']);
    
    /*$date 	= new DateTime($_POST['dob']);
    $_POST['dateofbirth']	= $date->format('Y-m-d');
    $_POST['server_captcha'] = $captcha_value;
    echo("<pre>");
    print_r($_POST);
    echo("</pre>");
    exit();*/
    
    CSessionManager::UnsetSessVar(CSessionManager::INT_CAPTCH_VALUE);
 	if ($captcha_value != $verif_code) 
	{
   		// What happens when the CAPTCHA was entered incorrectly
		CSessionManager::SetErrorMsg("Dear User,<br/><br/> Your registration process had been failed due to incorrect captcha value, please re-fill the form.<BR/><BR/>-Team ".CConfig::SNC_SITE_NAME);
		CUtils::Redirect($redirect_url.$owner_param);
		exit();
	} 
	
	CSessionManager::Set(BOOL_VALIDATE_CODE, FALSE);
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) 
	{
		return trim($str);
	}
	
	$objUM = new CUserManager();
	
	//Sanitize the POST values
	
	$plan				= CConfig::UT_INDIVIDAL;
	$batch				= json_encode(array(intval(CConfig::CDB_ID)));
	$fname				= clean($_POST['fname']);
	$lname				= clean($_POST['lname']);
	$contact_no			= clean($_POST['contact']);
	$email				= clean($_POST['email']);
	$password			= $_POST['password'];
	$gender				= clean($_POST['gender']);
	$city				= clean($_POST['city']);
	$state				= clean($_POST['state']);
	$country			= clean($_POST['country']);
	$question			= "";
	$security_answer	= "";
	$verification_code 	= mt_rand(100000, 999999);
	
	$date 	= new DateTime($_POST['dob']);
	$dob	= $date->format('Y-m-d');
	
	if($objUM->IsUserExists($email)) 
	{
		CSessionManager::SetErrorMsg("Email-ID already in use.");
		CUtils::Redirect($redirect_url);				
		exit();
	}
	else
	{
		$objUser = new CUser();
		//----------------Add User------------------------
		$objUser->SetOwnerID($owner_id);
		$objUser->SetBatch($batch);
		$objUser->SetUserType(CConfig::UT_INDIVIDAL);
		$objUser->SetOrganizationId(null);
		$objUser->SetLoginName(uniqid());
		$objUser->SetFirstName(ucwords(strtolower($fname)));
		$objUser->SetLastName(ucwords(strtolower($lname)));
		$objUser->SetPassword($password);
		$objUser->SetContactNo($contact_no);
		$objUser->SetEmail(strtolower($email)); //E-mail only in lower case
		$objUser->SetGender($gender);
		$objUser->SetCity(ucwords(strtolower($city)));
		$objUser->SetState(ucwords(strtolower($state)));
		$objUser->SetCountry(ucwords(strtolower($country)));
		$objUser->SetDOB($dob);
		$objUser->SetSecQues(ucwords(strtolower($question)));
		$objUser->SetSecAns(ucwords(strtolower($security_answer)));
		$objUser->SetVerificationCode($verification_code);
		
		$result = $objUM->AddUser($objUser);
		
		//Check whether the query was successful or not
		if($result != false) 
		{
			//$objBilling = new CBilling();
			//$objBilling->ApplyPlan($result, $plan);
			
			$objOwner = null;
			if(!empty($owner_id))
				$objOwner = $objUM->GetUserById($owner_id);
			
			$owner_name 	= $objOwner == null ? "" : $objOwner->GetFirstName()." ".$objOwner->GetLastName();
			$owner_email 	= $objOwner == null ? "" : $objOwner->GetEmail();
			
			$objDB = new CMcatDB();
			$objMail = new CEMail(CConfig::OEI_SUPPORT, $objDB->GetPasswordFromOfficialEMail(CConfig::OEI_SUPPORT));
			
			if(empty($owner_email))
			{
				$objMail->PrepAndSendNewCandPreCheckoutNotificationMail($fname." ".$lname, $email);
				$objMail->PrepAndSendVerificationMail($email, $fname." ".$lname, $verification_code);
			}
			else 
			{
				$objMail->PrepAndSendNewCandRegistrationNotificationMail($owner_name, $owner_email, $fname." ".$lname, $email);
			}
			CSessionManager::Set(CSessionManager::BOOL_VALIDATE_CODE, TRUE);
			CSessionManager::Set(CSessionManager::STR_EMAIL_ID, $email);
			CSessionManager::Set(CSessionManager::STR_CONTACT_NO, $contact_no);
			
			//CSessionManager::Logout() ;
			CUtils::Redirect($redirect_url);
					
			exit();
		}
		else 
		{
			CSessionManager::SetErrorMsg("<BR/><BR/>Dear User,<BR/><BR/> [Insert Failed] Your registration process had been failed, please re-fill the form.<BR/><BR/>-Team ".CConfig::SNC_SITE_NAME);
			CUtils::Redirect($redirect_url.$owner_param);
			exit();
		}
	}
	//CSessionManager::Logout() ;
?>