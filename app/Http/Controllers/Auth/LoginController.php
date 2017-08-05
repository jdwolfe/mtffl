<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;

class LoginController extends Controller {
	private $mflUrl = '';
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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
		$mflInfo = DB::table('mfl_info')->select('season','mfl_number','mfl_server')->where('league','mtffl')->orderBy('id','desc')->take(1)->first();
		$this->mflUrl = 'https://' . $mflInfo->mfl_server . '.myfantasyleague.com/' . $mflInfo->season . '/home/' . $mflInfo->mfl_number;

    }
}
