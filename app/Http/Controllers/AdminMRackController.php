<?php namespace App\Http\Controllers;

use App\Imports\RakImport;
use Session;
	use Request;
	use DB;
	use CRUDBooster;
	// use Illuminate\Http\Request;
	use SimpleSoftwareIO\QrCode\Facades\QrCode;
	use ZipArchive;
	use SnappyImage;
	use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\TryCatch;

	class AdminMRackController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {
	    	# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->table 			   = "m_rack";	        
			$this->title_field         = "id";
			$this->limit               = 20;
			$this->orderby             = "id,desc";
			$this->show_numbering      = FALSE;
			$this->global_privilege    = FALSE;	        
			$this->button_table_action = TRUE;   
			$this->button_action_style = "button_icon";     
			$this->button_add          = TRUE;
			$this->button_delete       = TRUE;
			$this->button_edit         = TRUE;
			$this->button_detail       = TRUE;
			$this->button_show         = TRUE;
			$this->button_filter       = TRUE;        
			$this->button_export       = FALSE;	        
			$this->button_import       = FALSE;
			$this->button_bulk_action  = TRUE;	
			$this->sidebar_mode		   = "normal"; //normal,mini,collapse,collapse-mini
			# END CONFIGURATION DO NOT REMOVE THIS LINE						      

			# START COLUMNS DO NOT REMOVE THIS LINE
	        $this->col = [];
			$this->col[] = array("label"=>"Nomor Rak","name"=>"nomor_rak" );
			$this->col[] = array("label"=>"Deskripsi","name"=>"deskripsi" );
			$this->col[] = [
				"label" => "Barcode", "name" => "nomor_rak","callback" => function ($row) {
					return (
					"<div class='row ml-2'>
						<div><a style='padding-left: 12px;'>".QrCode::size(35)->generate($row->nomor_rak)."</a></div>
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
											".QrCode::size(170)->generate($row->nomor_rak)."
										</div>
										
										<div class='col-lg-7' style='padding-top: 40px; padding-left: 20px'>
											<h4 style='font-size:20px;'>
												Nomor Rak
											</h4>
											<h4 style='font-size: 30px;'>
											".$row->nomor_rak."
											</h4>
											<h4 style='font-size:20px;'>
												Deskripsi
											</h4>
											<h4 style='font-size: 30px;'>
											".$row->deskripsi."
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
			# END COLUMNS DO NOT REMOVE THIS LINE
			# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ["label"=>"Nomor Rak","name"=>"nomor_rak","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		$this->form[] = ["label"=>"Deskripsi","name"=>"deskripsi","type"=>"textarea","required"=>FALSE,"validation"=>"min:1|max:255"];

			# END FORM DO NOT REMOVE THIS LINE     

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
			$this->index_button[] = ['label'=>'Download Qr','url'=>action('AdminMRackController@getDownloadSavedLabel'),'icon'=>'fa fa-download'];
			$this->index_button[] = ['label'=>'Import Data','url'=>action('AdminMRackController@getImportXls'),'icon'=>'fa fa-upload'];

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
			$this->script_js = "
			 $(function() {
				$('#nomor_rak').on('keyup', function(e){
					$(this).val($(this).val().replace(/\s/g, ''));
					console.log('value', $(this).val());
				})
			 });
		   	";
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
		public function postAddSave(){
			$req = request();
			$req->validate(
				[
					'nomor_rak' => 'required|unique:m_rack,nomor_rak',
					'deskripsi' => '',
				],[

					'nomor_rak.unique' => 'Nomor Rak Sudah ada'
				]
			);
			DB::table('m_rack')->insert([
				"nomor_rak" => $req->nomor_rak,
				"deskripsi" => $req->deskripsi
			]);
			if (request('submit') == cbLang('button_save_more')) {
                CRUDBooster::redirect($req->server('HTTP_REFERER'), cbLang("alert_add_data_success"), 'success');
            } else {
                CRUDBooster::redirect(CRUDBOOSTER::mainpath(), cbLang("alert_add_data_success"), 'success');
            }
		}
		public function postEditSave($id){
			$req = request();
			$req->validate(
				[
					'nomor_rak' => 'required|unique:m_rack,nomor_rak,'.$id,
					'deskripsi' => '',
				],[

					'nomor_rak.unique' => 'Nomor Rak Sudah ada'
				]
			);
			DB::table('m_rack')->where("id", $id)->update([
				"nomor_rak" => $req->nomor_rak,
				"deskripsi" => $req->deskripsi
			]);
			return CRUDBooster::redirect(CRUDBooster::mainpath(),"Edit berhasil !","success");
		}
		
		public function getPrint_label($id){
			$data = DB::table('m_rack')->where('id', $id)->first();
			$pdf = SnappyImage::loadView('label.label_rak', compact('data'))
			
			->setOption('width', '1500')
			->setOption('height', '900')
			->setOption('quality', 100)
			;
			return $pdf->download('QR Code ' . $data->nomor_rak . '.png');
		}
		
		public function getSave_label($id){
			$files_qr = array();
			foreach ($id as $id_selected) {
				$data = DB::table('m_rack')->where('id', $id_selected)->first();
				$pdf = SnappyImage::loadView('label.label_rak', compact('data'))
				
				->setOption('width', '1500')
				->setOption('height', '900')
				->setOption('quality', 100)
				;
				$pdf->save(public_path('qrbulkrak/QR_'.$data->nomor_rak.'.png', true));
				array_push($files_qr, 'QR_'.$data->nomor_rak.'.png');
			}
			$zipFileName = 'AllQr Rak.zip';
			$zip = new ZipArchive();
			$path = public_path('qrbulkrak/');
			$zip->open($path.$zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
			foreach($files_qr as $file){
				$zip->addFile($path.$file,$file);
			}
			$zip->close();
			foreach($files_qr as $file){
				unlink(public_path('qrbulkrak/'.$file));
			}
		}

		public function getDownloadSavedLabel(){
			$fileName = "Label Qr Rak.zip";
			$zipFileName = 'AllQr Rak.zip';
			$pathToFile = public_path('qrbulkrak/').$zipFileName;
			$headers = ["Content-Type"=>"application/zip"];
			if(is_file($pathToFile)){
				return response()->download($pathToFile, $fileName, $headers);
			}

			CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"Silahkan pilih data dulu utk generate QR !","warning");
		}

		public function getImportXls() {
	    	return view('rak_import');
		}
		
		public function postImportXls() {
	    	ini_set('memory_limit', '256M');
	    	set_time_limit(1000);
	    	$file = Request::file('userfile');
	    	$file->move(public_path('import'),$file->getClientOriginalName());
			$dataimport = Excel::toArray(new RakImport, public_path('import/'.$file->getClientOriginalName()));
			$listNomorRak = [];
			$btnBack = '<br/><button style="cursor: pointer;"><a href="'.CRUDBooster::mainpath('').'" style="text-decoration:none;">&laquo; Kembali</a></button>';
			for ($i=0; $i < count($dataimport[0]); $i++) { 
				$rowRak = trim($dataimport[0][$i]["nomor_rak"]);
				if($rowRak == null || $rowRak == ""){
					continue;
				}
				$rowRak = str_replace(" ","", $rowRak);
				array_push($listNomorRak, $rowRak);
			}
			$listExisting = [];
			if(count($listNomorRak) > 0){
				$listExisting = DB::table('m_rack')->whereIn("nomor_rak", $listNomorRak)->get(["nomor_rak"])->pluck("nomor_rak")->toArray();
			}else{
				echo '<b>Data import tidak boleh kosong !</b>';
				echo $btnBack;
				exit;	
			}
			$no = 0;
			DB::beginTransaction();
			$isError = false;
			try {
				foreach($dataimport[0] as $row) {
					if($row['nomor_rak'] == null || $row['nomor_rak'] == ""){
						continue;
					}
					$row['nomor_rak'] = str_replace(" ","", $row['nomor_rak']);
					$no++;
					if(in_array($row["nomor_rak"], $listExisting)){
						DB::rollback();
						echo '#'.$no.' | '.$row['nomor_rak'].' | Error, Nomor Rak sudah ada !<br/>';
						echo '<br/><b>Semua data sebelumnya tidak akan terimport !</b>';
						$isError = true;
						break;
					}
					DB::table('m_rack')->updateOrInsert($row);
					echo '#'.$no.' | '.$row['nomor_rak'].' | Imported<br/>';
					
				}
			} catch (\Throwable $th) {
				echo 'Something error on row-'.$no;
				$isError = true;
			}
			
			if(!$isError){
				DB::commit();
				echo '<br/><b>Total Imported '.$no.' data !</b>';
			}
			echo $btnBack;
		}
	    //By the way, you can still create your own method in here... :) 


	}