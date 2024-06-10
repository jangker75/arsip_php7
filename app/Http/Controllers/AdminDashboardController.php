<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminDashboardController extends \crocodicstudio\crudbooster\controllers\CBController {
		public function getIndex() {

            $data['countClient'] = DB::table('client')->count();
            $data['countBoxJepara'] = DB::table('box')->join('lokasi_vault', 'box.lokasi_vault_id', '=', 'lokasi_vault.id')->where('lokasi_vault.nama','jepara')->where('status_approve','2')->count();
			$data['countBoxCibitung'] = DB::table('box')->join('lokasi_vault', 'box.lokasi_vault_id', '=', 'lokasi_vault.id')->where('lokasi_vault.nama','cibitung')->where('status_approve','2')->count();
			$data['countBoxall1'] =  $data['countBoxCibitung'] + $data['countBoxJepara'];
            $data['countBoxTersimpan'] = DB::table('box')->where('status_id','1')->where('status_approve','2')->count();
            $data['countBoxDipinjam'] = DB::table('box')->where('status_id','2')->where('status_approve','2')->count();
            $data['countBoxDiambil'] = DB::table('box')->where('status_id','3')->where('status_approve','2')->count();
			// $data['countDokAll'] = DB::table('box_detail')->count();
			$data['countBoxall2'] =  $data['countBoxTersimpan'] + $data['countBoxDipinjam'] + $data['countBoxDiambil'];
           
            return view('admin_dashboard', $data);
        }

	}