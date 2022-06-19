<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //direct admin profile
    public function profile() {
        
        $id = auth()->user()->id ; 
        $data = User::where('id', $id)->first();
        return view('admin.profile.index')->with(['user' => $data]);
        // return view('admin.profile.index');
    }

    //update profile
    public function updateProfile ($id, Request $request) {

         // validation
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required' ,
            'phone' => 'required' ,
            'address' => 'required' ,
        ]);
 
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        //end validation

        $data = $this->getUserData($request);
        
        User::where('id', $id)->update($data);

        return back()->with(['success' => 'User Information Update Successfully...']);
    }

    //change password get
    public function changePassword () {
        return view('admin.profile.changePassword');
    }

    //change password post
    public function change ($id, Request $request) {
        // validation
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required' ,
            'confirmPassword' => 'required' ,
        ]);
 
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        //end validation

        $data = User::where('id', $id)->first();
        $dbHashPassword = $data['password'];
        $oldPassword = $request->oldPassword ; 
        $newPassword = $request->newPassword ;
        $confirmPassword = $request->confirmPassword ;

        if (Hash::check($oldPassword, $dbHashPassword)) {                       //check old password
            if($newPassword == $confirmPassword){                               // check equal new and confirm password
               if(strlen($newPassword) > 6 || strlen($confirmPassword) > 6){    //check greater or less then password length at least 6
                    $hash = Hash::make($newPassword);
                    User::where('id', $id)->update([
                        'password' => $hash,
                    ]);
                    return back()->with(['success' => 'Password Changed..']);
               }else{
                    return back()->with(['error' => 'Password has at least 6 character length.Try again...']);
               }
            }else{
                return back()->with(['error' => 'New password and Confirm password does not match.Try again...']);
            }
        }else{
            return back()->with(['error' => 'Password does not match.Try again....']);
        }
            
        
    }
    

    //get user data functiin
    private function getUserData ($request) {
        $data = [
            'name' => $request->name , 
            'email' => $request->email , 
            'address' => $request->address ,
            'phone' => $request->phone , 
        ];

        return $data;
    }
}
