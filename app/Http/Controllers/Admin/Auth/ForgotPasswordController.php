<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset emails and
  | includes a trait which assists in sending these notifications from
  | your application to your users. Feel free to explore this trait.
  |
  */

  use SendsPasswordResetEmails;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest:admin');
  }
  protected function guard()
  {
    return Auth::guard('admin');
  }
  public function broker()
  {
    return Password::broker('admins');
  }

  public function showLinkRequestForm () {
    return view('admin.auth.email');
  }
  
  public function sendResetLinkEmail(Request $request) {
    $this->validate($request, ['email' => 'required|email']);

    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
    $response = $this->broker()->sendResetLink(
      $request->only('email'), $this->resetNotifier() 
    );

    switch ($response) {
      case Password::RESET_LINK_SENT:
        return response()->json([
          'success' => true
        ]);

      case Password::INVALID_USER:

      default:
        return response()->json([
          'success' => false,
          'message' => 'Invalid user'
        ]);
    }
  }

  protected function resetNotifier() {
    return function($token) {
      return new ResetPasswordNotification($token);
    };
  }
}
