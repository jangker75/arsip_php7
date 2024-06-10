<?php namespace App\Http\Controllers;

use App\Http\Middleware\ApiMiddleware;
		use Session;
		use Request;
		use DB;
		use CRUDBooster;
		use Hash;

		class ApiChangePasswordController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->middleware(ApiMiddleware::class);  
				$this->table       = "cms_users";        
				$this->permalink   = "change_password";    
				$this->method_type = "post";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
		        $old_pass=g('old_pass');
		        $new_pass=g('new_pass');
		        $userId = Request::get('user')->id;

		        //Mengambil data users yang sesuai dengan parameter id
		    	$query=DB::table('cms_users')
		    	->where('id',$userId)
		    	->first();
		    	//
		    	if (empty($query)) {
		    		//Kondisi jika id users tidak terdaftar
		    		$response['api_status']=0;
		    		$response['api_message']='User belum terdaftar';
		    		response()->json($response)->send();
		    		exit();
		    		//
		    	}else{

			    	if (!Hash::check($old_pass, $query->password )) {
			    		//Kondisi jika password dari parameter tidak sama dengan password dari data users
			    		$response['api_status']=0;
		    			$response['api_message']='Password lama anda salah';
		    			response()->json($response)->send();
		    			exit();
		    			//
			    	}else{
			    		//Menambahkan array data untuk mengubah password berdasarkan id users dari parameter
			    		$data=array(
				    		'password'=>Hash::make($new_pass)
				    	);
				    	$kw=DB::table('cms_users')->where('id',$userId)
				    	->update($data);
				    	//
				    	if ($kw) {
				    		//kondisi jika id users di parameter ada di data users
				    		$response['api_status']=1;
			    			$response['api_message']='Berhasil mengubah password';
							$response['nama_user']=$query->name;
			    			response()->json($response)->send();
			    			exit();
			    			//
				    	}else{
				    		//kondisi jika id users di parameter tidak ada di data users
				    		$response['api_status']=0;
			    			$response['api_message']='Gagal mengubah password';
			    			response()->json($response)->send();
			    			exit();
			    			//
				    	}

			    	}

		    	}
		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query

		    }

		    public function hook_after($postdata,&$result) {
		        //This method will be execute after run the main process

		    }

		}