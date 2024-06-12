<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Illuminate\Http\Request as HttpRequest;
	use Illuminate\Support\Facades\DB as FacadesDB;
	use PDF;
	use SimpleSoftwareIO\QrCode\Facades\QrCode;
	use ZipArchive;
	use SnappyImage;

use function PHPUnit\Framework\isEmpty;

	// use Converter;
	
	class AdminBoxfinalController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "nama";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
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
			$this->col[] = [
				"label" => "Barcode", "name" => "kode_box","callback" => function ($row) {
					$client = DB::table('client')->where('id', $row->client_id)->orderBy('id','asc')->first();
					
					return (
					"<div class='row'>
						<div><a style='padding-left: 12px;'>".QrCode::size(35)->generate($row->kode_box_sistem)."</a></div>
						<div><button type='button' class='btn btn-sm btn-warning' data-toggle='modal' data-target='#Modal".$row->id."' >Preview</button></div>
					</div>

					<div class='modal fade' id='Modal".$row->id."' data-id='".$row->id."'>
						<div class='modal-dialog' role='document'>
							<div class='modal-content'>
								<div class='modal-header'>
									<h5 class='modal-title' id='exampleModalLabel'>Download Qrcode</h5>
									<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
										<span aria-hidden='true'>&times;</span>
									</button>
								</div>
					
								<div class='modal-body' id='html-content-holder".$row->id."' data-id='".$row->id."' style='background-color: #FFFFFF;  
									color: #000000; width: 500px; padding-top: 10px;'>

									<div class='row'>
										<div class='col-lg-5' style='margin-top: 30px;'>
											".QrCode::size(170)->generate($row->kode_box_sistem)."
										</div>
										
										<div class='col-lg-7' style='padding-top: 40px; padding-left: 40px'>
											<h4 style='font-size:20px'>".$client->nama."<br><br>
												Kode Box :<br>
												".$row->kode_box_sistem."<br><br>
												Nomor Box :<br>
												".$row->kode_box."
											</h4>
										</div>
									</div>
								</div>
								<div class='modal-footer'>
									<button type='button' class='btn' data-dismiss='modal'>Close</button>
								</div>
							</div>
						</div>	
					</div>	
						");},"image"=>1

			];

			// $this->col[] = [
			// 	"label" => "Barcode", "name" => "kode_box", "callback" => function ($row) {

			// 		return "<a target='_blank' href='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$row->kode_box."'>
			// 		<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$row->kode_box."' 
			// 		onclick='#' alt='Barcode' width='50px' height='50px'></a>
			// 		<a href='".CRUDBooster::mainpath('print_qr/'.$row->id)."'><button type='button' class='btn btn-xs btn-info'>Download</button></a>";
			// 	},"image"=>true

			// ];



			// $this->col[] = ["label"=>"Client","name"=>"client_id","join"=>"client,nama"];
			// $this->col[] = ["label"=>"Cabang","name"=>"cabang_id","join"=>"cabang,nama"];
			// $this->col[] = ["label"=>"Unit Kerja","name"=>"unit_kerja_id","join"=>"unit_kerja,nama"];
			// $this->col[] = ["label"=>"Jenis Dok","name"=>"jenis_dok_id","join"=>"jenis_dokumen,nama"];
			// $this->col[] = ["label"=>"Status","name"=>"status_id","join"=>"status,nama"];
			// $this->col[] = ["label"=>"Nama","name"=>"nama"];
			// $this->col[] = ["label"=>"Jumlah Bantex","name"=>"jumlah_dok"];
			// $this->col[] = ["label"=>"Lokasi Penyimpanan Vault","name"=>"lokasi_vault_id","join"=>"lokasi_vault,nama"];
			// $this->col[] = ["label"=>"Nomor Rak","name"=>"nomor_rak"];
			// $this->col[] = ["label"=>"Nomor Box","name"=>"kode_box"];
			// $this->col[] = ["label"=>"tgl_pemindahan","name"=>"tgl_pemindahan"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Kode Box Sistem','name'=>'kode_box_sistem','type'=>'text','validation'=>'required|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Client','name'=>'client_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'client,nama'];
			$this->form[] = ['label'=>'Cabang','name'=>'cabang_id','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'cabang,nama', 'parent_select'=>'client_id'];
			$this->form[] = ['label'=>'Unit Kerja','name'=>'unit_kerja_id','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'unit_kerja,nama', 'parent_select'=>'cabang_id'];
			$this->form[] = ['label'=>'Jenis Dok','name'=>'jenis_dok_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'jenis_dokumen,nama'];
			$this->form[] = ['label'=>'Status','name'=>'status_id','type'=>'select2','validation'=>'|min:1|max:255','width'=>'col-sm-10','datatable'=>'status,nama'];
			$this->form[] = ['label'=>'Nama Pengirim','name'=>'nama','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			$this->form[] = ['label'=>'Jumlah Bantex','name'=>'jumlah_dok','type'=>'number','validation'=>'|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Lokasi Penyimpanan Vault','name'=>'lokasi_vault_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'lokasi_vault,nama'];
			$this->form[] = ['label'=>'Nomor Rak','name'=>'nomor_rak','type'=>'text','validation'=>'|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nomor Box','name'=>'kode_box','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'tgl_pemindahan','name'=>'tgl_pemindahan','type'=>'text','validation'=>'|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'textarea','validation'=>'|string|min:5|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'File Attachment','name'=>'file_atc','type'=>'upload','validation'=>'|min:5|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Foto 1','name'=>'foto_1','type'=>'upload','validation'=>'|min:5|max:5000','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE
				$columns[] = ['label'=>'Data/Isi Dokumen','name'=>'nama','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
				$columns[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'text','validation'=>'|min:1|max:255','width'=>'col-sm-10'];
				$columns[] = ['label'=>'Status','name'=>'status_id','datatable'=>'status,nama','value'=>'1','readonly'=>'true'];
				// $columns[] = ['label'=>'Jenis Dokumen/Nama Debitur','name'=>'nama','type'=>'text','validation'=>'required|string|min:0|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
				// $columns[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'textarea','validation'=>'string|min:0|max:255','width'=>'col-sm-10'];
				$this->form[] = ['label'=>'List Bantex','name'=>'box_detail','type'=>'child','columns'=>$columns,'table'=>'box_detail','foreign_key'=>'box_id'];
				
			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Cabang Id","name"=>"cabang_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"cabang,nama"];
			//$this->form[] = ["label"=>"Client Id","name"=>"client_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"client,nama"];
			//$this->form[] = ["label"=>"Unit Kerja Id","name"=>"unit_kerja_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"unit_kerja,nama"];
			//$this->form[] = ["label"=>"Lokasi Vault Id","name"=>"lokasi_vault_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"lokasi_vault,nama"];
			//$this->form[] = ["label"=>"Jenis Dok Id","name"=>"jenis_dok_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"jenis_dok,id"];
			//$this->form[] = ["label"=>"Status Id","name"=>"status_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"status,nama"];
			//$this->form[] = ["label"=>"Status Approve","name"=>"status_approve","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Nama","name"=>"nama","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"You can only enter the letter only"];
			//$this->form[] = ["label"=>"Jumlah Dok","name"=>"jumlah_dok","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Nomor Rak","name"=>"nomor_rak","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Kode Box","name"=>"kode_box","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"tgl_pemindahan","name"=>"tgl_pemindahan","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Keterangan","name"=>"keterangan","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
			$this->sub_module[] = ['label'=>'List Bantex','path'=>'box_detail','parent_columns'=>'kode_box,nama,nomor_rak,tgl_pemindahan',
			'foreign_key'=>'box_id','button_color'=>'success','button_icon'=>'fa fa-bars'];
			$this->sub_module[] = ['label'=>'Log Update','path'=>'history_update_box','parent_columns'=>'nama,nomor_rak,tgl_pemindahan',
			'foreign_key'=>'box_id','button_color'=>'warning','button_icon'=>'fa fa-bars'];

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
			$this->addaction[] = ['title'=>'Print Label','color' => 'danger',"icon"=>"fa fa-print",
			"url"=>CRUDBooster::mainpath('print_label/[id]')];

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
			$this->button_selected[] = ['label'=>'Generate Qr','icon'=>'fa fa-download','name'=>'download_qr'];
	                
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
			$this->index_button[] = ['label'=>'Download Qr','url'=>action('AdminBoxfinalController@getDownloadSavedLabel'),'icon'=>'fa fa-download'];


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
			if($button_name == 'download_qr') {
				$this->getSave_label($id_selected);
				CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"Generate Qr berhasil, Silahkan klik tombol 'Download QR' diatas !","success");
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
			$query->where('status_approve',2);
			   
	       
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
			$cek = DB::table('box')->where('id', $id)->first();
			logHistoryBox($id);		
			// DB::table('history_update_box') -> insert(['status_id' => $cek -> status_id, 'user' => CRUDBooster::myName(), 
			// 'box_id' => $cek -> id, 'cabang_id' => $cek -> cabang_id, 'client_id' => $cek -> client_id, 
			// 'unit_kerja_id' => $cek -> unit_kerja_id,'jenis_dok_id' => $cek -> jenis_dok_id, 
			// 'nama' => $cek-> nama, 'jumlah_dok' => $cek -> jumlah_dok, 'nomor_rak' => $cek -> nomor_rak,'tgl_input' => $cek -> tgl_input,
			// 'kode_box' => $cek -> kode_box, 'keterangan' => $cek -> keterangan, 'tgl_pemindahan' => $cek -> tgl_pemindahan]);
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
		
		public function getEdit($id) {
			//Create an Auth
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
			  CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data = [];
			$data['page_title'] = 'Edit Data';
			$data['row'] = DB::table('box')
			->select('client.nama as nama_client',
			'cabang.nama as nama_cabang',
			'unit_kerja.nama as nama_unit_kerja',
			// 'jenis_dokumen.nama as nama_jenis_dok',
			'lokasi_vault.nama as nama_lokasi_vault',
			'status.nama as nama_status',
			 'box.*')
			->leftjoin('client', 'box.client_id', '=', 'client.id')
			->leftjoin('cabang', 'box.cabang_id', '=', 'cabang.id')
			->leftjoin('unit_kerja', 'box.unit_kerja_id', '=', 'unit_kerja.id')
			// ->leftjoin('jenis_dokumen', 'box.jenis_dok_id', '=', 'jenis_dokumen.id')
			->leftjoin('lokasi_vault', 'box.lokasi_vault_id', '=', 'lokasi_vault.id')
			->leftjoin('status', 'box.status_id', '=', 'status.id')
			
			->where('box.id',$id)
			->first();
			// dd($data['row']->toSql());
			$data['client_list'] = DB::table('client')->get(['id', 'nama']);
			$data['cabang_list'] = DB::table('cabang')->where('client_id', $data['row']->client_id)->get(['id', 'nama']);
			$data['unit_kerja_list'] = DB::table('unit_kerja')
			->where('client_id', $data['row']->client_id)
			->where('cabang_id', $data['row']->cabang_id)->get(['id', 'nama']);
			$data['lokasi_vault_list'] =  DB::table('lokasi_vault')->get();
			$data['status_list'] =  DB::table('status')->get();
			//Please use cbView method instead view method from laravel
			return view('edit_box',$data);
			
		  }

		  public function postEditBox($id)
		  {
			  DB::table('box')->where('id', $id)
			  ->update([
				  "lokasi_vault_id" => request('lokasi_vault_id'),
				  "jumlah_dok" => request('jumlah_dok'),
				  "nomor_rak" => request('nomor_rak'),
				  "status_id" => request('status_id'),
				  "client_id" => request('client_id'),
				  "unit_kerja_id" => request('unit_kerja_id'),
				  "cabang_id" => request('cabang_id'),
				  "nama" => request('nama'),
			  ]);

			for ($i=1; $i < 4; $i++) { 
				if (request()->hasFile("foto_{$i}")) {
					$foto = CRUDBooster::uploadFile("foto_{$i}", true);
					DB::table('box')->where('id', $id)
					->update([
						"foto_{$i}" => $foto
					]);
				}
			}
			CRUDBooster::redirect(CRUDBOOSTER::mainpath(), cbLang("alert_update_data_success"), 'success');
		}

		public function getPrint_label($id){
			$data = DB::table('box')->where('id', $id)->first();
			$client = DB::table('client')->where('id', $data->client_id)->first();
			$foto = asset('/' . $data->kode_box_sistem);
			// $barcode ='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.$data->kode_box;
			$pdf = SnappyImage::loadView('label.label', compact('data', 'foto', 'client'))
			
			->setOption('width', '1500')
			->setOption('height', '900')
			->setOption('quality', 100)
			;
			return $pdf->download('QR Code ' . $data->kode_box_sistem . '.png');
		}
		
		public function getSave_label($id){
			$files_qr = array();
			foreach ($id as $id_selected) {
				$data = DB::table('box')->where('id', $id_selected)->first();
				$client = DB::table('client')->where('id', $data->client_id)->first();
				$foto = asset('/' . $data->kode_box_sistem);
				// $barcode ='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.$data->kode_box;
				$pdf = SnappyImage::loadView('label.label', compact('data', 'foto', 'client'))
				
				->setOption('width', '1500')
				->setOption('height', '900')
				->setOption('quality', 100)
				;
				$pdf->save(public_path('qrbulk/'.$data->kode_box_sistem.'.png', true));
				array_push($files_qr, $data->kode_box_sistem.'.png');
			
				// return $pdf->download('QR Code ' . $data->kode_box_sistem . '.png');	
				}
            	$zipFileName = 'AllQr.zip';
				$zip = new ZipArchive();
				$path = public_path('qrbulk/');
				$zip->open($path.$zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
					foreach($files_qr as $file){
						$zip->addFile($path.$file,$file);
					}
					$zip->close();
			foreach($files_qr as $file){
				unlink(public_path('qrbulk/'.$file));
			}
		}

		public function getDownloadSavedLabel(){
			$fileName = "Label Qr.zip";
			$zipFileName = 'AllQr.zip';
			$pathToFile = public_path('qrbulk/').$zipFileName;
			$headers = ["Content-Type"=>"application/zip"];
			if(is_file($pathToFile)){
				// return response()->download($pathToFile, $fileName, $headers)->deleteFileAfterSend(true);
				return response()->download($pathToFile, $fileName, $headers);
			}

			CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"Silahkan pilih data dulu utk generate QR !","warning");
			// unlink($pathToFile);
			// return Redirect::to('https://www.pakainfo.com');
		}
	    //By the way, you can still create your own method in here... :) 


	}