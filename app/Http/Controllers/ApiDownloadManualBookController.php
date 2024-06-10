<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiDownloadManualBookController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "cms_settings";        
				$this->permalink   = "download_manual_book";    
				$this->method_type = "get";
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$link = "https://cdn.iconscout.com/icon/premium/png-256-thumb/no-link-1914709-1619714.png";
				$manual_book = DB::table('cms_settings')->where("name","manual_book")
				->first();
				if($manual_book->content != null && $manual_book->content != ""){
					$link = asset($manual_book->content);
				}
				$response['api_status'] = 1;
				$response['api_message'] = 'success';
				$response['data'] = $link;
				response() -> json($response) -> send();
				exit();
		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query

		    }

		    public function hook_after($postdata,&$result) {
		        //This method will be execute after run the main process

		    }

		}