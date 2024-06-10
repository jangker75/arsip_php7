<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public $attributes;
    public function handle($request, Closure $next)
    {
        if($request->header("token")) {
            $user = DB::table('cms_users')->where('token', $request->header('token'))
            ->where('token_expired','>=', now())->first();
            if(!$user){
                return response()->json([
                    'api_status'=> 0,
                    'api_message'=>'token invalid'
                ]);
            }
            $request->attributes->add(['user' => $user]);
            // if(!Cache::has("api_token_".$request->header("token"))) {
            //      return response()->json([
            //         'api_status'=> 0,
            //         'api_message'=>'token invalid'
            //     ]);
            //  }
             return $next($request);
        }else{
            return response()->json(['api_status'=> 0,'api_message'=>'token invalid']);
        }
    }
}
