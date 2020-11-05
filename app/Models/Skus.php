<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Skus
 * Класс Модель для Размеров
 *
 * @package App\Models
 */
class Skus extends Model
{
  use HasFactory;

  /**
   * Поля для работы с таблицей
   * @var string[]
   */
  protected $fillable = ['title', 'weight'];

  /**
   * Категория размера
   * @return BelongsTo
   */
  public function skus_category (): BelongsTo
  {
    return $this->belongsTo(SkusCategory::class, 'skus_category_id', 'id', 'skus_categories');
  }
}
