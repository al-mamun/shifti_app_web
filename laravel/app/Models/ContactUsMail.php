<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $data)
 * @method static latest()
 * @method static findOrfail(int $id)
 */
class ContactUsMail extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
}
