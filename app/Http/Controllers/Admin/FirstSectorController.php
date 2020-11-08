<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class FirstSectorController extends Controller
{
  public function index ()
  {
    $setting = Setting::where('key', 'header')->first();
    $header = $setting->meta;
    return view('admin.setting.first-sector.index', compact('header'));
  }

  public function update (Request $request)
  {
    $setting = Setting::where('key', 'header')->first();
    $name = $setting->meta->image;
    if ($image = $request->file('image')) {
      File::delete(public_path('storage/header/' . $name));
      $name = $this->cropImage($image);
    }

//    $setting->meta->image = $name;
//    $setting->meta->position = $request->position;
//    $setting->meta->width = 100;
//    $setting->meta->gradient_position = $request->gradient_position;
//    $setting->meta->text = $request->text;
//    $setting->meta->description = $request->description;
//    $setting->meta->text_btn = $request->text_btn;
//    $setting->meta->link_btn = $request->lin_btn;
//    $setting->meta->gradient = true;
//    $setting->meta->color_gradient = '#D1BC8A';
    $setting->meta = array(
      'width' => $request->width,
      'position' => $request->position,
      'image' => $name,
      'gradient_position' => $request->gradient_position,
      'text' => $request->text,
      'description' => $request->description,
      'text_btn' => $request->text_btn,
      'link_btn' => $request->link_btn,
      'gradient' => (bool) $request->gradient,
      'color_gradient' => $request->color_gradient,
      'text_center' => (bool) $request->text_center,
    );
    $setting->save();

    return redirect()->route('admin.setting.first-sector.index')->withSuccess(['Главный сектор обновлён']);
  }

  private function cropImage ($image) {
    $file = time().'_' .$image->getClientOriginalName();
    $destinationPath = public_path('storage/header');
    $name            = pathinfo($file, PATHINFO_FILENAME) . '.webp';
    $img             = Image::make($image->getRealPath())->encode('webp', 75);
    $img->save($destinationPath.'/'.$name);
    return $name;
  }
}
