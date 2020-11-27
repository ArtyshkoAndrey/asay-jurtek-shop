<?php

namespace App\Models;

use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LinkMenu
 *
 * @package App\Models
 * @property int $id
 * @property string $image
 * @property string $name
 * @property string $link
 * @property int $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category $category
 * @method static Builder|LinkMenu newModelQuery()
 * @method static Builder|LinkMenu newQuery()
 * @method static Builder|LinkMenu query()
 * @method static Builder|LinkMenu whereCategoryId($value)
 * @method static Builder|LinkMenu whereCreatedAt($value)
 * @method static Builder|LinkMenu whereId($value)
 * @method static Builder|LinkMenu whereImage($value)
 * @method static Builder|LinkMenu whereLink($value)
 * @method static Builder|LinkMenu whereName($value)
 * @method static Builder|LinkMenu whereUpdatedAt($value)
 * @mixin Eloquent
 */
class LinkMenu extends Model
{
  use HasFactory;

  /**
   * Поля для работы с таблицей
   *
   * @var string[]
   */
  protected $fillable = [
    'name',
    'link',
    'image'
  ];

  /**
   * @return string
   */
  public function getPhoto(): string
  {
    return asset('storage/link-menu/' . $this->image);
  }
//  protected static function boot()
//  {
//    parent::boot();
//
//    LinkMenu::deleting(function (LinkMenu  $linkMenu) {
//      File::delete(public_path('storage/link-menu/' . $linkMenu->image));
//    });
//  }

  public function category ()
  {
    return $this->belongsTo(Category::class);
  }

  /**
   * Override delete method
   *
   * @return bool|null
   * @throws Exception
   */
  public function delete()
  {
//    Удаление фотографии при удалении записи
    File::delete(public_path('storage/link-menu/' . $this->image));
    return parent::delete();
  }
}
