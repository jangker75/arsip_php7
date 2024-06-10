<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use App\Http\Middleware\ApiMiddleware;
		use CRUDBooster;

		class ApiCheckAuthController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {   
				$this->middleware(ApiMiddleware::class);   
				$this->table       = "cms_users";
				$this->permalink   = "check_auth";
				$this->method_type = "get";
		    }

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$token = request()->header('token');
				$user = DB::table('cms_users')
				->select(['cms_users.id','name','photo','email', 'client.nama as client_name',
				'client.id as client_id', 'attachment_pks','id_cms_privileges'])
				->leftjoin('client', 'client.id','=','cms_users.client_id')
				->where('token', $token)->first();
				$role = DB::table('cms_privileges')->select('name')
				->where('id',$user->id_cms_privileges)->first();
				$user->client_name ??= 'MDS';
				$user->client_id ??= 1;
				$user->photo = ($user->photo == null) ? 'https://icon-library.com/images/no-image-icon/no-image-icon-20.jpg' : url($user->photo);
				$user->attachment_pks = ($user->attachment_pks != null) ? url($user->attachment_pks) : 'https://st4.depositphotos.com/14953852/24787/v/600/depositphotos_247872612-stock-illustration-no-image-available-icon-vector.jpg';
				$split = explode('.',$user->attachment_pks);

				$user->pks_name = "PKS_".str_replace(" ",'',$user->client_name). ".". $split[count($split) - 1];
				$user->role = $role->name;
				$response['api_status'] = 1;
				$response['api_message'] = 'Already Login';
				$response['data'] = $user;

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