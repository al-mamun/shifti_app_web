<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static create(array $content)
 * @method static where(string $string, $id)
 * @method static findOrFail(int $i)
 */
class PageContent extends Model
{
    use HasFactory;

    protected $guarded = [];
}
