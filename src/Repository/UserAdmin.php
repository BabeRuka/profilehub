<?php

namespace BabeRuka\ProfileHub\Repository;
use ArrayObject;
use Collection;
use DB;

class UserAdmin
{
    
    function admin_pages(){
        $inputs = array(
            'User Dashboard' => 'user_dashboard',
            'Profile Dashboard' => 'profile_dashboard',
            'Profile Management' => 'profile_management',
            'User Registration' => 'user_registration',
            'Force Profile Completion' => 'force_profile',
            'Admin Dashboard' => 'admin_dashboard',
            'Public Page' => 'public_page',
        );
        //$finputs = $inputs;
        return collect($inputs);
     }
     function widget_types(){
         return [
            'public' => 'Public',
            'admin' => 'Admin',
            'user' => 'User',
            'profile' => 'Profile'
         ];
     }
    function user_data_summary(){
        $query = " SELECT (COUNT(DISTINCT(id))) AS num_users,(SELECT COUNT(DISTINCT(id)) FROM `users` WHERE deleted_at IS NULL) AS num_active,
        (SELECT COUNT(DISTINCT(id)) FROM `users` WHERE deleted_at IS NOT NULL) AS num_suspended,
        (SELECT COUNT(DISTINCT(id)) FROM `users` WHERE last_seen > NOW() - INTERVAL 15 MINUTE) AS online_users,
        0 AS num_admins,
        0 AS num_students  FROM `users` ";
        $all_results = DB::select(DB::raw($query));
        return collect($all_results);
    }
   

    function settings_data_summary(){
        $query = " SELECT count(distinct `id`) AS `num_roles`, 0 AS num_apis,
        0 AS num_menus,
        (SELECT COUNT(DISTINCT module_id) FROM `page_modules`) AS num_modules FROM `roles` ";
        $all_results = DB::select(DB::raw($query));
        return collect($all_results);
    }
 
 
}
