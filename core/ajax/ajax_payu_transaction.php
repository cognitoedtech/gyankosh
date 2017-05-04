<?php
include_once("../../lib/session_manager.php");
include_once("../../database/payu_transaction_db.php");

// - - - - - - - - - - - - - - - - -
// On Session Expire Load ROOT_URL
// - - - - - - - - - - - - - - - - -
CSessionManager::OnSessionExpire();
// - - - - - - - - - - - - - - - - -

$user_id = CSessionManager::Get(CSessionManager::STR_USER_ID);


$transaction_id = $_POST["txnid"];
$amount = $_POST["amount"];
$firstname = $_POST["firstname"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$hash = $_POST["hash"];
$hash_string = $_POST["hash_string"];
$product_info = $_POST["productinfo"];
$transaction_status = 0;
$status_text = "INIT";

$payuTransaction = new PayuTransaction();

$insert_id = $payuTransaction->insertTransaction($transaction_id, $amount, $firstname, $email, $phone, $hash, $hash_string, $product_info, $transaction_status, $status_text, $user_id);
if($insert_id != 0)
	echo 'success';
else
	echo  'error';


?>