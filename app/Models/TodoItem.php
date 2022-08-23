<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TodoItem
 *
 * @property int $id
 * @property string $text
 * @property int $is_done
 * @property int $is_urgent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem whereIsDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem whereIsUrgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TodoItem extends Model
{
    use HasFactory;

    protected $fillable = [
      'text', 'is_done', 'is_urgent'
    ];


    public function isUrgent(bool $status)
    {
        $this->is_urgent = $status;
    }
}
