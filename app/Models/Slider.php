<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static orderBy(string $string)
 * @method static findOrFail(int $id)
 * @method static where(string $string, int $int)
 */
class Slider extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function admin()
    {
        return $this->belongsTo(User::class, 'updated_by')->select('id', 'name');;
    }
}
