<?php namespace App\Http\Controllers;

use App\Http\Middleware\ApiMiddleware;
use App\Services\DynamicImageService;
use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiBoxDetailController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->middleware(ApiMiddleware::class);  
				$this->table       = "box";        
				$this->permalink   = "box_detail";    
				$this->method_type = "get";    
		    }

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$box_id = g("box_id");
				$kode_box_sistem = g("kode_box_sistem");
				$row = DB::table('box')
						->select([
							'box.*', 'client.nama as nama_client', 'cabang.nama as nama_cabang',
							'status.nama as nama_status', 'unit_kerja.nama as nama_unit_kerja',
							'jenis_dokumen.nama as nama_jenis_dokumen','lokasi_vault.nama as nama_lokasi_vault'
							
						])
						->leftjoin('client', 'client.id','=','box.client_id')
						->leftjoin('cabang', 'cabang.id','=','box.cabang_id')
						->leftjoin('status', 'status.id','=','box.status_id')
						->leftjoin('unit_kerja', 'unit_kerja.id','=','box.unit_kerja_id')
						->leftjoin('jenis_dokumen', 'jenis_dokumen.id','=','box.jenis_dok_id')
						->leftjoin('lokasi_vault', 'lokasi_vault.id','=','box.lokasi_vault_id');
						if($kode_box_sistem != ""){
							$row->where('box.kode_box_sistem', $kode_box_sistem);
						}
						if($box_id != "" && intval($box_id) > 0){
							$row->where('box.id', $box_id);
						}
					$row = $row->first();
					
					$data['id'] = $row->id;
					$data['nama'] = $row->nama;
					$data['client'] = $row->nama_client;
					$data['cabang'] = $row->nama_cabang;
					$data['status'] = $row->nama_status;
					$data['unit_kerja'] = $row->nama_unit_kerja;
					$data['lokasi_vault'] = $row->nama_lokasi_vault;
					$data['jenis_dok'] = $row->nama_jenis_dokumen;
					$data['jumlah_dok'] = $row -> jumlah_dok;
					$data['nomor_rak'] = $row -> nomor_rak;
					$data['kode_box'] = $row -> kode_box;
					$data['kode_box_sistem'] = $row -> kode_box_sistem;
					$data['status_approve'] = $row -> status_approve;
					$data['tgl_pemindahan'] = $row -> tgl_pemindahan;
					$data['keterangan'] = $row -> keterangan;
					$foto1 = ($row->foto_1 != null || $row->foto_1 != "") ? asset($row->foto_1) : null;
					$foto2 = ($row->foto_2 != null || $row->foto_2 != "") ? asset($row->foto_2) : null;
					$foto3 = ($row->foto_3 != null || $row->foto_3 != "") ? asset($row->foto_3) : null;

					$data['foto_1'] = $foto1;
					$data['foto_2'] = $foto2;
					$data['foto_3'] = $foto3;

					$box_detail = DB::table('box_detail')->select('box_detail.nama')
						->where('box_id', $row->id)
						->get();
					$arr = [];
					foreach ($box_detail as $item) {
						$arr[] = $item->nama ?? "-";
					}
				$data['box_detail'] = (count($arr) > 0) ? $arr : null;
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