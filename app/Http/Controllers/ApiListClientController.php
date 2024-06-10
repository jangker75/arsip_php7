<?php namespace App\Http\Controllers;

		use App\Http\Middleware\ApiMiddleware;
		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiListClientController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->middleware(ApiMiddleware::class);  
				$this->table       = "client";        
				$this->permalink   = "list_client";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$privilegeIsAdmin = (Request::get('user')->id_cms_privileges == '1' || Request::get('user')->id_cms_privileges == '2');
				if($privilegeIsAdmin){
					$client = DB::table('client')->get();
					$allArr = collect([
						'id' => 0,
						'nama' => "ALL"
					]);
					$client = $client->prepend($allArr);
				}else{
					$client = DB::table('client')->where('id', Request::get('user')->client_id)->get();
				}

				
				$response['api_status'] = 1;
				$response['api_message'] = 'success';
				$response["api_authorization"] = "You are in debug mode !";
				$response['data'] = $client;
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