<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $users = User::query();
    if (($type = $request->input('type', 'all')) === 'all') {
      $users = $users;
    } else if ($type === 'admin') {
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
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    return view('admin.user.edit', compact('user'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
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
    return redirect()->route('admin.users.index')->withSuccess(['Пользователь '. $user->getIOName() . ' был изменён']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    $name = $user->getIOName();
    $user->delete();
    return redirect()->route('admin.users.index')->withSuccess(['Пользователь '. $name . ' был удалён']);
  }
}
