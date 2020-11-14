<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception as ExceptionAlias;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Application|Factory|View|Response
   */
  public function index(Request $request)
  {
    $users = User::query();
    if (($type = $request->input('type', 'all')) === 'admin') {
      $users = $users->where('is_admin', true);
    }

    if ($search = $request->input('search', null)) {
      $s = '%' . $search . '%';
      $users = $users->where('first_name', 'like', $s)->orWhere('second_name', 'like', $s);
    }

    $users = $users->paginate(10);

    return view('admin.user.index', compact('users', 'type', 'search'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return void
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return void
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function show(int $id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param User $user
   * @return Application|Factory|View|Response
   */
  public function edit(User $user)
  {
    return view('admin.user.edit', compact('user'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param User $user
   * @return Response
   */
  public function update(Request $request, User $user)
  {

    $data = $request->all();
    if (isset($request->password)) {
      $request->validate([
        'first_name' => 'required|string|max:255,min:3',
        'second_name' => 'required|string|max:255,min:3',
        'patronymic' => 'required|string|max:255,min:3',
        'password' => 'string|max:255|min:6|confirmed'
      ]);
      $data['password'] = Hash::make($data['password']);
    } else {
      $request->validate([
        'first_name' => 'required|string|max:255,min:3',
        'second_name' => 'required|string|max:255,min:3',
        'patronymic' => 'required|string|max:255,min:3'
      ]);
      unset($data['password']);
    }
    $user->update($data);
    return redirect()->route('admin.users.index')->withSuccess(['Пользователь '. $user->getFSName() . ' был изменён']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param User $user
   * @return Response
   * @throws ExceptionAlias
   */
  public function destroy(User $user)
  {
    $name = $user->getFSName();
    $user->delete();
    return redirect()->route('admin.users.index')->withSuccess(['Пользователь '. $name . ' был удалён']);
  }
}
