<?php
namespace App\Http\Controllers; 
use Illuminate\Http\Request; 
use DB; 
use Session; 
use App\Http\Requests; 
use Illuminate\Support\Facades\Redirect; 
session_start();
 class AdminController extends Controller
 {
     function index(){

            return view('admin');
     }
     public function show_dashboard() { 
        $this->AuthLogin();
        return view('admin.dashboard'); 
        } 
      // Xử lý đăng nhập
public function dashboard(Request $request) {
    $admin_email = $request->admin_email;
    $admin_password = $request->admin_password;
    

    $result = DB::table('tbl_admin')
        ->where('admin_email', $admin_email)
        ->where('admin_password', $admin_password)
        ->first();

    if($result) {
        Session::put('admin_name', $result->admin_name);
        Session::put('admin_id', $result->id); 
        return Redirect::to('/dashboard');
    } else {

        Session::put('message', 'Email hoặc mật khẩu không đúng ' );

        return Redirect::to('/admin');
    }
}   
        public function logout(){ 
            Session::put('admin_name',null); 
                Session::put('admin_id',null); 
                return Redirect::to('/admin'); 
                
              }
              public function AuthLogin(){ 
                $admin_id = Session::get('admin_id'); 
                if($admin_id){ 
                    return Redirect::to('dashboard'); 
                }else{ 
        return Redirect::to('admin')->send(); 
        } 
        } 
        public function cook(){
            return view('pages.admin');
        }   
    }
   
    

     //
 