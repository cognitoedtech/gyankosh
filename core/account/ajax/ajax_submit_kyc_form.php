<?php
include_once (dirname ( __FILE__ ) . "/../../../lib/session_manager.php");
include_once (dirname ( __FILE__ ) . "/../../../lib/billing.php");
include_once (dirname ( __FILE__ ) . "/../../../lib/utils.php");
include_once (dirname ( __FILE__ ) . "/../../../database/mcat_db.php");

// - - - - - - - - - - - - - - - - -
// On Session Expire Load ROOT_URL
// - - - - - - - - - - - - - - - - -
CSessionManager::OnSessionExpire();
// - - - - - - - - - - - - - - - - -

//$kiosk_percentage_sharing = $_POST['kiosk_percentage_sharing'];
$market_percentage_sharing 	= $_POST['market_percentage_sharing'];
$pan_number 				= $_POST['pan_number'];
$bank_account_number 		= $_POST['bank_account_number'];
$bank_ifsc_code 			= $_POST['bank_ifsc_code'];
$bank_name					= $_POST['bank_name'];
$bank_user_name				= $_POST['bank_user_name'];

$user_id = CSessionManager::Get(CSessionManager::STR_USER_ID);

$objUtils = new CUtils();
$objBilling = new CBilling();

$result = $objBilling->AddToSellerBilling($user_id, $market_percentage_sharing, $pan_number, $bank_account_number,
		$bank_ifsc_code, $bank_name, $bank_user_name);

if($result)
{
	$objDB = new CMcatDB();
	$objMail = new CEMail(CConfig::OEI_SUPPORT, $objDB->GetPasswordFromOfficialEMail(CConfig::OEI_SUPPORT));
	
	$body_table = "<table>";
	$body_table .= "<tr>";
	$body_table .= "<td>";
	$body_table .= "User Name";
	$body_table .= "</td>";
	$body_table .= "<td>";
	$body_table .= $bank_user_name;
	$body_table .= "</td>";
	$body_table .= "</tr>";
	
	$body_table .= "<tr>";
	$body_table .= "<td>";
	$body_table .= "Bank Account Number";
	$body_table .= "</td>";
	$body_table .= "<td>";
	$body_table .= $bank_account_number;
	$body_table .= "</td>";
	$body_table .= "</tr>";
	
	$body_table .= "<tr>";
	$body_table .= "<td>";
	$body_table .= "Branch IFSC Code" ;
	$body_table .= "</td>";
	$body_table .= "<td>";
	$body_table .= $bank_ifsc_code;
	$body_table .= "</td>";
	$body_table .= "</tr>";
	
	$body_table .= "<tr>";
	$body_table .= "<td>";
	$body_table .= "Bank Name";
	$body_table .= "</td>";
	$body_table .= "<td>";
	$body_table .= $bank_name;
	$body_table .= "</td>";
	$body_table .= "</tr>";
	
	$body_table .= "<tr>";
	$body_table .= "<td>";
	$body_table .= "Tax Identification Number";
	$body_table .= "</td>";
	$body_table .= "<td>";
	$body_table .= $pan_number;
	$body_table .= "</td>";
	$body_table .= "</tr>";
	
	$body_table .= "<tr>";
	$body_table .= "<td>";
	$body_table .= "Market Place Revenue Sharing (%)";
	$body_table .= "</td>";
	$body_table .= "<td>";
	$body_table .= $market_percentage_sharing;
	$body_table .= "</td>";
	$body_table .= "</tr>";
	$body_table = "</table>";
	
	$objMail->OnKYCFormFilled($objDB->GetUserName($user_id), $objDB->GetUserEmail($user_id), $body_table);
}

$objUtils->Redirect("../kyc-form.php?status=".$result);
?>