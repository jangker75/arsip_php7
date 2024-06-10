<?php 
function getData($table,$condition=null,$limit=null,$orderby=null) {
	$res = DB::table($table);
	if($condition) {
		$res->whereRaw($condition);
	}
	if($orderby) {
		$res->orderByRaw($orderby);
	}
	if($limit) {
		$res->take($limit);
	}
	return $res->get();
}

function redirectTo($path,$message,$type) {
	CRUDBooster::redirect($path,$message,$type);
}

function deleteData($table,$condition) {
	$row = CRUDBooster::first($table,$condition);
	DB::table($table)->where('id',$row->id)->delete();
}

function redirectBack($message,$type) {
	CRUDBooster::redirect($_SERVER['HTTP_REFERER'],$message,$type);
}


function first($table,$condition) {
	return CRUDBooster::first($table,$condition);
}

function countData($table,$condition) {
	return DB::table($table)->whereRaw($condition)->count();
}

function logHistoryBox($id) {
	$cek = DB::table('box') -> where('id', $id) -> orderby('created_at', 'desc') -> first();
						DB::table('history_update_box') -> insertGetId(['status_id' => $cek -> status_id, 'user' => CRUDBooster::myName(), 
						'box_id' => $cek -> id, 'cabang_id' => $cek -> cabang_id, 'client_id' => $cek -> client_id, 
						'unit_kerja_id' => $cek -> unit_kerja_id,'jenis_dok_id' => $cek -> jenis_dok_id, 
						'nama' => $cek-> nama, 'jumlah_dok' => $cek -> jumlah_dok, 'nomor_rak' => $cek -> nomor_rak,
						'tgl_input' => $cek -> tgl_input,'kode_box_sistem' => $cek -> kode_box_sistem,
						'kode_box' => $cek -> kode_box, 'keterangan' => $cek -> keterangan, 'tgl_pemindahan' => $cek -> tgl_pemindahan]);
}

function logHistoryBoxDetail($id){
	$cek = DB::table('box_detail') -> where('id', $id) -> orderby('created_at', 'desc') -> first();
				DB::table('history_update_box_detail') -> insert([
				'status_id' => $cek -> status_id,
				'user' => CRUDBooster::myName(),
				'box_id' => $cek -> box_id,
				'nama' => $cek-> nama,
				'box_detail_id' => $cek -> id,
				'keterangan' => $cek -> keterangan
				]);
}