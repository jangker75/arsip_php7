<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use App\Http\Middleware\ApiMiddleware;

		class ApiListStatusController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->middleware(ApiMiddleware::class);  
				$this->table       = "status";        
				$this->permalink   = "list_status";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$status = DB::table('status')->where("id", ">" , "1")->get();
				$response['api_status'] = 1;
				$response['api_message'] = 'success';
				$response["api_authorization"] = "You are in debug mode !";
				$response['data'] = $status;
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