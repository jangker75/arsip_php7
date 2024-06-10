<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use App\Http\Middleware\ApiMiddleware;
		use CRUDBooster;

		class ApiUpdateFotoBoxController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->middleware(ApiMiddleware::class);   
				$this->table       = "box";        
				$this->permalink   = "update_foto_box";    
				$this->method_type = "post";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$boxId = g("box_id");
				$requestType = strtoupper(g("request_type"));
				$response['api_status'] = 1;
				$response['api_message'] = 'success';
				$response["api_authorization"] = "You are in debug mode !";
				$response["msg"] = "Gagal update";
				if ($requestType == "U") {
					$date = date('Y-m-d');
					$path = "uploads/foto_arsip/" . $date;
					for ($i=1; $i < 4; $i++) {
						$foto = Request::file("foto_{$i}");
						if($foto != null && $foto != ''){
							$extension = $foto->getClientOriginalExtension();
							$poto = rand(11111, 99999) . "." . $extension;
							$foto->move($path, $poto);
							$update["foto_{$i}"] = $path . '/' . $poto;
							DB::table('box')->where('id', $boxId)->update($update);
						}
					}
					$response["msg"] = "Update foto berhasil";
				}elseif($requestType == "D"){
					$foto = g("foto_ke");
					if($foto != null && $foto != ''){
						$update["foto_{$foto}"] = null;
						DB::table('box')->where('id', $boxId)->update($update);
					}
					for ($i=1; $i < 4; $i++) {
						if($foto != null && $foto != ''){
						}
					}
					$response["msg"] = "Delete foto berhasil";
				}
				
				// $response['data'] = $data;
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