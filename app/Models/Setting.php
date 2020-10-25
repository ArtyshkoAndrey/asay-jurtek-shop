<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
  use HasFactory;
  protected $fillable = ['key', 'meta'];
  protected $casts    = ['meta' => 'string', 'key' => 'string'];

  public function statusSite ($status = null) {
    if ($status === null)
      return boolval($this->where('key', 'status')->first()->meta);
    else
      $this->where('key', 'status')->first()->update(['meta' => $status]);
  }

  public function setHeader () {
    $s = new Setting();
    $s->key = 'header';
    $s->meta = json_encode(array(
      'image' => 'http://zakaz/images/586e6940ea673b0ebbdc6668f59ca32a.jpg',
      'position' => 'right', //left
      'width' => '50',
      'color_gradient' => '#D1BC8A',
      'gradient_position' => 'left-to-right', //right-to-left
      'gradient' => true
    ));
    $s->save();
  }
}
