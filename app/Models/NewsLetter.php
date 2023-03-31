<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $news_letter_data)
 * @method static where(string $string, mixed $input)
 */
class NewsLetter extends Model
{
    use HasFactory;

    protected $guarded = [];
}
