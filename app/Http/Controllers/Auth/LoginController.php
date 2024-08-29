<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
    {
        if ( auth()->user()->role == '1' || auth()->user()->role == '3') {
            return route('admin.index');
        }
        elseif ( auth()->user()->role == '2') {
            return route('doctor.index');
        }
        else {
            return route('publisher.index');
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // return $request;
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $fieldType = 'email';
        } elseif (is_numeric($request->email)) {
            $fieldType = 'phone';
        } else {
            $fieldType = 'username';
        }

        if (auth()->attempt([$fieldType=>$input['email'],'password'=>$input['password']])) {
            if (auth()->user()->checkActive() != '1') {
                session()->put('faild',auth()->user()->checkActive());
                auth()->logout();
                return redirect()->back()->withInput();
            }
            if ( auth()->user()->role == '1' || auth()->user()->role == '3') {
                return redirect()->route('admin.index');
            }
            elseif( auth()->user()->role == '2' ) {
                return redirect()->route('doctor.index');
            }
            else{
                return 'errrrrrrrrrrror' ;
            }
        } else {
            session()->put('faild',trans('auth.failed'));
            return redirect()->back()->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('auth.login',[
            'active' => '',
            'title' => trans('common.Sign in')
        ]);
    }

    protected function loggedOut(Request $request) {
        return redirect()->route('login');
    }
}
