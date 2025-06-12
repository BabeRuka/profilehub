<?php

namespace BabeRuka\ProfileHub\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use BabeRuka\ProfileHub\Models\UserDetails;
use Auth;
use Session;

class InitiateSession
{
    /**
     * Handle an incoming request.
     *
     **/
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('initialized')) {
            $user = Auth::user();
            $UserDetails = new UserDetails();
            $details = $UserDetails->where(['user_id' => $user->id])->first();
            if (!$details) {
                if (isset(Auth::user()->name)) {
                    session(['name',Auth::user()->name]);
                }
                if (isset(Auth::user()->email)) {
                    session(['email ', Auth::user()->email]);
                }
                if (isset(Auth::user()->created_at)) {
                    session(['created_at ', Auth::user()->created_at]);
                }
                if (isset(Auth::user()->updated_at)) {
                    session(['last_seen ', Auth::user()->updated_at]);
                }
            } else {
                session(['initialized' => true, 'start_time' => now()]);
                session(['last_activity' => time()]); 
                $user_id = Auth::user()->id;
                if (isset($user_id)) {
                    session(['user_id', $user_id]);
                }
                if (isset($details->username)) {
                    session(['username', $details->username]);
                }
                if (isset($details->firstname)) {
                    session(['firstname', $details->firstname]);
                }
                if (isset($details->lastname)) {
                    session(['lastname', $details->lastname]);
                }
                if (isset(Auth::user()->name)) {
                    session(['name',Auth::user()->name]);
                }
                if (isset(Auth::user()->email)) {
                    session(['email ', Auth::user()->email]);
                }
                if (isset(Auth::user()->created_at)) {
                    session(['created_at ', Auth::user()->created_at]);
                }
                if (isset(Auth::user()->updated_at)) {
                    session(['last_seen ', Auth::user()->updated_at]);
                }
                if (isset($details->profile_pic)) {
                    session(['profile_pic ', $details->profile_pic]);
                }
                if (isset($details->user_avatar)) {
                    session(['profile_pic ', $details->user_avatar]);
                }
            }
        }
        return $next($request);
    }
}