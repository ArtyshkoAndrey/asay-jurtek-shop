<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
  /**
   * Handle an incoming request.
   *
   * @param Request $request
   * @param Closure $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    if (Auth::check()) {
//      Если залогинен
      if (auth()->user()->is_admin) {
//        Если в свойствах стоит Admin
        return $next($request);
      }
    }

    return redirect()->route('index')->withErrors(['error' => 'Доступно только администраторам!']);
  }
}
