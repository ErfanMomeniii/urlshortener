<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\models\url
 *
 * @method static \Database\Factories\UrlFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Url newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Url newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Url query()
 * @mixin \Eloquent
 */
class Url extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'code'
    ];
}
