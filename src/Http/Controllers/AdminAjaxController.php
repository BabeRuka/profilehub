<?php

namespace BabeRuka\ProfileHub\Http\Controllers;

use Illuminate\Http\Request;
use BabeRuka\ProfileHub\Repository\UserFunctions;
use App\Models\Users; 
use Auth; 
use DB;
use Illuminate\Support\Facades\Validator;  

class AdminAjaxController extends Controller
{
    public $request;
    private $module_id;
    public $module_name;
    public $module_slug;
    public $page_title;

    public function __construct()
    { 
		$request = new Request();
        $this->request = $request;
        $this->module_id = 9;
        $this->module_name = 'Lesson Management';
        $this->module_slug = '_LESSON_MANAGEMENT';
        $this->page_title = $this->module_name;
    }
    public function index()
    {
        $this->checkPageRole('view',$this->module_slug);
    }
    public function userdetailsAjax()
    {
        $this->checkPageRole('view',$this->module_slug);
    }
    public function getCourseFolders()
    {
        $this->checkPageRole('view',$this->module_slug);
        $lms = new LmsFunctions();
        $org_data = $lms->getAllOrgItemsQuery(session('course_id'));
        $items = $lms->treeToList($org_data);
        $folders = $lms->renderMenu($items);
        return response()->json(array('msg' => $folders), 200);
    }
    public function getUserGroups(Request $request){
        $query = " SELECT
        (SELECT lgc.group_id FROM `lms_group_users` AS lgc WHERE lgc.user_id = `users`.user_id AND lgc.group_id = ".$request->post('group_id')." ) AS group_id,
        (SELECT lgc.user_id FROM `lms_group_users` AS lgc WHERE lgc.user_id = `users`.user_id AND lgc.group_id = ".$request->post('group_id')." ) AS grouped_id,
        `users`.* FROM `users` WHERE `user_id` > 0 ";
        $all_users = DB::select(DB::raw($query));
        //echo $query;
        $check = "checkAll(this.checked,'user_id[]');";
        $div = '<table class="table table-responsive-sm table-condensed table-striped js-exportable" id="groupUserTable">
        <thead>
            <tr>
                <th>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" onClick="'.$check.'">
                        </label>
                    </div>
                </th>
                <th>User Name </th>
                <th>Names </th>
                <th>Email </th>
                <th> </th>
            </tr>
        </thead>
        <tbody>';
                if(count($all_users) > 0){
                    foreach($all_users as $user){
                        $checked = ($user->user_id == $user->grouped_id ? 'checked' : '');
                        $del = ($user->user_id == $user->grouped_id ? ' <button type="button"
                        class="btn btn-danger deleteFunc" data-bb-example-key="confirm-options"
                        data-key="dcgf" data-pidv="'.$user->group_id.'" data-fidv="'.$user->user_id.'" data-func="dynamic"
                        data-formid="DeleteCourseGroupForm">
                        <i class="c-icon c-icon-2xs cil-x-circle active"></i></button>' : '');
                        $div .= '
                            <tr>
                                <td>
                                    <div class="form-group form-check">
                                        <label class="form-check-label">
                                        <input class="form-check-input checkboxRequired" type="checkbox" name="user_id[]" value="'.$user->user_id.'" '.$checked.' required>
                                        <div class="form-group-messages"></div>
                                        </label>
                                    </div>
                                </td>
                                <td>'.$user->username.'</td>
                                <td>'.$user->firstname.' '.$user->lastname.'</td>
                                <td>'.$user->email.'</td>
                                <td>
                                    '.$del.'
                                </td>
                            </tr>';
                    }
                }
                $div .=
        '</tbody>
            <tfoot>
                <th><div id="checkboxGroup"></div></th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tfoot>
        </table>';
        echo $div;
    }
    //getCourseGroups
    public function getCourseGroups(Request $request){
        $this->checkPageRole('view',$this->module_slug);
        $query = " SELECT
        (SELECT ugc.group_id FROM `lms_group_courses` AS ugc WHERE ugc.course_id = `lms_course`.course_id AND ugc.group_id = ".$request->post('group_id')." ) AS group_id,
        (SELECT ugc.course_id FROM `lms_group_courses` AS ugc WHERE ugc.course_id = `lms_course`.course_id AND ugc.group_id = ".$request->post('group_id')." ) AS grouped_id,
        `lms_course`.* FROM `lms_course` WHERE `course_id` > 0 ";
        $all_courses = DB::select(DB::raw($query));
        //echo $query;
        $check = "checkAll(this.checked,'course_id[]');";
        $div = '<table class="table table-responsive-sm table-condensed table-striped js-exportable" id="groupCourseTable">
        <thead>
            <tr>
                <th>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" onClick="'.$check.'">
                        </label>
                    </div>
                </th>
                <th>Course Name </th>
                <th>Course Type </th>
                <th> </th>
            </tr>
        </thead>
        <tbody>';
                if(count($all_courses) > 0){
                    foreach($all_courses as $course){
                        $checked = ($course->course_id == $course->grouped_id ? 'checked' : '');
                        $del = ($course->course_id == $course->grouped_id ? ' <button type="button"
                        class="btn btn-danger deleteFunc" data-bb-example-key="confirm-options"
                        data-key="dcgf" data-pidv="'.$course->group_id.'" data-fidv="'.$course->course_id.'" data-func="dynamic"
                        data-formid="DeleteCourseGroupForm">
                        <i class="c-icon c-icon-2xs cil-x-circle active"></i></button>' : '');
                        $div .= '
                            <tr>
                                <td>
                                    <div class="form-group form-check">
                                        <label class="form-check-label">
                                        <input class="form-check-input checkboxRequired" type="checkbox" name="course_id[]" value="'.$course->course_id.'" '.$checked.' required>
                                        <div class="form-group-messages"></div>
                                        </label>
                                    </div>
                                </td>
                                <td>'.$course->course_name.'</td>
                                <td>'.$course->course_type.'</td>
                                <td>
                                    '.$del.'
                                </td>
                            </tr>';
                    }
                }
                $div .=
        '</tbody>
            <tfoot>
                <th><div id="checkboxGroup"></div></th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tfoot>
        </table>';
        echo $div;
    }
    public function validateUserdetail(Request $request)
    {
        $users = new Users(); 
        if ($request->post('username')) {
            //$found_user = $users->where('username', $request->post('username'))->orWhere('email', $request->post('email'))->first();
            $query = " SELECT `id` FROM `users` WHERE `username` = '" . $request->post('username') . "' OR `email` = " . $request->post('email') . " ";
            $fuq = DB::select(DB::raw($query));
            $found_user = count($fuq);
            if ($found_user) {     
                echo 'username-found';
            }else{
                echo 'valid';      
            }  
        }
        if ($request->post('email')) { 
            $validator = Validator::make($request->all(), [
                'email' => 'email:rfc,dns',
            ]);
            //$found_user = $users->where('email', $request->post('email'))->orWhere('username', $request->post('username'))->first();
            $query = " SELECT `id` FROM `users` WHERE `email` = '" . $request->post('email') . "' OR `username` = " . $request->post('username') . " ";
            $fuq = DB::select(DB::raw($query));
            $found_user = count($fuq);
            if ($found_user) {
                echo 'email-found';
            }else{
                echo 'valid';
            } 
        }
        
    }
    public function classes(Request $request){
        $res = '';
        $classes = new LmsEventClass();
        $manager = new LmsEventManager();
        $manager = $manager->all();
        if(count($manager) > 0){
            $class_id = array();
            foreach($manager as $value) {
                $class_id[] = $value->class_id;
            }
            $class = $classes->where(['group_id' => $request->post('group_id')])->whereNotIn('class_id',$class_id)->get();
        }else{
            $class = $classes->where(['group_id' => $request->post('group_id')])->get();
        }
        if(count($class) > 0){
            foreach($class as $cn){
                $res .= '<option value="'.$cn->class_id.'">'.strtoupper($cn->class_name).'</option>';
            }
        }
        echo $res;
    }
    public function checkNotification(Request $request){
        //dd($request->post());
        $lms_events = new LmsEvent();
        $event = $lms_events->find($request->post('event_id'));
        if($event->event_id){
            $event->event_status = 'read';
            $event->event_read_at = date('Y-m-d H:i:s');
            $event->save();
            // get previous user id
            $previous = $lms_events->where('event_id', '<', $event->event_id)->max('event_id');
            // get next user id
            $next = $lms_events->where('event_id', '>', $event->event_id)->min('event_id');
            $event_type = "'".$event->event_type."'";
            $div_ids = ($event->event_type=='notification' ? 'notificationListActions,notification,notificationUl,notificationCount,notifications,NO' : 'messageListActions,message,messagesUl,messagesCount,messages,ME');
            $nextQ = ($next > 0 ? '<button type="button" onclick="nextNotification('.$next.','.$event_type.','.$div_ids.')" class="btn btn-primary">Next</button>;' : '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>');
            //foreach($lms_events as $event){
                echo '
                    <div class="modal-header solid">
                        <h4 class="modal-title" id="notificationModalTitle">'.$event->event_title.'</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <input type="hidden" id="notification_eventid" value="'.$event->event_id.'" />
                        <input type="hidden" id="next_eventid" value="'.$next.'" />
                    </div>
                    <!-- start modal-body -->
                    <div class="modal-body solid" id="notificationModalBody">
                        '.$event->event_desc.'
                    </div>
                    <!-- end modal-body -->

                    <!-- start modal-footer -->
                    <div class="modal-footer" id="modal_footer">
                        '.$nextQ.'
                    </div>
                    <!-- end modal-footer -->
                ';
            //}
        }

    }
    public function event(Request $request){
        $lms_events = new LmsEvent();
        $event = $lms_events->find($request->input('event_id'));
        if($event->event_id){
            $event->event_status = 'read';
            $event->event_read_at = date('Y-m-d H:i:s');
            $event->save();
            // get previous user id
            $previous = $lms_events->where('event_id', '<', $event->event_id)->max('event_id');
            // get next user id
            $next = $lms_events->where('event_id', '>', $event->event_id)->min('event_id');
            $event_type = "'".$event->event_type."'";
            $div_ids = ($event->event_type=='notification' ? "'notificationListActions,notification,notificationUl,notificationCount,notifications,NO'" : "'messageListActions,message,messagesUl,messagesCount,messages,ME'");
            $nextQ = ($next > 0 ? '<button type="button" onclick="nextNotification('.$next.','.$event_type.','.$div_ids.')" class="btn btn-primary">Next</button>;' : '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>');
            //foreach($lms_events as $event){
                echo '
                    <div class="modal-header solid">
                        <h4 class="modal-title" id="notificationModalTitle">'.$event->event_title.'</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <input type="hidden" id="notification_eventid" value="'.$event->event_id.'" />
                        <input type="hidden" id="next_eventid" value="'.$next.'" />
                    </div>
                    <!-- start modal-body -->
                        <div class="modal-body solid" id="notificationModalBody">
                            '.$event->event_desc.'
                        </div>
                    <!-- end modal-body -->
                    <!-- start modal-footer -->
                        <div class="modal-footer" id="modal_footer">
                            '.$nextQ.'
                        </div>
                    <!-- end modal-footer -->
                ';
            //}
        }

    }
    public function notificationTitles(Request $request){
        $event_type = $request->input('event_type');
        $event = new LmsEvent();
        $user_id = Auth::id();
        $my_events = $event->where(['user_id'=>$user_id, 'event_type' => $event_type, 'event_status' => 'created' ])->get();
        $notes = 1;
        $lis = '<span class="dropdown-header bg-light py-2"><strong>'.ucwords($event_type).'s</strong></span>';
        if($event_type=='notification'){
            $div_ids = "notificationListActions,notification,notificationUl,notificationCount,notifications,NO";
        }else{
            $div_ids = "messageListActions,message,messagesUl,messagesCount,messages,ME";
        }
        $previous = $my_events->where('event_id', '<', $event->event_id)->max('event_id');
        $next = $my_events->where('event_id', '>', $event->event_id)->min('event_id');
        $nextQ = ($next > 0 ? 1 : 0);
        $event_title = ($next > 0 ? 'eventTitleMod' : 'eventTitle');
        if(count($my_events) > 0){
            foreach ($my_events as $item){
                $url = "".route('admin.ajax.notifications.event',['event_id' => $item->event_id])."";
                $lid = "'notificationList".$notes."'";
                $show_modal = "showNotification('".addslashes($item->event_title)."','".$url."',$item->event_id,'".$div_ids."','".$event_type."')";
                $lis .= '<li class="p-2">
                    <a id="notificationList'.$notes.'" class="notificationList"
                    href="#" data-toggle="modal" data-target="#notificationModal"
                    data-event_id="'.$item->event_id.'"
                    data-event_title="'.$item->event_title.'"
                    data-event_type="'.$event_type.'"
                    data-div_ids = "'.$div_ids.'"
                    data-url="'.$url.'"
                    onclick="'.$event_title.'('.$lid.','.$nextQ.'),'.$show_modal.'" >
                        <div class="container">
                            <div class="row">
                            <div class="col-2">
                                <span class="badge badge-pill badge-success">'.strtoupper(substr($item->event_type,0,2)).'</span>
                            </div>
                            <div class="col-9">
                                <strong>'.ucwords($item->event_title).'</strong>
                                <small><strong>'.ucwords($item->created_at).'</strong></small>
                            </div>
                            </div>
                        </div>
                    </a>
                </li>
                <div class="dropdown-divider"></div>';

                $notes++;
            }
            $all_divs = explode(",",$div_ids);
            $strings = "'".$all_divs[0]."','".$all_divs[1]."','".$all_divs[2]."','".$all_divs[3]."','".$all_divs[4]."'";
            $lis .= '<div class="text-center" id="'.$all_divs[0].'">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <a onclick="clearNotifications('.$strings.')" class="btn btn-primary active btn-sm btn-block btn-outline-primary">clear all</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
        }else{
            $lis .= '<li class="p-2">
                        <a href="#" >
                            <div class="container">
                                <div class="row">
                                <div class="col-2">
                                    <span class="badge badge-pill badge-danger">NO</span>
                                </div>
                                <div class="col-9">
                                    <strong>No Notifications</strong>
                                </div>
                                </div>
                            </div>
                        </a>
                    </li>';
        }

        echo $lis;
    }
    public function notificationCounts(Request $request){
        $event_type = $request->input('event_type');
        $event = new LmsEvent();
        $user_id = Auth::id();
        $my_events = $event->where(['user_id'=>$user_id, 'event_type' => $event_type, 'event_status' => 'created' ])->get();
        echo (count($my_events) > 0 ? '<span class="badge badge-pill badge-danger">'.count($my_events).'</span>' : '<span class="badge badge-pill badge-success">0</span>');
    }
    public function nextNotification(Request $request){
        //dd($request->post());
    }
    public function notificationClear(Request $request){
        $event_type = $request->input('event_type');
        $event = new LmsEvent();
        $user_id = Auth::id();
        $my_events = $event->where(['user_id'=>$user_id, 'event_type' => $event_type, 'event_status' => 'created'])->get();
        if(count($my_events) > 0){
            foreach ($my_events as $item){
                $newevent = new LmsEvent();
                $found_event = $newevent->find($item->event_id);
                $found_event->event_status = 'read';
                $found_event->event_read_at = date('Y-m-d H:i:s');
                $found_event->save();
            }
            echo 2;
        }else{
            echo 1;
        }
    }
    public function catalogCourses(Request $request){
        $catalog_id = $request->input('catalog_id');
        $ccourses = new LmsCourseCatalogEntry();
        $courses = new LmsCourse();
        $allcourses = $courses->all();
        $cid = "'course_id[]'";
        $is_imported = 0;
        $result = '
        <table class="table table-responsive-sm table-condensed table-striped js-exportable" id="datatables">
            <thead>
                <tr>
                    <th><input type="checkbox" class="form-check-input" onclick="checkAll(this.checked,'.$cid.');"></th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                </tr>
            </thead>
            <tbody>
        ';
        foreach($allcourses as $course){
            if($course->course_id > 0){
                $imported = $ccourses->where(['catalog_id' => $catalog_id, 'course_id' => $course->course_id])->first();
                if($imported){
                    $is_imported = count($imported);
                }
                $result .=
                '<tr>
                    <td><input class="form-check-input checkboxRequired" type="checkbox" name="course_id[]" value="'.$course->course_id.'" '.($is_imported ? 'checked="checked"' : '' ).' checked="checked" required="required"/></td>
                    <td>'.$course->course_code.'</td>
                    <td>'.$course->course_name.'</td>
                </tr>';
            }
        }
        $result .= '</tbody></table>';
        echo $result;
    }
    public function cart(Request $request,$byPass=false,$product_id=false,$user_id=false){
        //$CartController = new CartController();
        $user_id = ($user_id > 0 ? $user_id : Auth::id());
        $CartProductsController = new CartProductsController();
        if($byPass > 0){
            $all_products = $CartProductsController->products(0, $product_id, $user_id);
        }else{
            $catalog_id = $request->input('catalog_id');
            $product_key = $request->input('course_id');
            $product = $CartProductsController->product(0,$product_key);
            $LmsCourse = new LmsCourse();
            if($product->isEmpty()){
                $CartProductsController->store($user_id,'course',$product_key,$request,$catalog_id);
            }
            $all_products = $CartProductsController->products(0, 0, $user_id);
        }
        if($all_products->isEmpty()){
            $div = '<div class="row">
                        <div class="col">
                            <i class="c-icon c-icon-2xs cil-cart"></i> Your shopping cart is empty. Please add products!
                        </div>
                    </div>';
            echo $div;
            return;
        }
        //check if the course has ever been added to a shopping cart
        $div = '';
        $div  .= '<table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                <tbody>';
            $num=1;
            foreach($all_products as $product){
                $course = $LmsCourse->where(['course_id' => $product->product_key])->first();
                $url_img = url('files/lms/course');
                $course_img_course = ($course->course_img_course != '' ? $url_img.'/'.$course->course_img_course  : '');
                $LmsCart = new LmsCart();
                $cart = $LmsCart->where(['product_id'=>$product->product_id])->first();
                $div  .=
                '<tr>
                    <td>'.$num.'.</td>
                    <td><img class="img-cart" alt="'.$course->course_name.'" src="'.$course_img_course.'" /></td>
                    <td><strong>'.$course->course_name.'</strong></td>
                    <td>'.$course->course_description.'</td>
                    <td>
                        <div class="row">
                            <div class="col">
                                <input class="form-control" type="text" value="1" />
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-danger delCart" data-response_div="cartItems" data-course_id="'.$product->product_key.'" data-cart_id="'.$cart->cart_id.'" data-product_id="'.$product->product_id.'">
                                    <i class="c-icon c-icon-2xs cil-x-circle active"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td>R '.$course->course_price.'</td>
                    <td>R '.$course->course_price.'</td>
                </tr>';
                $num++;
            }
        $div .= '</tbody></table>';
        echo $div;
    }

    public function cartHeader($user_id,$show =false){
        //cartHeader
        $CartProductsController = new CartProductsController();
        $all_products = $CartProductsController->products(0, 0, $user_id);
        $LmsCourse = new LmsCourse();
        if($all_products->isEmpty()){
            $div = '<li class="p-2">
                        <a href="#" >
                            <div class="container">
                                <div class="row">
                                    <div class="col-2"><i class="c-icon c-icon-2xs cil-cart"></i></div>
                                    <div class="col-9">
                                        Your shopping cart is empty.
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>';
            $div .= '<div class="dropdown-divider"></div>';
            if(!$show){
                echo $div;
                return;
            }
            return $div;
        }
        //check if the course has ever been added to a shopping cart
        $div = '
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                <tbody>';
        $num=1;
        foreach($all_products as $product){
            $course = $LmsCourse->where(['course_id' => $product->product_key])->first();
            $url_img = url('files/lms/course');
            $course_img_course = ($course->course_img_course != '' ? $url_img.'/'.$course->course_img_course  : '');
            $LmsCart = new LmsCart();
            $cart = $LmsCart->where(['product_id'=>$product->product_id])->first();
            $div  .=
                '<tr>
                    <td>'.$num.'.</td>
                    <td><img class="img-cart" alt="'.$course->course_name.'" src="'.$course_img_course.'" /></td>
                    <td><strong>'.$course->course_name.'</strong></td>
                    <td><input class="form-control" type="text" value="1" /></td>
                    <td>R '.$course->course_price.'</td>
                    <td><button type="button" class="btn btn-danger delCartHeader" data-response_div="cartHeaderItems" data-user_id="'.$user_id.'" data-course_id="'.$product->product_key.'" data-cart_id="'.$cart->cart_id.'" data-product_id="'.$product->product_id.'">
                        <i class="c-icon c-icon-2xs cil-x-circle active"></i>
                    </button></td>
                </tr>';
            $num++;

        }
        $div .= '</tbody></table>';
        return $div;
    }

    public function delCart(Request $request){
        $product_id = $request->input('product_id');
        $cart_id = $request->input('cart_id');
        $user_id = $request->input('user_id');
        //remove the cart item
        $CartController = new CartController();
        $delCart = $CartController->delCart($cart_id);
        //remove the cart product
        $CartProductsController = new CartProductsController();
        $delCartProduct = $CartProductsController->delCartProduct($product_id);
        if($delCart && $delCartProduct){
            if($user_id){
                $this->cartHeader($user_id);
            }else{
                $this->cart($request,1,$product_id);
            }
        }
    }
    function allPageRoles($module_slug){
        $RolesController = new RolesController();
        return $RolesController->allPageRoles($module_slug);
    }
    function checkPageRole($todo,$module_slug){
        $RolesController = new RolesController();
        return $RolesController->checkPageRole($todo,$module_slug);
    }
}
