<?php

namespace App\Http\Controllers\Web\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\User\UserRequest;
use App\Http\Services\User\UserService;
use App\Models\Role\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*
  * @var SupplierService
  */
    private $userService;

    /**
     * SupplierController constructor.
     *
     * @param UserService $service
     */
    public function __construct(UserService $service){
        $this->userService = $service;
    }

    public function users(Request $request){
        $user_lists = $this->userService->getUserList();
        $data['roles'] = Role::all();
        if ($request->ajax()){
            return datatables($user_lists)
                ->editColumn('image',function ($item){
                    return $this->userImage($item);
                })->editColumn('contact_info',function ($item){
                    return $this->userContactInfo($item);
                })->editColumn('status',function ($item){
                    return $this->userStatus($item);
                })->editColumn('action',function ($item){
                    return $this->userAction($item);
                })->rawColumns(['image','status','contact_info','action'])
                ->make(TRUE);
        }
        return view('admin.users.users',$data);
    }

    public function userDetails($user_id){
        $data['user'] = User::where('id',$user_id)->first();
        return view('admin.users.profile.profile',$data);
    }

    public function saveUser(UserRequest $request){
        if(!empty($request->id)){
            return $this->userService->update($request->id,$request->except('id'));
        }else{
            return $this->userService->create($request->except('id'));
        }
    }

    public function editUser(Request $request){
        $data = $this->userService->getUserData($request->id);
        $data['roles'] = Role::all();
        return view('admin.users.user_add',$data);
    }

    public function userStatusChange(Request $request){
        return $this->userService->userStatusChange($request->all());
    }

    private function userImage($item){
        $default_image = asset(get_image_path('user').'avatar.png');
        if ($item->is_social_login == TRUE){
            $user_image = !empty($item->profile_photo_path) ? asset(get_image_path('user').$item->profile_photo_path) : $item->social_image_link;
        }else{
            $user_image = !empty($item->profile_photo_path) ? asset(get_image_path('user').$item->profile_photo_path) : '';
        }
        $html = '<img src="'.$user_image.'" class="img-thumbnail" width="50" onerror=\'this.src="'.$default_image.'"\'>';
        return $html;
    }
    private function userContactInfo($item){
        $html = '';
        $html .= '<span><strong><i class="fa fa-envelope"></i> </strong>'.$item->email.'</span><br>';
        if (!empty($item->phone)){
            $html .= '<span><strong><i class="fa fa-phone"></i> </strong>'.$item->phone.'</span><br>';
        }
        return $html;
    }
    private function userAdditionalInfo($item){
        $html = '';
        $html .= '<span><strong>'.__('NID').': </strong>'.$item->nid.'</span><br>';
        $html .= '<span><strong>'.__('TIN').': </strong>'.$item->tin.'</span><br>';
        return $html;
    }
    private function userAddressInfo($item){
        $html = '';
        $html .= '<span><strong>'.__('Country').': </strong>'.$item->country.'</span><br>';
        $html .= '<span><strong>'.__('City').': </strong>'.$item->city.'</span><br>';
        $html .= '<span><strong>'.__('State').': </strong>'.$item->state.'</span><br>';
        $html .= '<span><strong>'.__('Post Code').': </strong>'.$item->post_code.'</span><br>';
        $html .= '<span><strong>'.__('Address').': </strong>'.$item->address.'</span><br>';
        $html .= '<span><strong>'.__('Secondary Address').': </strong>'.$item->address_secondary.'</span><br>';
        return $html;
    }
    private function userApproveStatus($item){
        $statusText = '';
        $statusClass = '';
        if ($item->is_seller == ACTIVE) {
            $statusText = __('Approved');
            $statusClass = 'info';
        }else {
            $statusText = __('Not Approved');
            $statusClass = 'warning';
        }
        return '<div class="btn-group mb-2">
                    <button type="button" class="btn btn-xs btn-' . $statusClass . ' dropdown-toggle dropdown-toggle-split"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ' . $statusText . '&nbsp<i class="fas fa-caret-down"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                        <a class="dropdown-item approve_status_change"  data-type="' . IS_SELLER . '" data-id="' . $item->id . '" href="javascript:">' . __('Approved') . '</a>
                        <a class="dropdown-item approve_status_change"  data-type="' . IS_SELLER_PENDING . '" data-id="' . $item->id . '" href="javascript:">' . __('Reject') . '</a>
                    </div>
                </div>';
    }
    private function userVerifyStatus($item){
        $statusText = '';
        $statusClass = '';
        if ($item->admin_verified == ACTIVE) {
            $statusText = __('Verified');
            $statusClass = 'info';
        }else {
            $statusText = __('Not verified');
            $statusClass = 'warning';
        }
        return '<div class="btn-group mb-2">
                    <button type="button" class="btn btn-xs btn-' . $statusClass . ' dropdown-toggle dropdown-toggle-split"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ' . $statusText . '&nbsp<i class="fas fa-caret-down"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                        <a class="dropdown-item verify_status_change"  data-type="' . ACTIVE . '" data-id="' . $item->id . '" href="javascript:">' . __('Verify') . '</a>
                        <a class="dropdown-item verify_status_change"  data-type="' . INACTIVE . '" data-id="' . $item->id . '" href="javascript:">' . __('Reject') . '</a>
                    </div>
                </div>';

    }
    private function userStatus($item){

        $statusText = '';
        $statusClass = '';
        if ($item->status == ACTIVE) {
            $statusText = __('Active');
            $statusClass = 'success';
        } else if ($item->status == STATUS_SUSPENDED) {
            $statusText = __('Suspend');
            $statusClass = 'warning';
        } else if ($item->status == STATUS_BLOCKED) {
            $statusText = __('Block');
            $statusClass = 'danger';
        }else {
            $statusText = __('Inactive');
            $statusClass = 'primary';
        }
        return '<div class="btn-group mb-2">
                    <button type="button" class="btn btn-xs btn-' . $statusClass . ' dropdown-toggle dropdown-toggle-split"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ' . $statusText . '&nbsp<i class="fas fa-caret-down"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                        <a class="dropdown-item status_change"  data-type="' . ACTIVE . '" data-id="' . $item->id . '" href="javascript:void(0)">' . __('Active') . '</a>
                        <a class="dropdown-item status_change"  data-type="' . INACTIVE . '" data-id="' . $item->id . '" href="javascript:void(0)">' . __('Inactive') . '</a>
                        <a class="dropdown-item status_change"  data-type="' . STATUS_SUSPENDED . '" data-id="' . $item->id . '" href="javascript:void(0)">' . __('Suspend') . '</a>
                        <a class="dropdown-item status_change"  data-type="' . STATUS_BLOCKED . '" data-id="' . $item->id . '" href="javascript:void(0)">' . __('Block') . '</a>
                    </div>
                </div>';

    }
    private function userAction($item){
        $html = '';
        $html .= '<a href="javascript:void(0)" class="btn btn-xs btn-warning  edit_item mr-1 mb-1" data-id="'.$item->id.'"><i class="fa fa-edit"></i> '.__('Edit').'</a>';
        $html .= '<a href="'.route('userDetails',['user_id'=>$item->id]).'" class="btn btn-xs btn-info mr-1 mb-1""><i class="fa fa-eye"></i> '.__('View').'</a>';
        return $html;
    }

    public function delete(Request $request){
        return $this->userService->delete($request->id);
    }

}
