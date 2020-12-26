<?php

namespace App\Http\Controllers\backend;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LoginController extends Controller
{
    //
    public function index()
    {
    	 return view("backend.login");
    }

    public function auth_check(Request $request)
    { 	
       $request->validate([
            'username' => 'required|email',
            'password' => 'required|max:15|min:4'
        ]);
         $username=$request->username;
         $password=sha1($request->password);
         $userData = Admin::check_login($username,$password);
         if (!empty($userData)) {
            if ($userData->status == 1) {
              $session_data = array(
                               'email' => $username,
                               'password' => $password,
                               'mobile' => $userData->mobile,
                               'image' => asset("storage/admin_media/images/users/".$userData->image),
                               'id' => $userData->id,
                               'address' => $userData->address,
                               'username' => $userData->username,
                               'status' => $userData->status,
                               'is_loggin'=>TRUE,
                               );

            $request->session()->put($session_data);
            $request->session()->flash('status', 'loggin successfully !');
            return redirect('dashboard');

         }else{
            $request->session()->flash('status', 'User inactive contact to admin !');
            return redirect('admin');
         }
          
         }else{
            $request->session()->flash('status', 'Username and password incorrect !');
            return redirect('admin');
          }      
        	
    }

public function logout(Request $request){
    $request->session()->flush();
    // $request->session()->forget('key');
    return redirect('admin');
}

}
