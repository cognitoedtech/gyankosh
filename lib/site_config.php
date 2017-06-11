<?php
	class CSiteConfig
	{
		/*----------------------------------------------*/
		// Host root path/url settings.
		/*----------------------------------------------*/
		
		const HIGHCHART_SERVER_URL = "http://127.0.0.1:3003";
		//const ROOT_URL = "http://localhost/quizus";
		//const ROOT_URL =  "http://localhost/quizus-integration" ;
		

		const ROOT_URL =  "http://localhost/quizus" ;
		const FREE_ROOT_URL = "http://localhost/quizus";

		
		const AWS_QUIZUS_USER_NAME	= "quizus.co";
		const AWS_ACCESS_KEY_ID		= "AKIAJ42JCY4MSUMUG4DA";
		const AWS_SECRET_ACCESS_KEY = "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";
		
		const DEBUG_SITE		= false;
		/*----------------------------------------------*/
		// Header/Footer Link IDs.
		/*----------------------------------------------*/
		const HF_NONE			 =	 -1  ;
		const HF_HOME_ID		 =	 0  ;
		const HF_ABT_US_ID		 =	 1  ;
		const HF_LOGIN_ID		 =	 2  ;
		const HF_CONTACT_US_ID	 =	 3  ;
        const HF_DASHBOARD	 	 =	 4  ;
		const HF_TOS_ID			 =	 5  ;
		const HF_FAQ			 =	 6  ;
		const HF_GS_HELP		 =	 7  ;
		const HF_PLANS			 =	 8  ;
		const HF_REGISTER_ID	 =	 9  ;
		const HF_INDEX_ID		 =	 10  ;
		
		/*----------------------------------------------*/
		// User Account Main Menu 
		/*----------------------------------------------*/
		const UAMM_DASHBOARD 			= 0;
		const UAMM_PURCHASED_PRODUCTS	= 1;
		const UAMM_SNEAK_PEEK			= 2;
		const UAMM_SUPER_ADMIN			= 3;
		const UAMM_MY_ACCOUNT			= 4;
		const UAMM_MY_COORDINATORS		= 5;
		const UAMM_MANAGE_QUESTIONS		= 6;
		const UAMM_DESIGN_MANAGE_TEST 	= 7;
		const UAMM_BATCH_MANAGEMENT		= 8; 
		const UAMM_REGISTER_CANDITATES	= 9;
		const UAMM_SCHEDULE_TEST		= 10;
		const UAMM_TRADE_TEST_PACKGES	= 11;
		const UAMM_RESULT_ANALYTICS		= 12;
			
		
		/*----------------------------------------------*/
		// User Account Pages
		/*----------------------------------------------*/
		const UAP_SNEAK_PEEK_MIPCAT					= 0;
		const UAP_SNEAK_PEEK_PERSONAL				= 1;
		const UAP_DT_REGISTERED_USERS				= 2;
		const UAP_REALIZE_PAYMENT					= 4;
		const UAP_FREE_EVALUATION_RECHARGE			= 5;   
		const UAP_INDIVIDUAL_USERS					= 6;
		const UAP_CONTRIBUTOR_USERS					= 7;
		const UAP_PROCESS_CONTRIBUTOR_PAYMENT 		= 8;
		const UAP_BA_PAYMENT_PROCESS				= 9;
		const UAP_ACCOUNT_STATUS					= 10;
		const UAP_SCHEDULED_TEST					= 11;
		const UAP_REGISTER_VERIFIERS				= 12;
		const UAP_REGISTER_BUSINESS_ASSOCIATE		= 13;
		const UAP_EMAIL_PROMOTIONS					= 14;
		const UAP_PERSONAL_DETAILS					= 15;
		const UAP_ACCOUNT_SECURITY					= 16;
		const UAP_ABOUT_ORGANIZATION				= 17;
		const UAP_BILLING_INFORMATION				= 18;
		const UAP_ACOOUNT_RECHARGE					= 19;
		const UAP_ACOOUNT_KYC_FORM					= 20;
		const UAP_ACCOUONT_USAGE					= 21;
		const UAP_REGISTERED_COORDINATORS			= 22;
		const UAP_MANAGE_COORDINATORS				= 23;
		const UAP_SUBMIT_QUESTION					= 24;
		const UAP_BULK_UPLOAD_EXCEL					= 25;
		const UAP_RECONCILE_QUESTIONS				= 26;
		const UAP_TEST_DESIGN_WIZARD				= 27;
		const UAP_MANAGE_TEST						= 28;
		const UAP_MANAGE_BATCH						= 29;
		const UAP_CAHNGE_BATCH						= 30;
		const UAP_REGISTER_USERS					= 31;
		const UAP_REGISTERED_USERS					= 32;
		const UAP_SCHEDULE_TEST						= 33;
		const UAP_MANAGE_SCHEDULED_TEST				= 34;
		const UAP_MONITOR_ACTIVE_TEST				= 35;
		const UAP_VIEW_SCHEDULED_TEST				= 36;
		const UAP_TRADE_TEST_PACKGE					= 37;
		const UAP_VIEW_SOLD_TEST_PACKGES			= 38;
		const UAP_BRIEF_RESULT						= 39;
		const UAP_BENCHMARK							= 40;
		const UAP_ANALYZE_QUESTION					= 41;
		const UAP_PRODUCE_CUSTOM_RESULT				= 42;
		const UAP_TEST_DNA_ANALYSIS 				= 43;
		const UAP_RESULT_INSPECTION					= 44;
		const UAP_FREE_USER_RESULTS					= 45;
		const UAP_IMPORT_OFFLINE_RESULTS			= 46;
	}
?>
