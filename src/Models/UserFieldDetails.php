<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Request;

class UserFieldDetails extends Model
{
    protected $table = 'user_field_details';
    protected $primaryKey = 'details_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    public function __construct()
    {
        $request = Request::instance();
        $request->request->all();
    }

 
    public function user(){
        return $this->belongsTo('BabeRuka\ProfileHub\Models\User', 'id');
    }
    public function user_field_table()
    {
        return $this->belongsTo('BabeRuka\ProfileHub\Models\UserField','field_id');
    }
    public function user_field_son_table()
    {
        return $this->belongsTo('BabeRuka\ProfileHub\Models\UserFieldSon','user_entry');
    } 
   

    public function index()
    {
        $roles = DB::table('user_field_details')
            ->leftJoin('role_hierarchy', 'roles.id', '=', 'role_hierarchy.role_id')
            ->select('roles.*', 'role_hierarchy.hierarchy')
            ->orderBy('hierarchy', 'asc')
            ->get();
        return $roles;
    }
    public function getAllRequests()
    {
        $request = Request::instance();
        return $request->request->all();
    }
    /*

    search for records in user details tables

    */
    public function anyUser($user_id = false)
    {
        $user_query = ($user_id ? " AND user_id = '" . $user_id . "' " : '');
        $users = DB::select('SELECT * FROM `users` WHERE user_id > 0 ' . $user_query . ' ');
        return $users;
    }
    public function user_field($field_id = false, $group_id = false, $sequence = false, $sequence_name = false)
    {
        if ($group_id > 0) {
            $query = 'SELECT `user_field`.*,
                (SELECT COUNT(son_id) FROM `user_field_son` WHERE `user_field_son`.field_id=`user_field`.field_id) AS num_sons,
                (SELECT group_name FROM `user_field_groups` WHERE `user_field_groups`.group_id=`user_field`.group_id) AS group_name, (SELECT group_icon FROM `user_field_groups` WHERE `user_field_groups`.group_id=`user_field`.group_id) AS group_icon FROM `user_field`
                WHERE `user_field`.group_id = '.$group_id;
        } else if ($sequence > 0) {
            $coll_name = '`user_field`.sequence'; //($sequence_name ? '`user_field`.' . $sequence_name . '' : '`user_field`.sequence');
            $query = 'SELECT `user_field`.*,
                (SELECT COUNT(son_id) FROM `user_field_son` WHERE `user_field_son`.field_id=`user_field`.field_id) AS num_sons,
                (SELECT group_name FROM `user_field_groups` WHERE `user_field_groups`.group_id=`user_field`.group_id) AS group_name, (SELECT group_icon FROM `user_field_groups` WHERE `user_field_groups`.group_id=`user_field`.group_id) AS group_icon FROM `user_field`
                WHERE ' . $coll_name . ' =  '.$sequence;
        } else {
            if ($field_id > 0) {
                $query = 'SELECT `user_field`.*,
                (SELECT COUNT(son_id) FROM `user_field_son` WHERE `user_field_son`.field_id=`user_field`.field_id) AS num_sons,
                (SELECT group_name FROM `user_field_groups` WHERE `user_field_groups`.group_id=`user_field`.group_id) AS group_name, (SELECT group_icon FROM `user_field_groups` WHERE `user_field_groups`.group_id=`user_field`.group_id) AS group_icon FROM `user_field`
                WHERE `user_field`.field_id = '.$field_id;
            } else {
                $query = ' SELECT `user_field`.*,
                (SELECT COUNT(son_id) FROM `user_field_son` WHERE `user_field_son`.field_id=`user_field`.field_id) AS num_sons,
                (SELECT group_name FROM `user_field_groups` WHERE `user_field_groups`.group_id=`user_field`.group_id) AS group_name, (SELECT group_icon FROM `user_field_groups` WHERE `user_field_groups`.group_id=`user_field`.group_id) AS group_icon
                FROM `user_field` ORDER BY group_id, group_sequence, sequence ASC '; 
            }
        }
        $field_types = DB::select($query);
        return $field_types;
    }
    public function user_field_type()
    {
        $field_types = DB::select('SELECT * FROM `user_field_type`');
        return $field_types;
    }
    public function user_field_son($field_id = false, $son_id = false)
    {
        if ($son_id > 0) {
            $field_types = DB::select('SELECT * FROM `user_field_son` WHERE son_id = ?', [$son_id]);
        } else {
            if ($field_id > 0) {
                $field_types = DB::select('SELECT * FROM `user_field_son` WHERE field_id = ?', [$field_id]);
            } else {
                $field_types = DB::select('SELECT * FROM `user_field_son`');
            }
        }
        return $field_types;
    }

    public function user_fieldson_data($field_id = false, $son_id = false)
    {
        if ($son_id > 0) {
            $field_types = DB::select('SELECT * FROM `user_field_son` WHERE son_id = ?', [$son_id]);
        } else {
            if ($field_id > 0) {
                $field_types = DB::select('SELECT * FROM `user_field_son` WHERE field_id = ?', [$field_id]);
            } else {
                $field_types = DB::select('SELECT * FROM `user_field_son`');
            }
        }
        return $field_types;
    }

    public function user_field_details($field_id = false, $user_id)
    {
        $field_query = ($field_id ? " AND field_id = '" . $field_id . "' " : '');
        $field_types = DB::select(" SELECT * FROM `user_field_details` WHERE `user_id` = '" . $user_id . "' " . $field_query . " ");
        return $field_types;
    }
    public function user_field_groups($field_id = false)
    {
        $field_types = DB::select('SELECT * FROM `user_field_groups`');
        return $field_types;
    }
    public function one_user_field_details($field_id = false, $user_id)
    {
        $parent = $this->user_field($field_id);
        $field_query = ($field_id ? " AND field_id = '" . $field_id . "' " : '');
        $results = DB::select(" SELECT * FROM `user_field_details` WHERE `user_id` = '" . $user_id . "' " . $field_query . " ");
        if (collect($results)->first()) {
            if ($parent[0]->type_field == 'dropdown') {
                $son = $this->user_field_son($field_id, $results[0]->user_entry);
                return $son[0]->translation;
            } else {
                return $results[0]->user_entry;
            }
        } else {
            return null;
        }
    }

    public function one_userfield_details_data($field_id, $son_id, $sequence, $user_id)
    {
        $query = " SELECT * FROM `user_field_details_data` WHERE `user_id` = '" . $user_id . "' AND field_id = '" . $field_id . "' AND son_id = '" . $son_id . "' AND sequence = '" . $sequence . "' ";
        $results = DB::select($query);
        if (collect($results)->first()) {
           return $results[0]->user_entry;
        } else {
            return null;
        }
    }

    public function get_anything($field_id = false, $user_id)
    {
        $field_query = ($field_id ? " AND field_id = '" . $field_id . "' " : '');
        $field_types = DB::select(" SELECT * FROM `user_field_details` WHERE `user_id` = '" . $user_id . "' " . $field_query . " ");
        return $field_types;
    }
    
    public function up_user($user_id)
    {
        $request = Request::instance();
        $request->request->all();
        DB::table('users')
            ->where('id', $request->post('user_id'))
            ->update([
                'user_id' => $request->post('user_id'),
                'name' => $request->post('name'),
                'email' => '' . $request->post('email') . '',
                'modified_date' => NOW()
            ]);
    }

    public function up_user_field($request)
    {
        $request = Request::instance();
        $request->request->all();
        DB::table('user_field')
            ->where('field_id', $request->post('field_id'))
            ->update([
                'type_field' => $request->post('type_field'),
                'group_id' => $request->post('group_id'),
                'sequence' => $request->post('sequence'),
                'translation' => '' . $request->post('translation') . '',
                'modified_date' => NOW()
            ]);
    }

    public function up_user_field_son($request)
    {
        $request->request->all();
        DB::table('user_field_son')
            ->where('son_id', $request->post('son_id'))
            ->update([
                'translation' => $request->post('translation'),
                'field_type' => ($request->post('field_type') ? $request->post('field_type') : 'text'),
                'modified_date' => NOW()
            ]);
    }
    public function up_user_field_details($field_id = false, $user_id = false, $user_entry = false)
    {
        $request = Request::instance();
        $request->request->all();
        $user_entry = ($user_entry ? $user_entry : $request->post('user_entry'));
        $query = " UPDATE `user_field_details` SET  `user_entry` = '" . $user_entry . "',  `modified_date` = NOW()
        WHERE `user_id` = '" . ($user_id ? $user_id : $request->post('user_id')) . "' AND field_id = '" . ($field_id ? $field_id : $request->post('field_id')) . "' ";
        $field_types = DB::select($query);
        return $field_types;
    }
    public function up_user_group($request)
    {
        $request = Request::instance();
        $request->request->all();
        DB::table('user_field_groups')
            ->where('group_id', $request->post('group_id'))
            ->update(['type_group' => 'Section', 'group_name' => $request->post('group_name'), 'group_icon' => $request->post('group_icon'), 'modified_date' => NOW()]);
    }
    public function up_anything($table_name, $primary_key, $primary_key_value, $update_name, $update_name_value)
    {
        $request = Request::instance();
        $request->request->all();
        DB::table($table_name)
            ->where($primary_key, $primary_key_value)
            ->update([$update_name => $update_name_value, 'modified_date' => NOW()]);
    }
    

    public function add_user_field($request)
    {
        //group_id;
        $request = Request::instance();
        $request->request->all();
        $field_id = DB::table('user_field')->insertGetId(
            [
                'type_field' => $request->post('type_field'),
                'lang_code' => 'eng',
                'group_id' => $request->post('group_id'),
                'translation' => $request->post('translation'),
                'sequence' => 1,
                'create_date' => NOW(),
                'modified_date' => NOW()
            ]
        );
        if ($field_id > 0) {
            DB::update('UPDATE user_field SET id_details = ' . $field_id . ' WHERE field_id = ?', [$field_id]);
        }
        return $field_id;
    }
    public function add_user_field_type($request)
    {
        $type_id = DB::table('user_field_type')->insertGetId(
            [
                'type_field' => $request->post('type_field'),
                'type_file' => $request->post('type_file'),
                'type_class' => $request->post('type_class'),
                'type_category' => $request->post('type_category'),
                'create_date' => NOW(),
                'modified_date' => NOW()
            ]
        );
        return $type_id;
    }
    public function add_user_field_son($request,$sequence)
    {

        $request->request->all();
        $son_id = DB::table('user_field_son')->insertGetId(
            [
                'field_id' => $request->post('field_id'),
                'lang_code' => 'eng',
                'translation' => $request->post('translation'),
                'field_type' => ($request->post('field_type') ? $request->post('field_type') : 'text'),
                'sequence' => $sequence,
                'create_date' => NOW(),
                'modified_date' => NOW()
            ]
        );
        return $son_id;
    }
    public function add_user_field_details($field_id, $user_id, $user_entry)
    {
        $request = Request::instance();
        $request->request->all();
        $details_id = DB::table('user_field_details')->insertGetId(
            [
                'field_id' => ($field_id ? $field_id : $request->post('field_id')),
                'user_id' => ($user_id ? $user_id : $request->post('user_id')),
                'user_entry' => ($user_entry ? $user_entry : $request->post('user_entry')),
                'details_data' => serialize($request->post),
                'create_date' => NOW(),
                'modified_date' => NOW()
            ]
        );
        return $details_id;
    }
    public function add_user_group($request)
    {
        $request = Request::instance();
        $request->request->all();
        $field_id = DB::table('user_field_groups')->insertGetId(
            [
                'group_name' => $request->post('group_name'),
                'group_icon' => $request->post('group_icon'),
                'type_group' => 'Section',
                'sequence' => 1,
                'create_date' => NOW(),
                'modified_date' => NOW()
            ]
        );
        return $field_id;
    }

   

    public function down_user_field($field_id = false)
    {
        $request = Request::instance();
        $request->request->all();
        $field_id = ($field_id > 0 ? $field_id : $request->post('field_id'));
        DB::table('user_field')->where('field_id', $field_id)->delete();
    }
    public function down_user_field_type($type_id = false)
    {
        $request = Request::instance();
        $request->request->all();
        DB::table('user_field_type')->where('type_id', ($request->post('type_id') ? $request->post('type_id') : $type_id))->delete();
    }
    public function down_user_field_son($son_id = false)
    {
        $request = Request::instance();
        $request->request->all();
        DB::table('user_field_son')->where('son_id', ($son_id ? $son_id : $request->post('son_id')))->delete();
    }
    public function down_user_field_details($details_id = false)
    {
        $request = Request::instance();
        $request->request->all();
        DB::table('user_field_details')->where('details_id', ($request->post('details_id') ? $request->post('details_id') : $details_id))->delete();
    }
    public function down_user_group($group_id = false)
    {
        $request = Request::instance();
        $request->request->all();
        $group_id = ($group_id > 0 ? $group_id : $request->post('group_id'));
        DB::table('user_field_groups')->where('group_id', $group_id)->delete();
    }
    function requiredUserCollumns()
    {
        return array('email','password');
    }
    function son_sequence($field_id)
    {
        $UserFieldSon = new UserFieldSon();
        $last_son = $UserFieldSon->where('field_id',$field_id)->orderBy('sequence','desc')->get();
        if($last_son->first()){
            $son = $last_son->first();
            if(!$son->sequence()){
                return 1;
            }
            $sequence = $son->sequence();
            $sequence = $sequence + 1;
            return $sequence;
        }
        return 1;

    }
}
