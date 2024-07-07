<?php namespace App\Http\Controllers;

		use App\Http\Middleware\ApiMiddleware;
		use Illuminate\Support\Facades\DB;
		use App\Services\DynamicImageService;
		use Session;
		// use Request;
		// use DB;
		use CRUDBooster;
		use Illuminate\Support\Facades\Auth;
		use Illuminate\Support\Facades\Request;

		class ApiListBoxController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->middleware(ApiMiddleware::class);  
				$this->table       = "box";        
				$this->permalink   = "list_box";    
				$this->method_type = "get";  
		    }
		
		    public function hook_before(&$postdata) {
				//This method will be execute before run the main process
				$limit = g('limit') ?? '10';
				$offset = g('offset') ?? '0' ;
				$search = g('search');
				$privilegeIsAdmin = (Request::get('user')->id_cms_privileges == '1' || Request::get('user')->id_cms_privileges == '2');
				if(!$privilegeIsAdmin){
					$clientId = Request::get('user')->client_id;
					$cabangId = Request::get('user')->cabang_id;
					$client = DB::table('client')->where('id', $clientId)->first();
					
				}else{
					$clientId = g('client_id');
				}
				$query = DB::table('box')
						->select([
							'box.id','box.nama','box.jumlah_dok','box.nomor_rak','box.kode_box','box.status_approve','box.tgl_pemindahan',
							'box.client_id','box.cabang_id','box.kode_box_sistem',
							'client.nama as nama_client', 'cabang.nama as nama_cabang',
							'status.nama as nama_status', 'unit_kerja.nama as nama_unit_kerja',
							'jenis_dokumen.nama as nama_jenis_dokumen','lokasi_vault.nama as nama_lokasi_vault'
						])
						// ->distinct('box.kode_box')
						// if ($search != null || $search != '') {
						// 	$query = $query->leftjoin('box_detail', 'box_detail.box_id', '=','box.id');
						// }
						->leftjoin('client', 'client.id','=','box.client_id')
						->leftjoin('cabang', 'cabang.id','=','box.cabang_id')
						->leftjoin('status', 'status.id','=','box.status_id')
						->leftjoin('unit_kerja', 'unit_kerja.id','=','box.unit_kerja_id')
						->leftjoin('jenis_dokumen', 'jenis_dokumen.id','=','box.jenis_dok_id')
						->leftjoin('lokasi_vault', 'lokasi_vault.id','=','box.lokasi_vault_id');
				if($clientId != null && $clientId != 0 ){
					$query->where('box.client_id', $clientId);
				}
				if($cabangId != null && $cabangId != 0 ){
					$query->where('box.cabang_id', $cabangId);
				}
				if($client != null && $client->is_filter_unitkerja ==1){
					$query->where('box.unit_kerja_id', Request::get('user')->unit_kerja_id);
				}
				if ($search != null || $search != '') {
					$boxDtlSearch = DB::table('box_detail')
								->select('box_id as id')
								->leftjoin('box', 'box.id','=','box_detail.box_id');
								if($clientId != null && $clientId != 0 ){
									$boxDtlSearch->where('box.client_id', $clientId);
								}
								if($cabangId != null && $cabangId != 0 ){
									$boxDtlSearch->where('box.cabang_id', $cabangId);
								}
								if($client != null && $client->is_filter_unitkerja ==1){
									$boxDtlSearch->where('box.unit_kerja_id', Request::get('user')->unit_kerja_id);
								}
					$boxDtlSearch = (clone $boxDtlSearch)->where('box_detail.nama', 'LIKE', "%$search%")
								->skip($offset)->limit($limit)
								->pluck("id")->toArray();
					$box = (clone $query)
						->where(function($q)use($search, $boxDtlSearch){
							$q->where('box.kode_box', 'LIKE',"%$search%")
							->orWhere('box.kode_box_sistem','LIKE',"%$search%")
							->orWhere('box.nama', 'LIKE',"%$search%");
							if(count($boxDtlSearch) > 0){
								$q->orWhereIn("box.id", $boxDtlSearch);
							}
						})
						->orderBy('box.id', 'desc')
						->skip($offset)->limit($limit)
						->get();
						// ->toSql();
					// $query = str_replace(array('?'), array('\'%s\''), $box->toSql());
					// $query = vsprintf($query, $box->getBindings());
				} else {
					$box = (clone $query)
						->orderBy('id', 'desc')
						->skip($offset)->limit($limit)
						->get();
				}
				// $listIdBox = [];
				// foreach ($box as $row) {
				// 	if(in_array($row->id, $listIdBox)){
				// 		continue;
				// 	}
				// 	array_push($listIdBox, $row->id);
				// }
				
				
				$field = [];
				
				foreach ($box as $row) {
					$data['id'] = (int) $row->id;
					$data['nama'] = (string) $row->nama ?? '';
					$data['client'] = $row->nama_client;
					$data['cabang'] = $row->nama_cabang;
					$data['status'] = $row->nama_status;
					$data['unit_kerja'] = $row->nama_unit_kerja;
					$data['lokasi_vault'] = $row->nama_lokasi_vault;
					$data['jenis_dok'] = $row->nama_jenis_dokumen ??''; 
					$data['jumlah_dok'] = (int) $row -> jumlah_dok ?? 0;
					$data['nomor_rak'] = (string)$row -> nomor_rak ?? '';
					$data['kode_box'] = (string)$row -> kode_box ?? '';
					$data['kode_box_sistem'] = (string)$row -> kode_box_sistem ?? '';
					$data['status_approve'] = $row -> status_approve;
					$data['tgl_pemindahan'] = $row -> tgl_pemindahan;
					// $foto1 = ($row->foto_1 != null || $row->foto_1 != "") ? asset($row->foto_1) : null;
					// $foto2 = ($row->foto_2 != null || $row->foto_2 != "") ? asset($row->foto_2) : null;
					// $foto3 = ($row->foto_3 != null || $row->foto_3 != "") ? asset($row->foto_3) : null;

					// $data['foto_1'] = $foto1;
					// $data['foto_2'] = $foto2;
					// $data['foto_3'] = $foto3;

					$qa = DB::table('box_detail')->select('nama')->where('box_id', $row->id);
					$box_detail = (clone $qa)->get();
					$arr = [];
					// DB::table('box_detail')->orderBy('id', 'asc')->where('box_id', $row->id)
					// ->chunk(100, function($a)use($arr){
					// 	foreach ($a as $item) {
					// 		$arr[] = $item->nama ?? '-';
					// 	}
					// });
					
					if($box_detail->count() > 0 && $box_detail != null){
						foreach ($box_detail as $item) {
							$arr[] = $item->nama ?? '-';
						}
					}
					$data['box_detail'] = $arr;
					array_push($field, $data);
					
					
				}
		
				$response['api_status'] = 1;
				$response['api_message'] = 'success';
				$response["api_authorization"] = "You are in debug mode !";
				$response['total_data'] = count($field);
				$response['data'] = $field;
				response() -> json($response) -> send();
				exit();
				
		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query
				// $query->where('status_approve',2);
		    }

		    public function hook_after($postdata,&$result) {
		        //This method will be execute after run the main process
				
		    }

		}