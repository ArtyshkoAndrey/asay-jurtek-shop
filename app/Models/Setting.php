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
}
