<?php namespace App\Http\Controllers;

use App\Http\Middleware\ApiMiddleware;
use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiUpdateBoxController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->middleware(ApiMiddleware::class);
				$this->table       = "box";        
				$this->permalink   = "update_box";    
				$this->method_type = "post";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$status = g("status_id");
				$kodeSistem = g('kode_box_sistem');
				$needUpdate = false;
				$response['api_status'] = 0;
				if($status && $status != ""){
					$update["status_id"] = $status;
					$needUpdate = true;
				}
				
				if($needUpdate){
					
					if($kodeSistem && $kodeSistem != ''){
						$check = DB::table('box')->where("kode_box_sistem", $kodeSistem)->first();
						if($check){
							$a = DB::table('box')->where('kode_box_sistem', $kodeSistem)->update($update);
							$response['api_status'] = 1;
							$response['api_message'] = 'Success update data';
						}else{
							$response['api_message'] = 'failed update, kode box tidak ditemukan';
						}
					}else{
						$response['api_message'] = 'Kode box sistem tidak ditemukan';
					}
				}else{
					$response['api_message'] = 'No data to update';
				}
				
				$response["api_authorization"] = "You are in debug mode !";
				$response["data"] = [];
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