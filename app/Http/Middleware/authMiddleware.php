<?php

namespace App\Http\Middleware;

use Closure;
use App\User as User;

class authMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd(base64_encode(($request->_e)));
        // dd(base64_decode(($request->_e)));
        // dd($request->all());
        // dd(app()->make('redis')->get('foo'));

        $check = User::where('email', base64_decode($request->_e))->where('remember_token',$request->_token)->count('name');

        if($check <= 0 or empty($_SERVER['HTTP_ORIGIN'])){
            return response('Unauthorized.', 401);            
        }

        // return $next($request);
        return $next($request)
        ->header('Access-Control-Allow-Origin', $_SERVER['HTTP_ORIGIN'])
        ->header('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE')
        ->header('Access-Control-Allow-Headers', 'Accept, Content-Type,X-CSRF-TOKEN')
        ->header('Access-Control-Allow-Credentials', 'true');



        //issue API :
        //1. lumen-enable-cors
    }
}
