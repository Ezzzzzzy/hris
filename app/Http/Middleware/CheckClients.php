<?php

namespace App\Http\Middleware;

use App\Models\Client;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckClients
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
        
        // print($reques);
        // die();
        // $user = Auth::user();
        // print($user->);
        // die();
        if(count($request->permissions['client_access']) !== 0){
            foreach($request->permissions['clients_access'] as $client_permission){
                if($client_permission == $request->client_id){
                    return $next($request);
                }
            }
        }
        abort(403, "You dont have the permission to access client ".$request->client_id );

    }
}
