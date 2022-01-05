<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/home';

    public function __construct(){
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm(){
        return view('auth.admin-login');
    }

    public function login(Request $request){
        $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required|min:3',
        ]);

        error_log('REMEMBER:  ' .$request->remember);
        error_log('REMEMBER:  ' .$request->password);
        error_log('REMEMBER:  ' .$request->email);



       if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password], $request->remember)){
           error_log('PASA 2?');
            return redirect()->intended(route('admin.dashboard'));
       }

       return redirect()->back()->withInput($request->only('email','remember'));
    }
}
