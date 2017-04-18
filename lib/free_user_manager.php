<?php 
include_once(dirname(__FILE__)."free_user.php") ;
include_once(dirname(__FILE__)."site_config.php") ;
include_once(dirname(__FILE__)."/../database/config.php");

class CFreeUserManager
{
	private $db_link_id ;

	public function __construct()
	{
		// Server Name, UserName, Password, Database Name
		$this->db_link_id = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or
		die("Could not connect: " . mysql_error());
		mysql_select_db(CConfig::DB_MCAT, $this->db_link_id);
	}

	public function __destruct()
	{
		mysql_close($this->db_link_id) ;
	}
	
	public function AddFreeUser($objFreeUser)
	{
		$query = sprintf("insert into free_user(%s,%s,%s,%s) values('%s','%s','%s','%s')", CFreeUser::FIELD_EMAIL, CFreeUser::FIELD_PHONE, CFreeUser::FIELD_NAME, CFreeUser::FIELD_CITY, $objFreeUser->GetEmail(), $objFreeUser->GetPhone(), $objFreeUser->GetName(), $objFreeUser->GetCity());
		
		$result = mysql_query($query, $this->db_link_id) or die("Insert Free User Info Error: ".mysql_error($this->db_link_id)) ;
		
		return mysql_insert_id($this->db_link_id);
	}
	
	public function GetFreeUserByEmail($email)
	{
		$objFreeUser = new CFreeUser();
		
		$query = sprintf("select * from free_user where email='%s'", $email);
		
		$result = mysql_query($query, $this->db_link_id) or die("Get Free User By Email Error: ".mysql_error($this->db_link_id)) ;
		
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$objFreeUser->SetFreeUserId($row[CFreeUser::FIELD_FREE_USER_ID]);
			$objFreeUser->SetEmail($row[CFreeUser::FIELD_EMAIL]);
			$objFreeUser->SetPhone($row[CFreeUser::FIELD_PHONE]);
			$objFreeUser->SetName($row[CFreeUser::FIELD_NAME]);
			$objFreeUser->SetCity($row[CFreeUser::FIELD_CITY]);
		}
		mysql_free_result($result) ;
		return $objFreeUser;
	}
	
	public function AddFreeUserTest($free_user_id, $test_id, $test_pnr, $org_id)
	{
		$query = sprintf("insert into free_user_test(free_user_id, test_id, test_pnr, organization_id) values('%s','%s','%s','%s')", $free_user_id, $test_id, $test_pnr, $org_id);
		
		$result = mysql_query($query, $this->db_link_id) or die("Add Free User Test Error: ".mysql_error($this->db_link_id)) ;
	}
	
	//PopulateFreeTests
	public function PopulateProducts($searchText, $searchCategory, $limit_start_value = 0)
	{
		$searchText = trim($searchText);
		$searchCategory = trim($searchCategory);
		$retArray = array();		
		
		$locateCond = "";
		
		if($searchCategory == "keywords")
		{
			$searchAry = explode(" ", $searchText);
			
			$locateCond = sprintf("(");
			$i = 0;
			
			foreach($searchAry as $searchString)
			{
				if($i == 0)
				{
					$locateCond .= sprintf("locate('%s', keywords)", $searchString);
				}
				else 
				{
					$locateCond .= sprintf(" || locate('%s', keywords)", $searchString);
				}
				$i++;
			}
			$locateCond .= sprintf(")");	
		}
		else if($searchCategory == "test_name")
		{
			$locateCond = sprintf("locate('%s', product_name)", $searchText);
		}
		else if($searchCategory == "inst_name")
		{
			$locateCond = sprintf("locate('%s', org_name)", $searchText);
		}
		
		$query = sprintf("select * from published_products where %s order by rating desc limit %d, 10 ", $locateCond, $limit_start_value);
		
		/*$fp = fopen("get-search-results.txt", "a");
		fwrite($fp, $query."\r\n");
		fclose($fp);*/
		
		$result = mysql_query($query, $this->db_link_id) or die("Populate Products: ".mysql_error($this->db_link_id)) ;
		
		$rating_ary = array();
		while($row = mysql_fetch_array($result))
		{
			$aryPubInfo = json_decode($row['published_info'], TRUE);
			
			$retArray[$row['product_id']]['product_name'] = $row['product_name'];
			$retArray[$row['product_id']]['description'] = $row['description'];
			$retArray[$row['product_id']]['keywords'] = $row['keywords'];
			$retArray[$row['product_id']]['org_name'] = $row['org_name'];
			$retArray[$row['product_id']]['org_id'] = $aryPubInfo['org_id'];
			$retArray[$row['product_id']]['rating'] = $row['rating'];
			$retArray[$row['product_id']]['product_id'] = $row['product_id'];
			$retArray[$row['product_id']]['product_type'] = $row['product_type'];
			$retArray[$row['product_id']]['inr_cost'] = $aryPubInfo['cost']['inr'];
			$retArray[$row['product_id']]['usd_cost'] = $aryPubInfo['cost']['usd'];
			
			$rating_ary[$row['test_id']] = $row['rating'];
		}
		if(!empty($retArray))
		{
			array_multisort($rating_ary, SORT_DESC, $retArray);
			$retArray['next_limit_start_value'] = $limit_start_value + 10;
		}
		return $retArray;
	}

	public function GetOrgIdByTestId($test_id)
	{
		$retVal = "";
		
		$query = sprintf("select users.organization_id from users join test on test.owner_id = users.user_id where test.test_id='%s'", $test_id);
		
		$result = mysql_query($query, $this->db_link_id) or die("Get Org Id By Test Id Error: ".mysql_error($this->db_link_id)) ;
		
		if(mysql_num_rows($result) > 0)
		{
			$row = mysql_fetch_array($result);
			$retVal = $row['organization_id'];
		}
		
		return $retVal;
	}
}
?>