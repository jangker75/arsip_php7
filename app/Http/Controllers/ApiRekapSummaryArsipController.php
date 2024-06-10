<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;
		use App\Http\Middleware\ApiMiddleware;
use App\Models\Cabang;

		class ApiRekapSummaryArsipController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->middleware(ApiMiddleware::class);  
				$this->table       = "box";        
				$this->permalink   = "rekap_summary_arsip";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
					$privilegeIsAdmin = (Request::get('user')->id_cms_privileges == '1' || Request::get('user')->id_cms_privileges == '2');
					if(!$privilegeIsAdmin){
						$clientId = Request::get('user')->client_id;
						$cabangId = Request::get('user')->cabang_id;
						$userClient = DB::table('client')->where('id', $clientId)->first();
					}else{
						$clientId = g('client_id');
					}
					if($clientId != null && $clientId != 0 ){
						$listClient = DB::table('client')->where('id', $clientId)->orderby('nama', 'asc')->get(['id','nama']);	
					}else{
						$listClient = DB::table('client')->orderby('nama', 'asc')->get(['id','nama']);
					}
					// $listClient = DB::table('client')->get(['id','nama']);
					$qBoxTersimpan = DB::table('box')->where('status_approve',2)
					->where('status_id', 1);
					$qBoxDipinjam = DB::table('box')->where('status_approve',2)
					->where('status_id', 2);

					$qBoxDetail = DB::table('box_detail')
					->where('status_approve',2)
					->leftjoin('box', 'box.id','=','box_detail.box_id');
					$statusTersimpan = 1;
					$statusDipinjam = 2;
					if($privilegeIsAdmin){
						$tmp['total_box_tersimpan'] = $qBoxTersimpan->count();
						$tmp['total_arsip_tersimpan'] = with(clone $qBoxDetail)->where('box_detail.status_id', $statusTersimpan)->count();
						$tmp['total_box_dipinjam'] = $qBoxDipinjam->count();
						$tmp['total_arsip_dipinjam'] = with(clone $qBoxDetail)->where('box_detail.status_id', $statusDipinjam)->count();
					}else{
						$tmp['total_box_tersimpan'] = 0;
						$tmp['total_arsip_tersimpan'] = 0;
						$tmp['total_box_dipinjam'] = 0;
						$tmp['total_arsip_dipinjam'] = 0;
					}
					$data['all'] = $tmp;
					foreach ($listClient as $client) {
						if($cabangId != null && $cabangId != 0 ){
							$listCabang = Cabang::where('client_id', $client->id)
							->where('id', $cabangId)->get();
						}else{
							$listCabang = Cabang::where('client_id', $client->id)->get();
						}
						// $listCabang = DB::table('cabang')->where('client_id', $client->id)->get(['id','nama']);
						$a = [];
						$a['nama'] = $client->nama;
						$a['total_box_tersimpan'] = with(clone $qBoxTersimpan)->where('client_id', $client->id)->count();
						$a['total_arsip_tersimpan'] = with(clone $qBoxDetail)->where('box_detail.status_id', $statusTersimpan)->where('client_id', $client->id)->count();
						$a['total_box_dipinjam'] = with(clone $qBoxDipinjam)->where('client_id', $client->id)->count();
						$a['total_arsip_dipinjam'] = with(clone $qBoxDetail)->where('box_detail.status_id', $statusDipinjam)->where('client_id', $client->id)->count();
						foreach ($listCabang as $cabang) {
							
							$b = [];
							$b['nama'] = $cabang->nama;
							$b['total_box_tersimpan'] = with(clone $qBoxTersimpan)->where('client_id', $client->id)->where("cabang_id", $cabang->id)->count();
							$b['total_arsip_tersimpan'] = with(clone $qBoxDetail)->where('box_detail.status_id', $statusTersimpan)->where('client_id', $client->id)->where("cabang_id", $cabang->id)->count();
							$b['total_box_dipinjam'] = with(clone $qBoxDipinjam)->where('client_id', $client->id)->where("cabang_id", $cabang->id)->count();
							$b['total_arsip_dipinjam'] = with(clone $qBoxDetail)->where('box_detail.status_id', $statusDipinjam)->where('client_id', $client->id)->where("cabang_id", $cabang->id)->count();
							
							if($userClient != null && $userClient->is_filter_unitkerja ==1){
								$listUnitKerja = DB::table('unit_kerja')
								->where('client_id', $clientId)
								->where('cabang_id', $cabangId)->get(['id','nama']);
								foreach ($listUnitKerja as $unitKerja) {
									$c = [];
									$c['nama'] = $unitKerja->nama;
									$c['total_box_tersimpan'] = with(clone $qBoxTersimpan)->where('client_id', $clientId)->where("cabang_id", $cabangId)->where("unit_kerja_id", $unitKerja->id)->count();
									$c['total_arsip_tersimpan'] = with(clone $qBoxDetail)->where('box_detail.status_id', $statusTersimpan)->where('client_id', $clientId)->where("cabang_id", $cabangId)->where("unit_kerja_id", $unitKerja->id)->count();
									$c['total_box_dipinjam'] = with(clone $qBoxDipinjam)->where('client_id', $clientId)->where("cabang_id", $cabangId)->where("unit_kerja_id", $unitKerja->id)->count();
									$c['total_arsip_dipinjam'] = with(clone $qBoxDetail)->where('box_detail.status_id', $statusDipinjam)->where('client_id', $clientId)->where("cabang_id", $cabangId)->where("unit_kerja_id", $unitKerja->id)->count();
									$b["unit_kerja"][] = $c;
								}
							}
							$a["cabang"][] = $b;
						}
						$data["client"][] = $a;
					}
					
				// }else{

				// }
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