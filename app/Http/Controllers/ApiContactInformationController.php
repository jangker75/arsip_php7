<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;
		use App\Http\Middleware\ApiMiddleware;

		class ApiContactInformationController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->middleware(ApiMiddleware::class);  
				$this->table       = "kontak_informasi";        
				$this->permalink   = "contact_information";    
				$this->method_type = "get";    
		    }

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$data = DB::table('kontak_informasi')->get();
				$response['api_status'] = 1;
				$response['api_message'] = 'success';
				$response["api_authorization"] = "You are in debug mode !";
				$response['data'] = $data;
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