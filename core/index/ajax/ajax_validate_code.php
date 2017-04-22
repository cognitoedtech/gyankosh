<?php
	include_once (dirname ( __FILE__ ) . "/../../../lib/session_manager.php");
	include_once (dirname ( __FILE__ ) . "/../../../lib/site_config.php");
	include_once (dirname ( __FILE__ ) . "/../../../lib/utils.php");
	include_once (dirname ( __FILE__ ) . "/../../../lib/user_manager.php");
	include_once (dirname ( __FILE__ ) . "/../../../database/config.php");
	include_once (dirname ( __FILE__ ) . "/../../../database/mcat_db.php");
	
	//echo(dirname ( __FILE__ ) . "/../../../lib/session_manager.php");
	
	$redirect_url = "../../../checkout.php";
	$email = CSessionManager::Get(CSessionManager::STR_EMAIL_ID);

	$objUM = new CUserManager();
	$objUser = $objUM->GetUserByEmail($email, CUser::FIELD_VCODE);
		
	CSessionManager::Set(CSessionManager::BOOL_VERIFIED, FALSE);
	if($objUser->GetVerificationCode() == $_POST['vcode'])
	{
		$objUM->ActivateAccountByEmail($email);
		
		CSessionManager::Set(CSessionManager::BOOL_VERIFIED, TRUE);
		CSessionManager::Set(CSessionManager::STR_USER_ID, $objUser->GetUserID()) ;
		CSessionManager::Set(CSessionManager::STR_CONTACT_NO, $objUser->GetContactNo());
		CSessionManager::Set(CSessionManager::STR_EMAIL_ID, $email);
		CSessionManager::Set(CSessionManager::BOOL_LOGIN, true) ;
		CSessionManager::Set(CSessionManager::INT_USER_TYPE, $objUser->GetUserType()) ;
		CSessionManager::Set(CSessionManager::STR_USER_NAME, $objUser->GetFirstName()." ".$objUser->GetLastName()) ;
			
	}
	else
	{
		CSessionManager::SetErrorMsg("<BR/><BR/>Dear User,<BR/><BR/> Wrong verification code, please provide right verification code.<BR/><BR/>-Team ".CConfig::SNC_SITE_NAME);
	}
	
	CUtils::Redirect($redirect_url);
?>