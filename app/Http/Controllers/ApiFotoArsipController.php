<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;
		use App\Http\Middleware\ApiMiddleware;
use App\Models\Cabang;

		class ApiFotoArsipController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {  
				$this->middleware(ApiMiddleware::class);    
				$this->table       = "cabang";        
				$this->permalink   = "foto_arsip";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$privilegeIsAdmin = (Request::get('user')->id_cms_privileges == '1' || Request::get('user')->id_cms_privileges == '2');
				if(!$privilegeIsAdmin){
					$clientId = Request::get('user')->client_id;
					$cabangId = Request::get('user')->cabang_id;
				}else{
					$clientId = g('client_id');
				}
				if($clientId != null && $clientId != 0 ){
					$listClient = DB::table('client')->where('id', $clientId)->get(['id','nama']);	
				}else{
					$listClient = DB::table('client')->get(['id','nama']);
				}
				// $listClient = DB::table('client')->get(['id','nama']);
				foreach ($listClient as $client) {
					if($cabangId != null && $cabangId != 0 ){
						$listCabang = Cabang::where('client_id', $client->id)
						->where('id', $cabangId)->get();
					}else{
						$listCabang = Cabang::where('client_id', $client->id)->get();
					}
					// $listCabang = Cabang::where('client_id', $client->id)->get();
					$a = [];
					$a['nama'] = $client->nama;
					foreach ($listCabang as $key => $cabang) {
						$b = [];
						$b['nama'] = $cabang->nama;
						$b["total_foto"] = count($cabang->photos);
						if (count($cabang->photos) > 0) {
							$c = [];
							foreach ($cabang->photos as $key => $media) {
							$c[] = $media->url;
							$b["fotos"] = $c;
							}
						}
						$a["cabang"][] = $b;
					}
					$rtn[] = $a;
				}
				$data["client"] = $rtn;
				$response['api_status'] = 1;
				$response['api_message'] = 'success';
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