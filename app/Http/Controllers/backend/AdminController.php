<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Admin;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
	public function __construct()
    {
        // $this->middleware('check_auth');
    	
    }

 public  function index(){

    //  $users=User::all();
    //  foreach ($users as $key => $user) {
    //    $user->blog;
    //  }
    //  return $users;
    // echo "<pre>";
    // print_r($user->blog); 
   	// exit();
    return view('backend.dashboard');   
   } 
   
 public  function profile(){
   
   	return view('backend.profile');
   
   }

 public  function users(){
  $users = Admin::latest()->orderBy('admins.id', 'desc')->get();
  return view('backend.user.users',compact('users'));
   }
 public function add_user(){
    return view('backend.user.add_user');

  }

 public function add_user_action(Request $request)
  {
   $inputs = $request->except('_token');
   $rules=[
               'username'=>'required',
               'email'=>'required|email|unique:users',
               'password'=>'required|min:4|max:16',
               'address'=>'required',
               'mobile'=>'required',
               // 'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

   ]; 

       $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
         return redirect()->back()->withErrors($validation)->withInput();

        }else{
            
            $image = $request->file('profile');
            $slug =  Str::slug($request->input('name'));
            if (isset($image))
            {
                $currentDate = Carbon::now()->toDateString();
                $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                if (!Storage::disk('public')->exists('admin_media/images/users'))
                {
                    Storage::disk('public')->makeDirectory('admin_media/images/users');
                }
                $postImage = Image::make($image)->resize(128, 128)->stream();
                    Storage::disk('public')->put('admin_media/images/users/'.$imageName, $postImage);
            } else
            {
                $imageName = 'user.png';

            }
            $User = new Admin();
            $User->username=$request->input('username');   
            $User->email=$request->input('email');   
            $User->password=sha1($request->input('password'));   
            $User->mobile=$request->input('mobile');   
            $User->address=$request->input('address');   
            $User->image=$imageName;
            $User->status= 1;

             if ($User->save()) {
             $request->session()->flash('success', 'User Successfully Created !!');
             }else{
              $request->session()->flash('error', 'Something Went Wrong !!');
             }          
            return redirect('/add_user');
          
        }//end else

   }//end function


public function view_users($user_id){
  $user = Admin::latest()->where('id', $user_id)->first();
  return view('backend.user.users_view',compact('user'));
}

public function delete_users(Request $request,$user_id){
 
  $user = Admin::where('id', $user_id)->delete();
  if ($user) {
   $request->session()->flash('success', 'User Successfully Deleted !!');  
   }else{
    $request->session()->flash('error', 'Something Went Wrong !!');
   }
  // Toastr::success('Order has been deleted', 'Success');
  return redirect('/users');
}

public function status_change_user(Request $request,$user_id,$status){
  $status_data = array('status' => $status);
  $condition = array("id" => $user_id);
  $user = Admin::where($condition)->update($status_data);
  if ($user) {
   $request->session()->flash('success', 'Status change successfully!!');  
   }else{
    $request->session()->flash('error', 'Something Went Wrong !!');
   }
  return redirect('/users');

}

public function edit_view_users(Request $request,$user_id){
  $user = Admin::latest()->where('id', $user_id)->first();
  return view('backend.user.edit_user',compact('user')); 
}

public function update(Request $request){
$inputs = $request->except('_token');
$id=$request->input('userid');   
$rules=[
               'username'=>'required',
               'email' => 'required|unique:users,email,'.$id,
               'address'=>'required',
               'mobile'=>'required',
               // 'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

   ]; 

   $validation = Validator::make($inputs, $rules);
    if ($validation->fails())
    {
        return redirect()->back()->withErrors($validation)->withInput();

    }else{
            $image = $request->file('profile');
            $slug =  Str::slug($request->input('name'));
            $user =  Admin::find($id);

            if (isset($image))
            {
                $currentDate = Carbon::now()->toDateString();
                $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                if (!Storage::disk('public')->exists('admin_media/images/users'))
                {
                    Storage::disk('public')->makeDirectory('admin_media/images/users');
                }
             
                if (Storage::disk('public')->exists('admin_media/images/users/'.$user->image))
                {
                    Storage::disk('public')->delete('admin_media/images/users/'.$user->image);
                } 

                $postImage = Image::make($image)->resize(128, 128)->stream();
                    Storage::disk('public')->put('admin_media/images/users/'.$imageName, $postImage);
                } else
                {
                    $imageName = $user->image;
                }  

                $user->username=$request->input('username');   
                $user->email=$request->input('email');
                  if (!empty($request->input('password'))) {
                $user->password=sha1($request->input('password'));    
                     }   
                $user->mobile=$request->input('mobile');   
                $user->address=$request->input('address');   
                $user->image=$imageName;
                if ($user->save()) {
                 $request->session()->flash('success', 'User Successfully Updated !!');
                  return redirect('/users');
                 }else{
                  $request->session()->flash('error', 'Something Went Wrong !!');
                  redirect($_SERVER['HTTP_REFERER']);
                 
             }          
     
        } 

 }




 public function change_password(){
  return view('backend.user.admin_change_password');
 }
 public function changePasswordaction(Request $request){
  $inputs = $request->except('_token');
  $rules=[
    'old_password'     => 'required',
    'new_password'     => 'required|min:6',
    'con_password' => 'required|same:new_password'

]; 
$validation = Validator::make($inputs, $rules);
if ($validation->fails())
{
return redirect()->back()->withErrors($validation)->withInput();

}else{
$user_id=request()->session()->get('id');
  $user = Admin::latest()->where('id', $user_id)->first();
  $oldPass=sha1($request->input('old_password'));
  $newPass=$request->input('new_password');
  $conPass=$request->input('con_password');
  
  if($user->password != $oldPass){
    $request->session()->flash('error', 'Your current password and old password did not match !!');
    return redirect('/change_password');
  }else{
    if($newPass != $conPass){
    $request->session()->flash('error', 'Your new password and confirm password did not match !!');
    return redirect('/change_password');
  }else{
    $user=Admin::find($user_id);
    $user->password=sha1($newPass);
    if($user->save()){
      $request->session()->flash('success', 'Your password changed successfully  !!');
    return redirect('/change_password');
    }else{
      $request->session()->flash('error', 'Something Went Wrong !!');
    return redirect('/change_password');

    }

  }


}

} 

}



public function app_users(){
  $users = User::latest()->orderBy('users.id', 'desc')->get();
  
  return view('backend.user.app_users',compact('users'));
  
}


  
 }//End Controller close
