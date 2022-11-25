<?php

namespace App\Http\Controllers\Web;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserUpdateController extends Controller
{


    public function userProfile(){
        // Get Setting Data
        return view('layout.setting.setting');
    }


    //
    public function update(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'user_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $user = User::findOrfail(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;

        // Upload User Avatar
        if(!empty($request['user_avatar'])){
            if(empty($user->user_avatar)){
                // Upload New User Avatar
                $user_avatar = Helper::fileUpload($request->user_avatar,'user',$user->name.'_'.$user->id);
            }else{
                // Remove Old File
                @unlink(public_path('/') . $user->user_avatar);

                // Upload New User Avatar
                $user_avatar = Helper::fileUpload($request->user_avatar,'user',$user->name.'_'.$user->id);
            }
            $user->user_avatar = $user_avatar;
        }
        $user->save();
        return redirect()->route('user.profile')->with('t-success', 'Profile Update successfully.');
    }

    public function userPassword(){
        // Get Setting Data
        return view('layout.setting.setting');
    }

    public function userPasswordUpdate(Request $request){
        $request->validate([
            'old_password'     => 'required|string|min:6',
            'new_password'     => 'required|string|min:6',
            'confirm_password' => 'required|string|same:new_password|min:6',
        ]);

        if(Hash::check($request->old_password, Auth::user()->password)){
            User::findOrFail(Auth::user()->id)->update(['password' => Hash::make($request->new_password)]);
            return redirect()->route('user.password')->with('t-success', 'Password Update successfully.');
        }else{
            return redirect()->back()->with('alert-error','Please, Enter Your Right Current Password ');
        }
    }
}
