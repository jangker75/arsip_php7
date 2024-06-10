<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use Session;
		use Request;
		use DB;
		use CRUDBooster;
		use Illuminate\Support\Str;
		use Illuminate\Support\Facades\Cache;
		use Hash;
		class ApiLoginController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "cms_users";        
				$this->permalink   = "login";    
				$this->method_type = "post";    
		    }

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
			
				$email = g('email');
				$password = g('password');
				$user = DB::table('cms_users')->where('email',$email)->first();
				if ($email && $password) {
					if(!Hash::check($password, $user->password)){
						$response['api_status']  = 0;
						$response['api_message'] = 'Username atau password tidak terdaftar';
					}else{
						$datenow = date('Y-m-d H:i:s');
						// $tokenCode = Hash::make($user->name . $datenow);
						$tokenCode = str_random(16);
						$response['api_status']    = 1;
						$response['api_message']   = 'Login berhasil, Anda login sebagai '.$user->name.'';
						$response['token'] = $tokenCode; 
						// Guide longtime
						//1 hour = 60 * 60
						//1 day = 60 * 60 * 24
						//1 Week = 60 * 60 * 24 * 7
						$longtime = env("TOKEN_APPS_TIME", 60 * 60);
						// $longtime = 60 * 60 * 24;

						$token_expired = Carbon::parse($datenow)->addSeconds($longtime);
						DB::table('cms_users')->where('email',$email)->update([
							'token' => $tokenCode,
							'token_expired' => $token_expired,
						]);
						// Cache::put("api_token_".$tokenCode, $user->id, $longtime); // We set the value of this cache with ID
					}
				} else {
					$response['api_status']  = 0;
					$response['api_message'] = 'password dan nik tidak boleh kosong';
				}
				response()->json($response)->send();
				exit();
		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query

		    }

		    public function hook_after($postdata,&$result) {
		        //This method will be execute after run the main process
				
		    }

		}