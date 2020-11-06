<?php
/*
 * Copyright (c) 2020.
 * The written code is completely free, full copying and modifications for improvement are allowed.
 * I am Fulliton https://github.com/ArtyshkoAndrey giving the right to everyone, without exception, to use this code.
 * Stable and optimized code =)
 */

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{

  public function index () {
    $user = auth()->user();
    $currencies = Currency::all();
    return view('profile.index', compact('user', 'currencies'));
  }

  public function update(Request $request) {
    $user = auth()->user();
    $request->validate([
      'country' => 'required|exists:countries,id',
      'city' => 'required|exists:cities,id',
      'street' => 'required|max:255',
      'contact_phone' => 'required|max:255',
      'currency' => 'required|string',
      'first_name' => 'required|string',
      'second_name' => 'required|string',
      'patronymic' => 'string',
      'email' => 'required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,'.$user->id
    ]);
    $data = $request->all();
    $user->update($data);
    $user->currency()->associate($data['currency']);
    $user->city()->associate($data['city']);
    $user->country()->associate($data['country']);
    $user->save();
    return redirect()->route('profile.index')->withSuccess(['Данные аккаунта изменены']);
  }

  public function updatePassword(Request $request) {
    $user = auth()->user();
    $request->validate([
      'password' => 'required|confirmed'
    ]);
    $user->password = Hash::make($request->password);
    $user->save();
    return redirect()->route('profile.index')->withSuccess(['Пароль изменён']);
  }

  public function updatePhoto(Request $request) {
    $user = auth()->user();
    $image = $request->file('photo');

    $imageName = time().'.'.$image->getClientOriginalExtension();

    $destinationPath = public_path('storage/avatar');

    $img = Image::make($image->getRealPath());
    $img
      ->fit(200)
      ->save($destinationPath . '/' . $imageName);
    File::delete($destinationPath . '/' . $user->avatar);

    $user->avatar = $imageName;
    $user->save();
    return redirect()->route('profile.index')->withSuccess(['Фотография обновлена']);
  }

}
