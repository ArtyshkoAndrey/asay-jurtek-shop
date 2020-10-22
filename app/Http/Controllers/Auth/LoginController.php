<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Currency;
use App\Models\UserAddress;
use App\Services\CartService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

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
  protected $redirectTo = '/';
  protected $cartService;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(CartService $cartService)
  {
    parent::__construct($cartService);
  }

  public function login(Request $request)
  {
    // validate the form data
    $this->validate($request, [
      'email' => 'required|email|exists:users,email',
      'password' => 'required|min:3'
    ]);
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

      // if successful -> redirect forward
      return redirect()->intended('/');
    }

    // if unsuccessful -> redirect back
    return Redirect::back()
      ->withInput()
      ->withErrors(
        [
          'password' => 'Неверный пароль',
        ]
      );
  }
}
