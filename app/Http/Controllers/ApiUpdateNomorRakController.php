<?php namespace App\Http\Controllers;

use App\Http\Middleware\ApiMiddleware;
use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiUpdateNomorRakController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->middleware(ApiMiddleware::class);  
				$this->table       = "box";        
				$this->permalink   = "update_nomor_rak";    
				$this->method_type = "post";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$nomor_rak = g("nomor_rak");
				$nomor_box = g("nomor_box");
				$box = DB::table('box')->where("kode_box_sistem", $nomor_box)->first();
				if($box == null || $box->id == null){
					$response['api_status'] = 0;
					$response['api_message'] = "Nomor Box tidak ditemukan : $nomor_box";	
					response() -> json($response) -> send();
					exit();
				}
				$rak = DB::table('m_rack')->where("nomor_rak", $nomor_rak)->first();
				if($rak == null || $rak->id == null){
					$response['api_status'] = 0;
					$response['api_message'] = "Nomor Rak tidak ditemukan : $nomor_rak";	
					response() -> json($response) -> send();
					exit();
				}
				//Update status id = 1 and nomor rak
				DB::table('box')->where('kode_box_sistem', $nomor_box)->update([
					"nomor_rak" => $nomor_rak,
					"status_id" => 1,
					"nomor_rak_id" => $rak->id
				]);
				$data["data_box"] = $box;
				$data["data_rak"] = $rak;
				$response['api_status'] = 1;
				$response['api_message'] = 'success update lokasi rak';
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