<?php
/*
 * Copyright (c) 2020.
 * The written code is completely free, full copying and modifications for improvement are allowed.
 * I am Fulliton https://github.com/ArtyshkoAndrey giving the right to everyone, without exception, to use this code.
 * Stable and optimized code =)
 */

namespace App\Models;

use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

/**
 * App\Models\News
 *
 * @package App\Models
 * @property int $id
 * @property string $image
 * @property string $content
 * @property string $description
 * @property string $title
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|News newModelQuery()
 * @method static Builder|News newQuery()
 * @method static Builder|News query()
 * @method static Builder|News whereContent($value)
 * @method static Builder|News whereCreatedAt($value)
 * @method static Builder|News whereDescription($value)
 * @method static Builder|News whereId($value)
 * @method static Builder|News whereImage($value)
 * @method static Builder|News whereTitle($value)
 * @method static Builder|News whereUpdatedAt($value)
 * @mixin Eloquent
 */
class News extends Model
{
  use HasFactory;

  /**
   * Поля доступные для работы в таблице
   *
   * @var string[]
   */
  protected $fillable = [
    'image',
    'title',
    'content',
    'description'
  ];

  /**
   * Override delete method
   *
   * @return bool|null
   * @throws Exception
   */
  public function delete()
  {
//    Удаление фотографии при удалении записи
    File::delete(public_path('storage/news/' . $this->image));
    return parent::delete();
  }
}
