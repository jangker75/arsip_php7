<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use SnappyImage;
	use Debugbar;

	class AdminBoxDetailController extends \crocodicstudio\crudbooster\controllers\CBController {

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
			$this->table = "box_detail";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Data/Isi Dokumen","name"=>"nama"];
			$this->col[] = ["label"=>"Box ID","name"=>"box_detail.box_id","join"=>"box,id","visible"=>false,'hidden'=>true];
            $this->col[] = ["label"=>"Nomor Box","name"=>"box.kode_box"];
            $this->col[] = ["label"=>"Kode Box","name"=>"box.kode_box_sistem"];
            $this->col[] = ["label"=>"Nomor Rak","name"=>"box.nomor_rak"];
			$this->col[] = ["label"=>"Tanggal Pemindahan","name"=>"box.tgl_pemindahan"];
			$this->col[] = ["label"=>"Status","name"=>"status_id","join"=>"status,nama"];
            $this->col[] = ["label"=>"Client","name"=>"box.client_id","join"=>"client,nama"];
			$this->col[] = ["label"=>"Unit Kerja","name"=>"box.unit_kerja_id","join"=>"unit_kerja,nama"];
			$this->col[] = ['label'=>'Tanggal Input','name'=>'box.created_at','callback_php'=>'date("d-m-Y",strtotime($row->created_at))'];
			// $this->col[] = ['label'=>'test', "name" => "box.kode_box", "callback"=>function($row){
			// 	Debugbar::info($row);
			// }];
			// $this->col[] = [
			// 	"label" => "Barcode", "name" => "box.kode_box","callback" => function ($row) {
			// 		$client = DB::table('client')->where('id', $row->client_id)->orderBy('id','asc')->first();
					
			// 		return (
			// 		"<a data-toggle='modal' data-target='#Modal' href='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$row->kode_box'>
					
			// 		<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$row->kode_box."' 
			// 		onclick='#' alt='Barcode' width='50px' height='50px'></a>
					
			// 		<button type='button' class='btn' data-toggle='modal' data-target='#Modal".$row->id."' >Preview</button>

			// <div class='modal fade' id='Modal".$row->id."' data-id='".$row->id."'>
			// <div class='modal-dialog' role='document'>

			// 	<div class='modal-content'>

			// 	<div class='modal-header'>
			// 		<h5 class='modal-title' id='exampleModalLabel'>Download Qrcode</h5>
			// 		<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			// 		<span aria-hidden='true'>&times;</span>
			// 	  </button>
			// 		</div>
					
			
			// 		<div class='modal-body' id='html-content-holder".$row->id."' data-id='".$row->id."' style='background-color: #FFFFFF;  
			// 		color: #000000; width: 500px; padding-top: 10px;'>

			// 		<div class='row'>
			// 			<div class='col-lg-5'>
			// 			<img src='https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=.$row->kode_box.' 
			// 					id='noregNow' data=".$row->kode_box."
			// 					onclick='#' alt='Barcode' style='width:250px;height:250px;'>
			// 					</div>
			// 			<div class='col-lg-7' style='padding-top: 40px; padding-left: 40px'>
			// 					<h4 style='font-size:20px'>".$client->nama."<br><br>
			// 					Kode Box :<br>
			// 					".$row->kode_box_sistem."<br><br>
			// 					Nomor Box :<br>
			// 					".$row->kode_box."
			// 					</h4>
			// 					</div>
			// 		</div>
			// 		</div>
			// 		<div class='modal-footer'>
			// 		<button type='button' class='btn' data-dismiss='modal'>Close</button>
					
					
			// 		</div>
			// 	</div>
				
			// </div>	
			// 			");},"image"=>1

			// ];
			// $this->col[] = ["label"=>"Keterangan","name"=>"keterangan"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Nomor Box','name'=>'box_id','type'=>'datamodal','datamodal_table'=>'box','datamodal_where'=>'','datamodal_columns'=>'kode_box,nomor_rak,tgl_pemindahan','datamodal_columns_alias'=>'Nomor Box,Nomor Rak,Tanggal Pemindahan','required'=>true];
			// $this->form[] = ['label'=>'Nomor Box','name'=>'box_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'box,kode_box'];
			$this->form[] = ['label'=>'Data/Isi Dokumen','name'=>'nama','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			$this->form[] = ['label'=>'Status','name'=>'status_id','datatable'=>'status,nama','value'=>'1','type'=>'hidden'];
			$this->form[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'text','validation'=>'|min:1|max:255','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Box Id","name"=>"box_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"box,nama"];
			//$this->form[] = ["label"=>"Nama","name"=>"nama","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"You can only enter the letter only"];
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
			$this->sub_module[] = ['label'=>'Log Update','path'=>'historyupdatebantex','parent_columns'=>'nama',
			'foreign_key'=>'box_detail_id','button_color'=>'warning','button_icon'=>'fa fa-bars'];

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
			// $this->index_button[] = ['label'=>'Import Data','url'=>action('AdminBoxDetailController@getImportXls'),'icon'=>'fa fa-upload'];


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
			$postdata['status_id'] = '1';
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
			logHistoryBoxDetail($id);
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
			logHistoryBoxDetail($id);
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

		public function getImportXls() {
	    	return view('box_detail_import');
		}
		
		 public function postImportXls() {
	    	ini_set('memory_limit', '256M');
	    	set_time_limit(1000);

	    	$file = Request::file('userfile');
	    	$file->move(public_path('import'),$file->getClientOriginalName());

	    	\Excel::filter('chunk')->selectSheetsByIndex(0)->load(public_path('import/'.$file->getClientOriginalName()))->chunk(500,function($result) { 

	    		$no = 1;
			    foreach($result->toArray() as $row) {
			       		$a = [];
						$a['box_id'] = $this->cekKodebox($row['kode_box']);
				    	$a['nama'] =$row['nama_bantex'];
				    	$a['keterangan'] = $row['keterangan'];
				    	
				if($a['box_id'] == 'Nomor Box Tidak Ditemukan'){
					echo $no.' | '.$row['kode_box'].' | '.$a['box_id'].'.<br/>';
					
				}else{
					DB::table('box_detail')->insert($a);
					echo $no.' | '.$row['kode_box'].' | '.$a['nama'].$nospace.' | Imported<br/>';
				
				}
					 $no++;
						
	}
			});
		}

		private function cekKodebox($nama) {
			$trimmed = trim($nama);
	    	if($row = DB::table('box')->where('kode_box',$trimmed)->first()) {
	    		return $row->id;
	    	}else{
	    		
	    		return 'Nomor Box Tidak Ditemukan';
	    	}
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
	    //By the way, you can still create your own method in here... :) 


	}