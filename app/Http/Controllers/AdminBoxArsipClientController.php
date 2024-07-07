<?php namespace App\Http\Controllers;

	use crocodicstudio\crudbooster\helpers\CRUDBooster as CRUDBooster;
	use Session;
	use Request;
	// use DB;
	// use CRUDBooster;
	use Illuminate\Support\Facades\DB;

	class AdminBoxArsipClientController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "nama";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = false;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = false;
			$this->button_delete = false;
			$this->button_detail = true;
			$this->button_show = false;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "box";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			// $this->col[] =  ['label'=>'Tanggal Input','name'=>'created_at','callback_php'=>'date("d-m-Y",strtotime($row->created_at))'];
			$this->col[] = ["label"=>"Client","name"=>"client_id","join"=>"client,nama"];
			$this->col[] = ["label"=>"Cabang","name"=>"cabang_id","join"=>"cabang,nama"];
			$this->col[] = ["label"=>"Unit Kerja","name"=>"unit_kerja_id","join"=>"unit_kerja,nama"];
			$this->col[] = ["label"=>"Nama Pengirim","name"=>"nama"];
			$this->col[] = ["label"=>"Lokasi Penyimpanan Vault","name"=>"lokasi_vault_id","join"=>"lokasi_vault,nama"];
			// $this->col[] = ["label"=>"Nomor Rak","name"=>"nomor_rak_id","join"=>"m_rack,nomor_rak"];
			$this->col[] = ["label"=>"Nomor Box","name"=>"kode_box"];
			$this->col[] = ["label"=>"Kode Box","name"=>"kode_box_sistem"];
			$this->col[] = ["label"=>"Tanggal Pemindahan","name"=>"tgl_pemindahan"];
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
			// $this->form[] = ['label'=>'Nomor Rak','name'=>'nomor_rak','type'=>'text','validation'=>'|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Nomor Rak','name'=>'nomor_rak_id','type'=>'select2','validation'=>'required|min:0|max:255','width'=>'col-sm-10','datatable'=>'m_rack,nomor_rak'];
			$this->form[] = ['label'=>'Nomor Box','name'=>'kode_box','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'tgl_pemindahan','name'=>'tgl_pemindahan','type'=>'text','validation'=>'|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'textarea','validation'=>'|string|min:5|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'File Attachment','name'=>'file_atc','type'=>'upload','validation'=>'|min:5|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Foto 1','name'=>'foto_1','type'=>'upload','validation'=>'|min:5|max:5000','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE
				$columns[] = ['label'=>'Data/Isi Dokumen','name'=>'nama','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
				$columns[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'text','validation'=>'|min:1|max:255','width'=>'col-sm-10'];
				// $columns[] = ['label'=>'Status','name'=>'status_id','type'=>'select2','datatable'=>'status,nama'];
				// $columns[] = ['label'=>'Jenis Dokumen/Nama Debitur','name'=>'nama','type'=>'text','validation'=>'required|string|min:0|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
				// $columns[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'textarea','validation'=>'string|min:0|max:255','width'=>'col-sm-10'];
				$this->form[] = ['label'=>'List Bantex','name'=>'box_detail','type'=>'child','columns'=>$columns,'table'=>'box_detail','foreign_key'=>'box_id'];
				
			# END FORM DO NOT REMOVE THIS LINE

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
			//$this->form[] = ["label"=>"Nomor Rak Id","name"=>"nomor_rak_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"nomor_rak,id"];
			//$this->form[] = ["label"=>"Kode Box","name"=>"kode_box","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Kode Box Sistem","name"=>"kode_box_sistem","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"File Atc","name"=>"file_atc","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Tgl Input","name"=>"tgl_input","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Tgl Pemindahan","name"=>"tgl_pemindahan","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Foto 1","name"=>"foto_1","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Foto 2","name"=>"foto_2","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Foto 3","name"=>"foto_3","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
			$privId = CRUDBooster::myPrivilegeId();
			if($privId == 3){
				$userId = CRUDBooster::myId();
				$user = DB::table('cms_users')->where("id", $userId)->first();
				$query->where("box.client_id", $user->client_id)->where('status_approve',2);
				if($user->cabang_id != null && $user->cabang_id != ""){
					$query->where("box.cabang_id", $user->cabang_id);
				}
			}
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

	    }
		public function getDetail($id) {
			
			$data = [];
			$data['page_title'] = 'Detail Data';
			$data['row'] = DB::table('box')
			->select('client.nama as nama_client',
			'cabang.nama as nama_cabang',
			'unit_kerja.nama as nama_unit_kerja',
			// 'jenis_dokumen.nama as nama_jenis_dok',
			'lokasi_vault.nama as nama_lokasi_vault',
			'status.nama as nama_status',
			'm_rack.nomor_rak as nomor_rak_tersimpan',
			 'box.*')
			->leftjoin('client', 'box.client_id', '=', 'client.id')
			->leftjoin('cabang', 'box.cabang_id', '=', 'cabang.id')
			->leftjoin('unit_kerja', 'box.unit_kerja_id', '=', 'unit_kerja.id')
			->leftjoin("m_rack", "box.nomor_rak_id", "=", "m_rack.id")
			->leftjoin('lokasi_vault', 'box.lokasi_vault_id', '=', 'lokasi_vault.id')
			->leftjoin('status', 'box.status_id', '=', 'status.id')
			
			->where('box.id',$id)
			->first();
			$listAtc = DB::table('box_files')->where("box_id", $id)->get();
			$data["file_atc"] = $listAtc;
			//Please use cbView method instead view method from laravel
			return view('detail_box',$data);
			
		}


	    //By the way, you can still create your own method in here... :) 


	}