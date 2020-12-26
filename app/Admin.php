<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;


class Admin extends Model
{
	
public static function check_login($username,$password){
$value=DB::table('admins')->where('email', $username)->where('password',$password)->first();
return $value;
}
   
}
