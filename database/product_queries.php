<?php
	include_once ("config.php");
	include_once (dirname ( __FILE__ ) . "/../lib/utils.php");
	include_once (dirname ( __FILE__ ) . "/../lib/site_config.php");
	
	class CProductQuery
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
		
		public function GetProductCategories()
		{
			$aryCategories = array();
				
			$query = sprintf("select * from test_category");
				
			//echo $query."<br/>";
				
			$result = mysql_query($query, $this->db_link) or die('Get Product Categories error : ' . mysql_error());
				
			while ($row = mysql_fetch_assoc($result)) 
			{
				if(is_array($aryCategories[$row["category"]]) == false)
				{
					$aryCategories[$row["category"]] = array();
				}
				
				if(!empty($row["sub_category"]))
				{
					array_push($aryCategories[$row["category"]], array($row["category_id"], $row["sub_category"]));
				}
			}
				
			return $aryCategories;
		}
	}
	
?>