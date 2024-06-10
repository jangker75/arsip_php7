<?php namespace App\Http\Controllers;

use App\Imports\BoxImport;
use Session;
	use Request;
	use DB;
	use PDF;
	use CRUDBooster;
	use Maatwebsite\Excel\Facades\Excel;

class AdminBoxController extends \crocodicstudio\crudbooster\controllers\CBController {

		public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "nama";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "box";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] =  ['label'=>'Tanggal Input','name'=>'created_at','callback_php'=>'date("d-m-Y",strtotime($row->created_at))'];
			// $this->col[] = ["label"=>"Tanggal Pemindahan","name"=>"tgl_input"];
			$this->col[] = ["label"=>"Client","name"=>"client_id","join"=>"client,nama"];
			$this->col[] = ["label"=>"Cabang","name"=>"cabang_id","join"=>"cabang,nama"];
			$this->col[] = ["label"=>"Unit Kerja","name"=>"unit_kerja_id","join"=>"unit_kerja,nama"];
			// $this->col[] = ["label"=>"Jenis Dok","name"=>"jenis_dok_id","join"=>"jenis_dokumen,nama"];
			// $this->col[] = ["label"=>"Status","name"=>"status_id","join"=>"status,nama"];
			$this->col[] = ["label"=>"Nama Pengirim","name"=>"nama"];
			// $this->col[] = ["label"=>"Jumlah Bantex","name"=>"jumlah_dok"];
			$this->col[] = ["label"=>"Lokasi Penyimpanan Vault","name"=>"lokasi_vault_id","join"=>"lokasi_vault,nama"];
			$this->col[] = ["label"=>"Nomor Rak","name"=>"nomor_rak"];
			$this->col[] = ["label"=>"Nomor Box","name"=>"kode_box"];
			$this->col[] = ["label"=>"Kode Box","name"=>"kode_box_sistem"];
			$this->col[] = ["label"=>"Tanggal Pemindahan","name"=>"tgl_pemindahan"];
			// $this->col[] = [
			// 	"label" => "Barcode", "name" => "kode_box", "callback" => function ($row) {

			// 		return "<a target='_blank' href='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$row->kode_box."'>
			// 		<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$row->kode_box."' 
			// 		onclick='#' alt='Barcode' width='50px' height='50px'></a>
			// 		<a href='".CRUDBooster::mainpath('print_qr/'.$row->id)."'><button type='button' class='btn btn-xs btn-info'>Download</button></a>";
			// 	},"image"=>true

			// ];

// 			$this->col[] = [
// 				"label" => "Barcode", "name" => "kode_box","callback" => function ($row) {
// 					$client = DB::table('client')->where('id', $row->client_id)->orderBy('id','asc')->first();
// 					// if ( "<button type='button' class='btn'> <a id='download' href='javascript:void(0)'>Download</a></button>");
// 					return (
// 					"<a data-toggle='modal' data-target='#Modal' href='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$row->kode_box'>
// 					<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$row->kode_box."' 
// 					onclick='#' alt='Barcode' width='50px' height='50px'></a>
// 					<button type='button' class='btn' data-toggle='modal' data-target='#Modal".$row->id."' >Download</button>
		
// <div class='modal fade' id='Modal".$row->id."'>
// <div class='modal-dialog'>
//     <div class='modal-content'>
// 	<div class='modal-header'>
//         <h5 class='modal-title' id='exampleModalLabel'>Download Qrcode</h5></div>
// 		<div class='modal-body' id='html-content-holder' action='download' style='background-color: #FFFFFF;  
//                 color: #000000; width: 500px; padding-top: 10px;'>
// 		<div class='row'>
// 			<div class='col-lg-5'>
// 			<img src='https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=.$row->kode_box.' 
// 					onclick='#' alt='Barcode' style='width:250px;height:250px;'>
// 					</div>
// 			<div class='col-lg-7' style='padding-top: 20px; padding-left: 40px'>
// 					<h4>Nomor Box : ".$row->kode_box."
// 					<br>Nomor Rak : ".$row->nomor_rak."
// 					<br>Nama Client : ".$client->nama."</h4>
// 					</div>
// 		</div>
// 		<div class='modal-footer'>
//         <button type='button' class='btn' data-dismiss='modal'>Close</button>
//         <button type='button' class='btn'> <a id='download' href='javascript:void(0)'>Download</a></button> 
// 		</div>
//     </div>
// 	</div>
// </div>	
// 				");},"image"=>1

// 			];

			// ];
			// $this->col[] = ["label"=>"List Bantex","name"=>"id", "callback"=> function($row){
			// 	$data = DB::table('box_detail')->where('box_id',$row->id)->select('nama')->get();
			// 	$a = "";
			// 	foreach($data as $d){
			// 		$a .= strval($d->nama." - ");
			// 	}
			// 	return mb_substr($a,0,-3);
			// }
			// ];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Nomor Box','name'=>'kode_box','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Client','name'=>'client_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'client,nama'];
			$this->form[] = ['label'=>'Cabang','name'=>'cabang_id','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'cabang,nama', 'parent_select'=>'client_id'];
			$this->form[] = ['label'=>'Unit Kerja','name'=>'unit_kerja_id','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'unit_kerja,nama', 'parent_select'=>'cabang_id'];
			// $this->form[] = ['label'=>'Jenis Dokumen','name'=>'jenis_dok_id','type'=>'select2','validation'=>'required|min:0|max:255','width'=>'col-sm-10','datatable'=>'jenis_dokumen,nama'];
			// $this->form[] = ['label'=>'Status','name'=>'status_id','type'=>'select2','validation'=>'|min:1|max:255','width'=>'col-sm-10','datatable'=>'status,nama'];
			$this->form[] = ['label'=>'Nama Pengirim','name'=>'nama','type'=>'text','validation'=>'required|string|min:0|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			$this->form[] = ['label'=>'Lokasi Penyimpanan Vault','name'=>'lokasi_vault_id','type'=>'select2','validation'=>'required|min:0|max:255','width'=>'col-sm-10','datatable'=>'lokasi_vault,nama'];
			$this->form[] = ['label'=>'Jumlah Bantex','name'=>'jumlah_dok','type'=>'number','validation'=>'|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nomor Rak','name'=>'nomor_rak','type'=>'text','validation'=>'string|min:0|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tanggal Pemindahan','name'=>'tgl_pemindahan','type'=>'text','validation'=>'|min:0|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tanggal Input','name'=>'tgl_input','readonly'=>'true','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'textarea','validation'=>'|string|min:0|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'File Attachment','name'=>'file_atc','type'=>'upload','validation'=>'|min:0|max:5000','width'=>'col-sm-10'];

			// $columns[] = ['label'=>'Kode Box','name'=>'box_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'box,kode_box'];
			$columns[] = ['label'=>'Jenis Dokumen/Nama Debitur','name'=>'nama','type'=>'text','validation'=>'required|string|min:0|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			$columns[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'textarea','validation'=>'string|min:0|max:255','width'=>'col-sm-10'];
			// $columns[] = ['label'=>'Status','name'=>'status_id','join'=>'status,nama','readonly'=>'true'];
			$this->form[] = ['label'=>'List Bantex','name'=>'box_detail','type'=>'child','columns'=>$columns,'table'=>'box_detail','foreign_key'=>'box_id'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Client','name'=>'client_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Cabang','name'=>'cabang_id','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'cabang,nama','parent_select'=>'client_id'];
			//$this->form[] = ['label'=>'Unit Kerja','name'=>'unit_kerja_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'unit_kerja,nama'];
			//$this->form[] = ['label'=>'Lokasi Vault','name'=>'lokasi_vault_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'lokasi_vault,nama'];
			//$this->form[] = ['label'=>'Jenis Dok','name'=>'jenis_dok_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'jenis_dokumen,nama'];
			//$this->form[] = ['label'=>'Status','name'=>'status_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'status,nama'];
			//$this->form[] = ['label'=>'Status Approve','name'=>'status_approve','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nama','name'=>'nama','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			//$this->form[] = ['label'=>'Jumlah Dok','name'=>'jumlah_dok','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nomor Rak','name'=>'nomor_rak','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Kode Box','name'=>'kode_box','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'tgl_pemindahan','name'=>'tgl_pemindahan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();
			$this -> addaction[] = ['label' =>'Approve','url'=>CRUDBooster::mainpath('set-status/2/[id]'),
			'icon'=>'fa fa-check','color'=>'success','confirmation' => true];

	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();
			$this->button_selected[] = ['label'=>'Approve','icon'=>'fa fa-check','name'=>'set_approve'];
	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();


	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();
			$this->index_button[] = ['label'=>'Import Data','url'=>action('AdminBoxController@getImportXls'),'icon'=>'fa fa-upload'];
			// $this->index_button[] = ['label'=>'Download Data','url'=>action('AdminBoxController@getExportArsip'),'icon'=>'fa fa-upload'];
			// $this->index_button[] = ['label'=>'Download Data','url'=>action('AdminBoxController@getExport2'),'icon'=>'fa fa-upload'];



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;
			$this->script_js ='$(document).ready(function($row) { 
          
				// Global variable 
				var element = $("#html-content-holder");
			  
				// Global variable 
				var getCanvas;  
	  
				$("#btn-Convert-Html2Image").on("click", function($row) { 
					html2canvas(element, { 
					useCORS: true,
					scale:3,
						onrendered: function(canvas) { 
							var a = document.createElement("a");
			 a.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
			 a.download = "test.png";
			 a.click();
		   }
		});
	});
	});';

            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;



	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
			if($button_name == 'set_approve') {
				DB::table('box')->whereIn('id',$id_selected)->update(['status_approve'=>'2']);
			  }
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
			//Your code here
			$query->where('status_approve',1);
			// $query = DB::table('box')->where('status_approve', '1');   
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here
			// $year = date("Y");
			// $postdata['tgl_pemindahan'] = $year;
			$date = date("d-m-Y");
			$postdata['tgl_input'] = $date;

			$postdata['status_id'] = '1';
			$postdata['status_approve'] = '1';
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
		*/
		

	    public function hook_after_add($id) {        
	        //Your code here

			$row =  DB::table('box')
			->join('client', 'client.id', '=', 'box.client_id')
			->where('box.id', $id)
			->select('client.nama')
			->first();

			$comb_kodebox = $row->nama.strval($this->getcounter()->batas_bawah+$this->getcounter()->counter_box);
			$this->updateCounter();
			$nospace = trim($comb_kodebox, ' ');
			// DB::table('box')->where('id',$id)->update(['kode_box'=>$nospace]);
			DB::table('box')->where('id',$id)->update(['kode_box_sistem'=>$nospace]);
			DB::table('box_detail')->where('box_id',$id)->update(['status_id'=>'1']);

			logHistoryBox($id);
			// $cek = DB::table('box') -> where('id', $id) -> orderby('created_at', 'desc') -> first();
			// DB::table('history_update_box') -> insert(['status_id' => $cek -> status_id, 'user' => CRUDBooster::myName(), 
			// 'box_id' => $cek -> id, 'cabang_id' => $cek -> cabang_id, 'client_id' => $cek -> client_id, 
			// 'unit_kerja_id' => $cek -> unit_kerja_id,'jenis_dok_id' => $cek -> jenis_dok_id, 
			// 'nama' => $cek-> nama, 'jumlah_dok' => $cek -> jumlah_dok, 'nomor_rak' => $cek -> nomor_rak,'tgl_input' => $cek -> tgl_input,
			// 'kode_box' => $cek -> kode_box, 'keterangan' => $cek -> keterangan, 'tgl_pemindahan' => $cek -> tgl_pemindahan]);
		
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 
			$row =  DB::table('box')
			->join('client', 'client.id', '=', 'box.client_id')
			->where('box.id', $id)
			->select('client.nama')
			->first();
			// $row = DB::table('box')->orderby('created_at', 'desc') -> first();
			$comb_kodebox = $row->nama.strval($this->count->batas_bawah+$id);
			$nospace = trim($comb_kodebox, ' ');
			// DB::table('box')->where('id',$id)->update(['kode_box'=>$nospace]);
			$cek = DB::table('box') -> where('id', $id) -> orderby('created_at', 'desc') -> first();
			
			// DB::table('history_update_box') -> insert(['status_id' => $cek -> status_id, 'user' => CRUDBooster::myName(), 
			// 'box_id' => $cek -> id, 'cabang_id' => $cek -> cabang_id, 'client_id' => $cek -> client_id, 
			// 'unit_kerja_id' => $cek -> unit_kerja_id,'jenis_dok_id' => $cek -> jenis_dok_id, 
			// 'nama' => $cek-> nama, 'jumlah_dok' => $cek -> jumlah_dok, 'nomor_rak' => $cek -> nomor_rak,
			// 'kode_box' => $cek -> kode_box, 'keterangan' => $cek -> keterangan, 'tgl_pemindahan' => $cek -> tgl_pemindahan]);
		//	logHistory($id);
		logHistoryBox($id);
		// DB::table('history_update_box') -> insert(['status_id' => $cek -> status_id, 'user' => CRUDBooster::myName(), 
		// 	'box_id' => $cek -> id, 'cabang_id' => $cek -> cabang_id, 'client_id' => $cek -> client_id, 
		// 	'unit_kerja_id' => $cek -> unit_kerja_id,'jenis_dok_id' => $cek -> jenis_dok_id, 
		// 	'nama' => $cek-> nama, 'jumlah_dok' => $cek -> jumlah_dok, 'nomor_rak' => $cek -> nomor_rak,'tgl_input' => $cek -> tgl_input,
		// 	'kode_box' => $cek -> kode_box, 'keterangan' => $cek -> keterangan, 'tgl_pemindahan' => $cek -> tgl_pemindahan]);
			
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
			//Your code here
			if(count($id)==1){
				DB::table('box_detail')->where('box_id', $id_selected)->delete();
			}else{
				foreach ($id as $id_selected) {
					DB::table('box_detail')->where('box_id', $id_selected)->delete();
					}
			}
			
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
			//Your code here
			DB::table('box_detail')->where('box_id',$id)->delete();

	    }

		

		public function getSetStatus($status,$id) {
			DB::table('box')->where('id',$id)->update(['status_approve'=>$status]);

			//This will redirect back and gives a message
			CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"Approve berhasil !","success");
		 }


		public function getImportXls() {
	    	return view('box_import');
		}
		
		public function postImportXls() {
	    	ini_set('memory_limit', '256M');
	    	set_time_limit(1000);

	    	$file = Request::file('userfile');
	    	$file->move(public_path('import'),$file->getClientOriginalName());
			$dataimport = Excel::toArray(new BoxImport, public_path('import/'.$file->getClientOriginalName()));
	    	// \Excel::filter('chunk')->selectSheetsByIndex(0)->load(public_path('import/'.$file->getClientOriginalName()))->chunk(500,function($result) { 
	    		$no = 1;
			    foreach($dataimport[0] as $row) {
					// dd($row);
						$a = [];
						if ($row['nomor_bantex'] == '1') {
							
						$a['client_id'] = $this->insertClient($row['client']);
				    	$a['cabang_id'] = $this->insertCabang($row['cabang'],$a['client_id']);
				    	$a['unit_kerja_id'] = $this->insertUnitkerja($row['unit_kerja'],$a['client_id'],$a['cabang_id']);
				    	$a['lokasi_vault_id'] = $this->insertLokasivault($row['lokasi_vault']);
						// $a['jenis_dok_id'] = $this->insertJenisdok($row['jenis_dokumen']);
				    	$a['nama'] = $row['nama_pengirim'];
				    	// $a['jumlah_dok'] = $row['jumlah_dokumen'];
				    	$a['nomor_rak'] = $row['nomor_rak'];
				    	$a['keterangan'] = $row['keterangan'];
				    	$a['status_id'] = '1';
						$a['status_approve'] = '1';
						$a['kode_box'] = $row['nomor_box'];
						
						// $year = date("Y");
						$date = date("d-m-Y");
						$a['tgl_input'] = $date;
						$a['tgl_pemindahan'] = strval($row['tanggal_pemindahan']);
						
						$rowClient =  DB::table('client')
						->where('id', $a['client_id'])
						// ->select('nama')
						->first();
						$lastrow = DB::table('box')->insertGetId($a);
						// $comb_kodebox = $rowClient->nama.strval($this->getcounter()->batas_bawah+$this->getcounter()->counter_box);
						$comb_kodebox = "MDS".strval($this->getcounter()->batas_bawah+$this->getcounter()->counter_box);
						// $nospace = trim($comb_kodebox, ' ');
						$trim_kodebox = trim($a['kode_box']);
						DB::table('box')->where('id',$lastrow)->update(['kode_box_sistem'=>$comb_kodebox]);
							// echo $no.' | '.$a['nama'].' | '.$nospace.' | Imported<br/>';
							echo $no.' | '.$a['nama'].' | '.$a['kode_box'].' | Imported<br/>';
						// if($comb_kodebox == ''){
						// 	DB::table('box')->where('id',$lastrow)->update(['kode_box_sistem'=>$comb_kodebox]);
						// 	// echo $no.' | '.$a['nama'].' | '.$nospace.' | Imported<br/>';
						// 	echo $no.' | '.$a['nama'].' | '.$a['kode_box'].' | Imported<br/>';
						// }else{
						// 	DB::table('box')->where('id',$lastrow)->update(['kode_box_sistem'=>$comb_kodebox]);
						// 	echo $no.' | '.$a['nama'].' | '.$a['kode_box'].' | Imported<br/>';
						// }
						
						$no++;
						$this->updateCounter();
						logHistoryBox($lastrow);
						// $cek = DB::table('box') -> where('id', $lastrow) -> orderby('created_at', 'desc') -> first();
						// DB::table('history_update_box') -> insertGetId(['status_id' => $cek -> status_id, 'user' => CRUDBooster::myName(), 
						// 'box_id' => $cek -> id, 'cabang_id' => $cek -> cabang_id, 'client_id' => $cek -> client_id, 
						// 'unit_kerja_id' => $cek -> unit_kerja_id,'jenis_dok_id' => $cek -> jenis_dok_id, 
						// 'nama' => $cek-> nama, 'jumlah_dok' => $cek -> jumlah_dok, 'nomor_rak' => $cek -> nomor_rak,
						// 'tgl_input' => $cek -> tgl_input,
						// 'kode_box' => $cek -> kode_box, 'keterangan' => $cek -> keterangan, 'tgl_pemindahan' => $cek -> tgl_pemindahan]);
						$a['sequence'] = $row['sequence'];
						$this->insertListBantex($row['jenis_dokumen_atau_nama_debitur'], $a['sequence']);
					}else{
						$a['sequence'] = $row['sequence'];
						$this->insertListBantex($row['jenis_dokumen_atau_nama_debitur'], $a['sequence']);
					}
				}
			// });
		}
		private function insertClient($nama) {
			$trimmed = trim($nama);
			if($trimmed == ''){
				return 1;
				
			}
			elseif($row = DB::table('client')->where('nama',$nama)->first()) {
	    		return $row->id;
			}
			
			else{
	    		$id  = DB::table('client')->insertGetId([
	    	'nama'=>strtoupper($nama)
	    		]);
	    		return $id;
	    	}
		}
		
		private function insertLokasivault($nama) {
			$trimmed = trim($nama);
			if($trimmed == ''){
				return 1;
			}
	    	elseif($row = DB::table('lokasi_vault')->where('nama',$nama)->first()) {
	    		return $row->id;
	    	}else{
	    		$id  = DB::table('lokasi_vault')->insertGetId([
	    	'nama'=>strtoupper($nama)
	    		]);
	    		return $id;
	    	}
		}
		private function insertJenisdok($nama) {
			$trimmed = trim($nama);
	    	if($row = DB::table('jenis_dokumen')->where('nama',$nama)->first()) {
	    		return $row->id;
	    	}else{
	    		$id  = DB::table('jenis_dokumen')->insertGetId([
	    	'nama'=>strtoupper($nama)
	    		]);
	    		return $id;
	    	}
		}
		private function insertCabang($nama, $id_client) {
			$trimmed = trim($nama);
			if($trimmed == ''){
				return 1;
			}
	    	elseif($row = DB::table('cabang')->where('nama',$nama)->first()) {
	    		return $row->id;
	    	}else{
	    		$id  = DB::table('cabang')->insertGetId([
					'client_id'=>$id_client,
	    			'nama'=>strtoupper($nama)
	    		]);
	    		return $id;
	    	}
		}
		
		private function insertUnitkerja($nama, $id_client, $id_cabang) {
			$trimmed = trim($nama);
			if($trimmed == ''){
				return 1;
			}
	    	elseif($row = DB::table('unit_kerja')->where('nama',$nama)->first()) {
	    		return $row->id;
	    	}else{
	    		$id  = DB::table('unit_kerja')->insertGetId([
					'cabang_id'=>$id_cabang,
					'client_id'=>$id_client,
	    			'nama'=>strtoupper($nama)
	    		]);
	    		return $id;
	    	}
		}

		private function insertListBantex($namelist, $seq){
				$myArray = explode(',', $namelist);
				$lastrowbox = DB::table('box')-> orderby('id', 'desc') -> first();
				$idlastbox = $lastrowbox->id;
    			$lastrow_bantex =	DB::table('box_detail')->insertGetId([
						'box_id'=>$idlastbox,
						'nama'=>$namelist,
						'status_id'=>1,
						'sequence'=>$seq
				]);
				logHistoryBoxDetail($lastrow_bantex);
				// $cek = DB::table('box_detail') -> where('id', $lastrow_bantex) -> orderby('created_at', 'desc') -> first();
				// DB::table('history_update_box_detail') -> insert([
				// 'status_id' => $cek -> status_id,
				// 'user' => CRUDBooster::myName(), 
				// 'box_id' => $cek -> box_id,
				// 'nama' => $cek-> nama,
				// 'box_detail_id' => $cek -> id,
				// 'keterangan' => $cek -> keterangan
				// ]);

		}
		public function getPDF($id)
		{
			$data['data'] = DB::table('box')->where('id',$id)->first();
			$pdf = PDF::loadView('label.label',$data)->setPaper('a5','landscape');
			return $pdf->stream('label.pdf');
			return view('label.label',$data);
            // return view('print.test3_landscape',$data);
		}
		public function getExportArsip()
        {
            set_time_limit(1000);
            ini_set('memory_limit', '512M');

            Excel::create("Attendance Office Hour - ".date('Y-m-d'), function($excel) {
                $excel->sheet("Sheet1", function($sheet) {
                    $data = $this->repository(false, function (Builder $query) {
                        $query->where("schedule_att_type","Office Hour");
                        return $query;
                    });
                    $data['is_export'] = true;
                    $sheet->loadview('export_report_arsip_final', $data);
                });
            })->export('xls');
		}
		
		public function getExport2()
		{
			set_time_limit(1000);
			ini_set('memory_limit', '512M');
			
			$query = DB::table('box')->get();
			Excel::create("Report", function($excel){
				$excel->sheet("Sheet1", function($sheet) {
					// $query = DB::table('box')->get();
					$query = DB::table('box')
					->leftjoin('cabang','cabang.id','=','cabang_id')
					->orderby('box.id','desc')
					->select('box.*','cabang.nama as nama_cabang');

					$data['result'] = $query->get();
                    $data['is_export'] = true;
                    $sheet->loadview('export_report_arsip_final', $data);
                })->export('xls');
			});
		}

		public function getcounter(){
			$count = DB::table('setting')->where('id','1')->first();
			return $count;
		}

		public function updateCounter(){
			DB::table('setting')->where('id',1)->update(['counter_box'=>$this->getcounter()->counter_box+1]);
			return null;
		}
		//By the way, you can still create your own method in here... :)

	}