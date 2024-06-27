<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;
		use App\Http\Middleware\ApiMiddleware;
		use stdClass;

		use function PHPUnit\Framework\isEmpty;

		class ApiListRackController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->middleware(ApiMiddleware::class);  
				$this->table       = "m_rack";        
				$this->permalink   = "list_rack";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$limit = g('limit') ?? '10';
				$offset = g('offset') ?? '0' ;
				$rackId = g("rack_id");
				$nomorRak = g("nomor_rack");
				$rack = DB::table('m_rack');
				$response['api_status'] = 0;
				$response['api_message'] = 'Failed no data found';
				if($rackId != null && $rackId != "" && $rackId > 0){
					$rack->where('id', $rackId);
				}
				if($nomorRak != null && $nomorRak != ""){
					$rack->where('nomor_rak', 'LIKE', "%$nomorRak%");
				}
				$data = $rack->skip($offset)->limit($limit)->get()->toArray();
				$mapRakIdBox = new stdClass();
				if(count($data) > 0){
					$response['api_status'] = 1;
					$response['api_message'] = 'success';
					$listRackId = [];
					foreach ($data as $key => $value) {
						array_push($listRackId, $value->id);
					}
					if(count($listRackId) > 0){
						$box = DB::table('box')->whereIn("nomor_rak_id", $listRackId)
						->where("status_id", 1)->where("status_approve", 2)
						->get(["id","nomor_rak_id","kode_box","kode_box_sistem","tgl_input"]);
						
						foreach ($box as $key => $value) {
							$mapRakIdBox->{$value->nomor_rak_id}[] = $value;
						}
					}
					if(isEmpty($mapRakIdBox)){
						foreach ($data as $key => &$value) {
							unset($value->updated_at);
							if($value->deskripsi == null){
								$value->deskripsi = "";
							}
							if(isset($mapRakIdBox->{$value->id})){
								$value->list_box = $mapRakIdBox->{$value->id};
							}else{
								$value->list_box = [];
							}
						}
					}
				}
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