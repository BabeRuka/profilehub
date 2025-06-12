<?php

namespace BabeRuka\ProfileHub\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use BabeRuka\ProfileHub\Models\UserProfiles;
class ForceProfileUpdate
{
    /**
     * Handle an incoming request.
     *
    **/
    public function handle(Request $request, Closure $next)
    {
        $user_profile = new UserProfiles();
        if (Auth::check()) {
            $user = Auth::user();
            $force_profile = $user_profile->where(['user_id' => $user->id, 'pforce' => '1'])->first();
            if ($force_profile != null) {
                if ($force_profile->pforce == 1) {
                    if ($force_profile->num_rows > $force_profile->num_filled) {
                        return redirect()->action('ProfileController@force', ['id' => $user->id]);
                    }
                }
            }
        }
        return $next($request);
    }
}
