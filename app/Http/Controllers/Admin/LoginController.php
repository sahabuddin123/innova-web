<?php

namespace App\Http\Controllers\Admin;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect admins after login.
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
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
 * @param Request $request
 * @return \Illuminate\Http\RedirectResponse
 * @throws \Illuminate\Validation\ValidationException
 */
public function login(Request $request)
{
    $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
    ]);

    // Check if user has too many failed login attempts
    if (method_exists($this, 'hasTooManyLoginAttempts') &&
        $this->hasTooManyLoginAttempts($request)) {
        $this->fireLockoutEvent($request);

        return $this->sendLockoutResponse($request);
    }

    if (Auth::guard('admin')->attempt([
        'email' => $request->email,
        'password' => $request->password
    ], $request->get('remember'))) {
        $this->clearLoginAttempts($request);

        return redirect()->intended(route('admin.dashboard'));
    }

    // Increment failed attempts for rate limiting
    $this->incrementLoginAttempts($request);

    return back()->withInput($request->only('email', 'remember'));
}

/**
 * @param Request $request
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */
public function logout(Request $request)
{
    Auth::guard('admin')->logout();
    $request->session()->invalidate();
    return redirect()->route('admin.login');
}
}