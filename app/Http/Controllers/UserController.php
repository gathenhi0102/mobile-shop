<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserType;
use Auth;
use Hash;
use Mail;
class UserController extends Controller
{
    private $empty_email_notification = 0;
    private $success_post_profile = 1;
    private $customer_level = 0;
    protected $undentified = 'N/A';
    protected $default_icon = 'default-user-icon.png';
    protected $male = 'Nam';
    protected $female = 'Nữ';

    //update login time stamp after user login
    public function updateLoginTimestamp($id){
        $current_time = date('Y-m-d H:i:s');
        $user_info = User::find($id);
        $user_info->last_login_timestamp = $current_time;
        return $user_info->save();
    }

    //load đăng nhập
    public function login(){
        if(Auth::check())
            return redirect()->route('mainpage');
    	return view('page.login');
    }

    //đăng nhập
    public function postLogin(Request $req){
        if($req->isMethod('post')){
            $this->validate($req,
                [
                    'login_password' => 'min:4|max:50'
                ],

                [
                    'login_password.min' =>'Mật khẩu phải có tối thiểu 4 ký tự',
                    'login_password.max' =>'Mật khẩu tối đa 50 ký tự'
                ]
            );
            $auth = array('email' => $req->login_email, 'password' => $req->login_password);
            if(!Auth::attempt($auth))
                return redirect()->back()->with(['flag' => 'danger','message' => 'Sai tên tài khoản hoặc mật khẩu.']);
            //update login timestamp
            $user_id =  Auth::user()->id;
            $this->updateLoginTimestamp($user_id);

            //return to main page  
            return redirect()->route('mainpage');
           }           
        return redirect()->back()->with(['flag' => 'danger', 'message' => 'Không tồn tại phương thức post.']);
    }   


    //đăng ký
    public function register(){
    	return view('page.register');
    }

    //lưu thông tin đăng kí
    public function saveRegisterInfo(Request $req){
    	if($req->isMethod('post')){    
    		$this->validate($req,
    			['input_email'=>'required|email|unique:users,email',
                 'input_phone'=>'required|numeric',
                 'input_password' => 'required|min:4|max:50',
    			 'input_password_confirmation' =>'required|same:input_password',
    			 'sex_select' => 'between:0,1',
                 'image' => 'image|mimes:jpeg,jpg,png,svg|max:2048',
                 'input_name' => 'required',
                 'input_address' => 'required'

    			],
    			[
                    'input_email.required'=>'Vui lòng nhập email của bạn.',
                    'input_name.required'=>'Vui lòng nhập tên của bạn.',
                    'input_address.required'=>'Vui lòng nhập địa chỉ của bạn.',
                    'input_phone.required'=>'Vui lòng nhập số điện thoại của bạn.',
                    'input_password.required' =>'Vui lòng nhập mật khẩu',
                    'input_password_confirmation.required' => 'Vui lòng nhập lại mật khẩu.',   
    				'input_email.email'=>'Hãy nhập email đúng định dạng.',
                    'input_phone.numeric'=>'Số điện thoại phải ở dạng số.',
    				'input_email.unique' =>'Email này đã tồn tại.',
                    'input_password.min' =>'Mật khẩu phải có tối thiểu 4 ký tự',
                    'input_password.max' =>'Mật khẩu tối đa 50 ký tự',
    				'input_password_confirmation.same' => 'Mật khẩu bạn đã nhập không trùng nhau.',
    				'sex_select.between' => 'Vui lòng chọn giới tính.',
                    'image.image' => 'Vui lòng chọn định dạng hình ảnh.',
                    'image.mimes' => 'Chỉ hỗ trợ định dạng: jpeg, jpg, png, svg',
                    'image.max' => 'Dung lượng tối đa là 2048kb'
    			]
    		);

            if($req->hasFile('image')){
                $file = $req->file('image');
                $filename = $file->getClientOriginalName('image');
                $url = 'source/user_image';
                $file->move($url, $filename);
            }

    		$user = new User();
    		$user->name = $req->input_name;
    		$user->phone = $req->input_phone;
    		$user->address = $req->input_address;
    		$user->email = $req->input_email;
    		$user->gender = $req->get('sex_select');
    		$user->password = Hash::make($req->input_password);
            if(isset($filename)){
                $user->user_image = $filename;
            }
            else{
                $user->user_image = $this->default_icon;
            }

			if($user->save())
				return redirect()->back()->with(['flag' => 'success', 'message' => 'BẠN ĐÃ ĐĂNG KÝ TÀI KHOẢN THÀNH CÔNG.']);

			return redirect()->back()->with(['flag' => 'danger', 'message' => 'ĐĂNG KÝ TÀI KHOẢN THẤT BẠI.']);
    	}
        return redirect()->back()->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY PHƯƠNG THỨC POST.']);    
    }

    //đăng xuất
    public function Logout(){
        Auth::logout();
        return redirect()->back();
    }

    // xem thông tin người dùng
    public function getUserProfile(Request $req){
        if(Auth::check()){
            $user_id = $req->customerid;
            $user_profile = User::where('id', $user_id)->first();
            unset($user_profile->password);
            if($user_profile->gender==1){
                $user_profile->gender = $this->male;
            }
            else{
                $user_profile->gender = $this->female;
            }
            $point = $user_profile->point;

            $user_type = UserType::all();
            //cập nhật loại khách hàng
            foreach ($user_type as $type) {
                if($point >= $type->minpoint && $point <= $type->maxpoint){
                    User::where('id', $user_profile->id)->update(['type' => $type->id]);
                }
            }

            $type = UserType::find($user_profile->type);
            if(empty($type)){
                $user_profile->type_name = $this->undentified;
            }
            else{
                $user_profile->type_name = $type->name;
            }
              
            return view('page.userprofile', compact('user_profile'));
        }
        return redirect()->route('loginpage')->with(['flag' => 'danger', 'message' => 'Vui lòng đăng nhập trước khi sử dụng chức năng này.']);    
    }

    public function editUserProfile(Request $req){
        if(Auth::check()){
            $user_id = $req->customerid;
            $user_profile = User::where('id', $user_id)->first();  
            unset($user_profile->email);
            unset($user_profile->phone);
            return view('page.edituserprofile', compact('user_profile'));
        }
        return redirect()->route('loginpage')->with(['flag' => 'danger', 'message' => 'Vui lòng đăng nhập trước khi sử dụng chức năng này.']);
    }

    public function saveUserProfile(Request $req){
        if($req->isMethod('post')){    
            $this->validate($req,
                [
                 'input_name' => 'required',
                 'input_address' => 'required',
                 'sex_select' => 'between:0,1',
                 'image' => 'image|mimes:jpeg,jpg,png,svg|max:2048',
                ],
                [
                    'sex_select.between' => 'Vui lòng chọn giới tính.',
                    'input_address.required'=>'Vui lòng nhập địa chỉ của bạn.',
                    'input_name.required'=>'Vui lòng nhập tên của bạn.',
                    'image.image' => 'Vui lòng chọn định dạng hình ảnh.',
                    'image.mimes' => 'Chỉ hỗ trợ định dạng: jpeg, jpg, png, svg',
                    'image.max' => 'Dung lượng tối đa là 2048kb'
                ]
            );

            if($req->hasFile('image')){
                $file = $req->file('image');
                $filename = $file->getClientOriginalName('image');
                $url = 'source/user_image';
                $file->move($url, $filename);
            }

            $user = User::find($req->id);
            if(empty($user))
                return redirect()->back()->with(['flag' => 'danger', 'message' => 'NGƯỜI DÙNG NÀY KHÔNG TỒN TẠI.']);

            $user->name = $req->input_name;
            $user->address = $req->input_address;
            $user->gender = $req->get('sex_select');
            if(isset($filename)){
                $user->user_image = $filename;
            }

            if($user->save())
                return redirect()->back()->with(['flag' => 'success', 'message' => 'CHỈNH SỬA THÔNG TIN THÀNH CÔNG.']);

            return redirect()->back()->with(['flag' => 'danger', 'message' => 'ĐÃ CÓ LỖI XẢY RA, VUI LÒNG THỬ LẠI.']);
        }
        return redirect()->back()->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY PHƯƠNG THỨC POST.']);
    }

    //get page admin login

    public function adminLogin(){
        if(Auth::check()){
            $user = User::find(Auth::user()->id);
            if(empty($user) || $user->user_level == $this->customer_level)
                return view('admin.layout.login');
            return redirect()->route('index');
        }
        return view('admin.layout.login');
    }

    //post admin login info

    public function postAdminLoginInfo(Request $req){
        if($req->isMethod('post')){
            $this->validate($req,
                [
                 'email' => 'required',
                 'password' => 'required'
                ],
                [
                    'email.required'=>'Vui lòng nhập email của bạn.',
                    'password.required'=>'Vui lòng nhập mật khẩu của bạn.',
                ]
            );
            $auth = array('email' => $req->email, 'password' => $req->password);
            if(!Auth::attempt($auth))
                return redirect()->back()->with('message','Sai tên tài khoản hoặc mật khẩu.');
                
            //update login timestamp    
            $user_id =  Auth::user()->id;
            $this->updateLoginTimestamp($user_id);

            return redirect()->route('index');
        }
        return redirect()->back()->with('message','Không tìm thấy phương thức post.');
    }

    //logout
    public function adminLogout(){
        Auth::logout();
        return redirect()->route('adminlogin');
    }

    //lấy danh sách theo khách hàng
    public function getlistusers($usertype){
        $list_user = User::where('user_level', $usertype)->get();
        foreach ($list_user as $list) {
            unset($list->password);
            if($list->gender == 0)
                $list->gender_name = $this->female;
            else
                $list->gender_name = $this->male;
            $type = UserType::find($list->type);
            $list->type_name = $type->name;
        }
        return view('admin.layout.users.listview', compact('usertype','list_user'));
    }

    //thêm admin
    public function getAddNewAdmin(){
        return view('admin.layout.users.insert');
    }

    //chỉnh sửa
    public function getEditAdminInfo($id){
        $admin_info = User::find($id);
        unset($admin_info->password);
        return view('admin.layout.users.edit', compact('admin_info'));
    }

    public function postAdminInfo(Request $req){
        if($req->isMethod('post')){
            $admin = 1;
            $admin_type = 7;    
            $this->validate($req,
                [
                 'user_name' => 'required',
                 'user_email'=>'required|email|unique:users,email',
                 'user_phone'=>'required|numeric',
                 'user_password' => 'required|min:4|max:50',
                 're_user_password' =>'required|same:user_password',
                 'user_gender' => 'between:0,1',
                 'image' => 'image|mimes:jpeg,jpg,png,svg|max:2048'
                ],
                [
                    'user_email.required'=>'Vui lòng nhập email của bạn.',
                    'user_name.required'=>'Vui lòng nhập tên của bạn.',
                    'user_phone.required'=>'Vui lòng nhập số điện thoại của bạn.',
                    'user_password.required' =>'Vui lòng nhập mật khẩu',
                    're_user_password.required' => 'Vui lòng nhập lại mật khẩu.',
                    'user_email.email'=>'Hãy nhập email đúng định dạng.',
                    'user_phone.numeric'=>'Số điện thoại phải ở dạng số.',
                    'user_email.unique' =>'Email này đã tồn tại.',
                    'user_password.min' =>'Mật khẩu phải có tối thiểu 4 ký tự',
                    'user_password.max' =>'Mật khẩu tối đa 50 ký tự',
                    're_user_password.same' => 'Mật khẩu bạn đã nhập không trùng nhau.',
                    'user_gender.between' => 'Vui lòng chọn giới tính.',
                    'image.image' => 'Vui lòng chọn định dạng hình ảnh.',
                    'image.mimes' => 'Chỉ hỗ trợ định dạng: jpeg, jpg, png, svg',
                    'image.max' => 'Dung lượng tối đa là 2048kb'
                ]
            );

            if($req->hasFile('image')){
                $file = $req->file('image');
                $filename = $file->getClientOriginalName('image');
                $url = 'source/user_image';
                $file->move($url, $filename);
            }

            $user = new User();
            $user->name = $req->user_name;
            $user->phone = $req->user_phone;
            $user->address = $req->user_address;
            $user->email = $req->user_email;
            $user->gender = $req->get('user_gender');
            $user->password = Hash::make($req->user_password);
            $user->user_level = $admin;
            $user->type = $admin_type;
            if(isset($filename)){
                $user->user_image = $filename;
            }
            else{
                $user->user_image = $this->default_icon;
            }

            if($user->save())
                return redirect()->route('addnewadmin')->with(['flag' => 'success', 'message' => 'TẠO MỚI QUẢN TRỊ VIÊN THÀNH CÔNG.']);

            return redirect()->route('addnewadmin')->with(['flag' => 'danger', 'message' => 'TẠO MỚI QUẢN TRỊ VIÊN THẤT BẠI.']);

        }
        return redirect()->route('addnewadmin')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY PHƯƠNG THỨC POST.']);
    }

    public function postEditAdminInfo(Request $req){
        if($req->isMethod('post')){   
            $this->validate($req,
                [
                 'user_name' => 'required',
                 'user_phone'=>'required|numeric',
                 'user_gender' => 'between:0,1',
                 'image' => 'image|mimes:jpeg,jpg,png,svg|max:2048'
                ],
                [
                    
                    'user_name.required'=>'Vui lòng nhập tên của bạn.',
                    'user_phone.required'=>'Vui lòng nhập số điện thoại của bạn.',
                    'user_phone.numeric'=>'Số điện thoại phải ở dạng số.',
                    'user_gender.between' => 'Vui lòng chọn giới tính.',
                    'image.image' => 'Vui lòng chọn định dạng hình ảnh.',
                    'image.mimes' => 'Chỉ hỗ trợ định dạng: jpeg, jpg, png, svg',
                    'image.max' => 'Dung lượng tối đa là 2048kb'
                ]
            );
            $user = User::find($req->id);
            if(empty($user))
                return redirect()->route('getlistusers',['usertype'=>1])->with(['flag' => 'danger', 'message' => 'NGƯỜI DÙNG NÀY KHÔNG TỒN TẠI.']);

            if($req->hasFile('image')){
                $file = $req->file('image');
                $filename = $file->getClientOriginalName('image');
                $url = 'source/user_image';
                $file->move($url, $filename);
            }

            $user->name = $req->user_name;
            $user->phone = $req->user_phone;
            $user->address = $req->user_address;
            $user->gender = $req->get('user_gender');

            if(isset($filename)){
                $user->user_image = $filename;
            }

            if($user->save())
                return redirect()->route('editadmininfo', ['id' => $req->id])->with(['flag' => 'success', 'message' => 'CHỈNH SỬA THÔNG TIN QUẢN TRỊ VIÊN THÀNH CÔNG.']);

            return redirect()->route('editadmininfo', ['id' => $req->id])->with(['flag' => 'danger', 'message' => 'CHỈNH SỬA THÔNG TIN QUẢN TRỊ VIÊN THẤT BẠI.']);
        }
        return redirect()->route('addnewadmin')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY PHƯƠNG THỨC POST.']);
    }

    public function postUserProfileAjax(Request $req){
        $email = $req->email;
        $phone = $req->phone;
        $user_profile = User::where([['email', $email], ['phone', $phone]])->first();
        if(empty($user_profile)){
            return $this->empty_email_notification;
        }

        $email_account = 'lethanh.bien2000@gmail.com';
        $sender_name = 'OneTech Mobile Store';
        $email_subject = 'Thay đổi thông tin tài khoản';

        $profile_name = $user_profile->name;
        $new_password = mt_rand(100000, 999999);
        User::where('id', $user_profile->id)->update(['password' => Hash::make($new_password)]);
        $data = ['name' => $user_profile->name, 'password' => $new_password];

        Mail::send('page.blank', $data, function($message) use ($email_account, $sender_name, $email_subject, $email, $profile_name){
            $message->from($email_account, $sender_name);
            $message->to($email, $profile_name)->subject($email_subject);
        });
        return $this->success_post_profile;
    }

    public function getChangePassword(){    
        if(Auth::check())
            return view('page.changepassword');
        return redirect()->route('loginpage')->with(['flag' => 'danger', 'message' => 'Vui lòng đăng nhập trước khi sử dụng chức năng này.']);   
    }

    public function postChangePasswordInfo(Request $req){
        if($req->isMethod('post')){  
            $this->validate($req,
                [
                 'old_password' => 'required',
                 'new_password' => 'required|min:4|max:50',
                 'confirm_new_password' => 'required|same:new_password'
                ],
                [
                    'old_password.required'=>'Vui lòng nhập mật khẩu cũ.',
                    'new_password.required'=>'Vui lòng nhập mật khẩu mới.',
                    'confirm_new_password.required'=>'Vui lòng nhập lại mật khẩu mới.',
                    'new_password.min' =>'Mật khẩu phải có tối thiểu 4 ký tự',
                    'new_password.max' =>'Mật khẩu tối đa 50 ký tự',
                    'confirm_new_password.same' => 'Mật khẩu bạn đã nhập không trùng nhau.'
                ]
            );

            $user_profile = User::find($req->id);
            if(empty($user_profile))
                return redirect()->back()->with(['flag' => 'danger', 'message' => 'NGƯỜI DÙNG NÀY KHÔNG TỒN TẠI.']);

            $auth = array('email' => $user_profile->email, 'password' => $req->old_password);

            if(!Auth::attempt($auth))
                return redirect()->back()->with(['flag' => 'danger', 'message' => 'MẬT KHẨU CŨ KHÔNG ĐÚNG, VUI LÒNG NHẬP LẠI.']);

            $user_profile->password = Hash::make($req->new_password);

            if($user_profile->save())
                return redirect()->back()->with(['flag' => 'success', 'message' => 'BẠN ĐÃ ĐỔI MẬT KHẨU THÀNH CÔNG.']);

            return redirect()->back()->with(['flag' => 'danger', 'message' => 'ĐỔI MẬT KHẨU THẤT BẠI, VUI LÒNG KIỂM TRA LẠI.']);
        }
        return redirect()->route('changepassword')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY PHƯƠNG THỨC POST.']);
    }
}
