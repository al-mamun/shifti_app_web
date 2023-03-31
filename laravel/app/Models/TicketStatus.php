<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(string[] $status)
 * @method static truncate()
 * @method static select(string $string, string $string1)
 */
class TicketStatus extends Model
{
    use HasFactory;

    protected $guarded = [];
}
