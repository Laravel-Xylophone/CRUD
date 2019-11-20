<?php

namespace Xylophone\CRUD\app\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    protected $data = []; // the information we send to the view

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
    use AuthenticatesUsers {
        logout as defaultLogout;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $guard = xylophone_guard_name();

        $this->middleware("guest:$guard", ['except' => 'logout']);

        // ----------------------------------
        // Use the admin prefix in all routes
        // ----------------------------------

        // If not logged in redirect here.
        $this->loginPath = property_exists($this, 'loginPath') ? $this->loginPath
            : xylophone_url('login');

        // Redirect here after successful login.
        $this->redirectTo = property_exists($this, 'redirectTo') ? $this->redirectTo
            : xylophone_url('dashboard');

        // Redirect here after logout.
        $this->redirectAfterLogout = property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout
            : xylophone_url();
    }

    /**
     * Return custom username for authentication.
     *
     * @return string
     */
    public function username()
    {
        return xylophone_authentication_column();
    }

    /**
     * Log the user out and redirect him to specific location.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Do the default logout procedure
        $this->guard()->logout();

        // And redirect to custom location
        return redirect($this->redirectAfterLogout);
    }

    /**
     * Get the guard to be used during logout.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return xylophone_auth();
    }

    // -------------------------------------------------------
    // Laravel overwrites for loading xylophone views
    // -------------------------------------------------------

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $this->data['title'] = trans('xylophone::base.login'); // set the page title
        $this->data['username'] = $this->username();

        return view(xylophone_view('auth.login'), $this->data);
    }
}
