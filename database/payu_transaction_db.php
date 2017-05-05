<?php

include_once ("config.php");
include_once (dirname ( __FILE__ ) . "/../lib/utils.php");
include_once (dirname ( __FILE__ ) . "/../lib/site_config.php");

class PayuTransaction
{
	var $db_link;
	
	public function __construct()
	{
		$this->db_link = mysql_connect(CConfig::HOST, CConfig::USER_NAME, CConfig::PASSWORD);

		mysql_select_db(CConfig::DB_MCAT, $this->db_link);
	}

	public function __destruct()
	{
		mysql_close($this->db_link);
	}
	
	
	public function insertTransaction($transaction_id, $amount, $firstname, $email, $phone, $hash,$hash_string, $product_info, $transaction_status, $status_text, $user_id)
	{
		
	$query = sprintf("insert into  payu_transactions(transaction_id, amount, firstname, email, phone, hash, hash_string, product_info, transaction_status, status_text, user_id)
			values('%s', '%f', '%s','%s','%s', '%s', '%s', '%s', %d, '%s' , '%s')", $transaction_id, $amount, $firstname, $email, $phone, $hash, $hash_string, $product_info, $transaction_status, $status_text, $user_id) ;
	
	
	$result = mysql_query($query, $this->db_link) or die('Insert payu transaction error : ' . mysql_error());
	
	return mysql_insert_id();
		
	}
	
	public function updateTransaction($transaction_id, $status, $status_text, $payumoneyid, $payu_response, $bank_reference_number,$payu_response_time )
	{
		
		$query = sprintf("update payu_transactions set transaction_status =  %d , status_text = '%s',  payumoneyid = %d, payu_response = '%s' , bank_ref_num = %d , payu_response_time = '%s' where transaction_id = '%s'", $status, $status_text, $payumoneyid, $payu_response, $bank_reference_number, $payu_response_time, $transaction_id);
		$result = mysql_query($query, $this->db_link) or die('Insert payu transaction error : ' . mysql_error());
		
	}
	
	public function getPayuTransaction($transaction_id)	
	{
		$query = "select * from payu_transactions where transaction_id ='".  $transaction_id . "'" ;
		//echo $query;
		$result = mysql_query($query, $this->db_link) or die('Get payu transaction error : ' . mysql_error());
		if(mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result);
				return $row;
				
			}
		
	}
	
	
}
?>