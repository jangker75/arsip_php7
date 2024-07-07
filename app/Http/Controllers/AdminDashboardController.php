<?php namespace App\Http\Controllers;

	use crocodicstudio\crudbooster\helpers\CRUDBooster as CRUDBooster;
	use Session;
	// use Request;
	// use DB;
	// use CRUDBooster;
	use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

	class AdminDashboardController extends \crocodicstudio\crudbooster\controllers\CBController {
		public function getIndex() {

			if(CRUDBooster::myPrivilegeId() == 3){
				$user = DB::table("cms_users")->where("id", CRUDBooster::myId())->first();
				$query = DB::table('box')->where('status_approve','2');

				if($user->client_id != null && $user->client_id != ""){
					$query->where('client_id', $user->client_id);
				}
				if($user->cabang_id != null && $user->cabang_id != ""){
					$query->where('cabang_id', $user->cabang_id);
				}
				if($user->unit_kerja_id != null && $user->unit_kerja_id != ""){
					$query->where('unit_kerja_id', $user->unit_kerja_id);
				}
				$data['countBoxTersimpan'] = (clone $query)->where('status_id','1')->count();
				$data['countBoxDipinjam'] = (clone $query)->where('status_id','2')->count();
				$data['countBoxDiambil'] = (clone $query)->where('status_id','3')->count();	
				return view('admin_dashboard_client', $data);
			}
			$data['countClient'] = DB::table('client')->count();
            $data['countBoxJepara'] = DB::table('box')->join('lokasi_vault', 'box.lokasi_vault_id', '=', 'lokasi_vault.id')
			->where('lokasi_vault.nama','jepara')->where('status_approve','2')->count();
			$data['countBoxCibitung'] = DB::table('box')->join('lokasi_vault', 'box.lokasi_vault_id', '=', 'lokasi_vault.id')
			->where('lokasi_vault.nama','cibitung')->where('status_approve','2')->count();
			$data['countBoxall1'] =  $data['countBoxCibitung'] + $data['countBoxJepara'];
			// $data['countDokAll'] = DB::table('box_detail')->count();
			$data['countBoxall2'] =  $data['countBoxTersimpan'] + $data['countBoxDipinjam'] + $data['countBoxDiambil'];
			$data['countBoxTersimpan'] = DB::table('box')->where('status_id','1')->where('status_approve','2')->count();
            $data['countBoxDipinjam'] = DB::table('box')->where('status_id','2')->where('status_approve','2')->count();
            $data['countBoxDiambil'] = DB::table('box')->where('status_id','3')->where('status_approve','2')->count();
            return view('admin_dashboard', $data);
        }

	}